<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\StockLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use App\Models\Customer;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'customer');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('reference_no', 'like', '%' . $request->search . '%');
        }

        $orders = $query->latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $products = Product::where('stock_quantity', '>', 0)->get();
        $customers = Customer::all();
        $product_prices = $products->pluck('sale_price', 'id');
        $customer_credits = $customers->pluck('credit_balance', 'id')->map(fn($v) => (float) $v);
        return view('orders.create', compact('products', 'customers', 'product_prices', 'customer_credits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'nullable|numeric|min:0',
            'use_credit' => 'nullable|boolean',
            'add_to_credit' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($request) {
            $paid_amount = (float) ($request->paid_amount ?? 0);
            $use_credit = (bool) ($request->use_credit ?? false);
            $add_to_credit = (bool) ($request->add_to_credit ?? false);

            $customer = Customer::findOrFail($request->customer_id);
            $available_credit = (float) ($customer->credit_balance ?? 0);
            $effective_paid = $paid_amount;

            // Build the order first with amount = 0 (we calculate total below)
            $order = Order::create([
                'user_id' => auth()->id() ?? 1,
                'customer_id' => $request->customer_id,
                'reference_no' => 'ORD-' . strtoupper(Str::random(6)),
                'status' => $request->status ?? 'pending',
                'total_amount' => 0,
                'paid_amount' => 0,
                'payment_status' => 'unpaid',
            ]);

            $total = 0;
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                if ($product->stock_quantity < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'items' => "Not enough stock for {$product->name}. Only {$product->stock_quantity} remaining."
                    ]);
                }

                $subtotal = $item['quantity'] * $product->sale_price;
                $total += $subtotal;

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->sale_price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);

                StockLog::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference_type' => Order::class,
                    'reference_id' => $order->id,
                    'description' => 'Stock out via Order ' . $order->reference_no,
                ]);
            }

            $remaining = $total;

            // 1. Apply CASH FIRST
            $cash_used = min($paid_amount, $remaining);
            $remaining -= $cash_used;

            // 2. Apply CREDIT if allowed
            $credit_used = 0;
            if ($use_credit && $available_credit > 0 && $remaining > 0) {
                $credit_used = min($available_credit, $remaining); // return minimum value from both
                $customer->decrement('credit_balance', $credit_used);
                $remaining -= $credit_used;
                $effective_paid += $credit_used;
            }

            // 3. OVERPAYMENT → ADD TO CREDIT (ONLY CASH CAN CREATE CREDIT)
            $overpayment = max(0, $paid_amount - $total);  // return maximum value from both

            if ($overpayment > 0 && $add_to_credit) {
                $effective_paid -= $overpayment;
                $customer->increment('credit_balance', $overpayment);
            }

            // 4. PAYMENT STATUS
            if ($remaining == 0) {
                $order->payment_status = 'paid';
            } elseif ($cash_used + $credit_used > 0) {
                $order->payment_status = 'partial';
            } else {
                $order->payment_status = 'unpaid';
            }

            // 5. SAVE ORDER (IMPORTANT FIX)
            $order->total_amount = $total;
            $order->paid_amount = $effective_paid; //  ONLY CASH STORED
            $order->save();

            // Record cash payment entry (not credit)
            if ($cash_used > 0) {
                $order->payments()->create([
                    'type' => 'incoming',
                    'amount' => $cash_used,
                    'method' => 'Cash',
                ]);
            }
            // Record a credit-applied entry for transparency
            if ($credit_used > 0) {
                $order->payments()->create([
                    'type' => 'incoming',
                    'amount' => $credit_used,
                    'method' => 'Credit',
                ]);
            }
        });

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        $order->load(['items.product', 'user', 'customer', 'payments']);
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        return view('orders.edit', compact('order'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    public function collectPayment(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'method' => 'required|in:Cash,Bank,Online,Credit',
        ]);

        DB::transaction(function () use ($request, $order) {
            $amount = $request->amount;
            $order->increment('paid_amount', $amount);

            $order->refresh();
            if ($order->paid_amount >= $order->total_amount) {
                $order->update(['payment_status' => 'paid']);
            } else {
                $order->update(['payment_status' => 'partial']);
            }

            $order->payments()->create([
                'type' => 'incoming',
                'amount' => $amount,
                'method' => $request->method,
            ]);
        });

        return redirect()->back()->with('success', 'Manual payment recorded successfully.');
    }
}
