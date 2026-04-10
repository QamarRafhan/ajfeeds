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
        return view('orders.create', compact('products', 'customers', 'product_prices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $paid_amount = $request->paid_amount ?? 0;
            
            // // Handle Quick Add Customer with extreme care
            // $customer_input = $request->customer_id;
            // $customer_id = $customer_input;
            
            // // If the input is not numeric, or it is numeric but no such ID exists in our database,
            // // treat it as a new customer name string and create the record.
            // if (!is_numeric($customer_input) || !Customer::where('id', $customer_input)->exists()) {
            //     $customer = Customer::create(['name' => $customer_input]);
            //     $customer_id = $customer->id;
            // }

            $order = Order::create([
                'user_id' => auth()->id() ?? 1,
                'customer_id' => $request->customer_id,
                'reference_no' => 'ORD-' . strtoupper(Str::random(6)),
                'status' => $request->status ?? 'pending',
                'total_amount' => 0,
                'paid_amount' => $paid_amount,
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

                // Decrease stock
                $product->decrement('stock_quantity', $item['quantity']);

                // Create StockLog
                StockLog::create([
                    'product_id' => $product->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'reference_type' => Order::class,
                    'reference_id' => $order->id,
                    'description' => 'Stock out via Order ' . $order->reference_no,
                ]);
            }

            // Determine payment status
            if ($paid_amount >= $total) {
                $order->payment_status = 'paid';
                
                if ($paid_amount > $total) {
                    // Always use the resolved $customer_id to ensure credits are saved to new customers too
                    $customerRecord = Customer::find($request->customer_id);
                    if ($customerRecord) {
                        $customerRecord->increment('credit_balance', ($paid_amount - $total));
                    }
                }
            } elseif ($paid_amount > 0) {
                $order->payment_status = 'partial';
            } else {
                $order->payment_status = 'unpaid';
            }

            $order->total_amount = $total;
            $order->save();

            if ($paid_amount > 0) {
                $order->payments()->create([
                    'type' => 'incoming',
                    'amount' => $paid_amount,
                    'method' => 'Cash',
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
            'method' => 'required|in:Cash,Bank,Online',
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
