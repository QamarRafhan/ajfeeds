<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $orders = null;
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));

        if ($request->has('action') && $request->action === 'view') {
            $orders = Order::with(['user', 'items.product'])
                ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
                ->where('status', 'completed')
                ->get();
        }

        return view('reports.index', compact('orders', 'from', 'to'));
    }

    public function orderInvoicePdf(Order $order)
    {
        $order->load('items.product', 'user');

        $pdf = Pdf::loadView('reports.invoice', compact('order'));
        return $pdf->download('invoice-' . $order->reference_no . '.pdf');
    }

    public function salesReport(Request $request)
    {
        $from = $request->input('from', now()->startOfMonth()->format('Y-m-d'));
        $to = $request->input('to', now()->format('Y-m-d'));

        $orders = Order::with(['user', 'items.product'])
            ->whereBetween('created_at', [$from . ' 00:00:00', $to . ' 23:59:59'])
            ->where('status', 'completed')
            ->get();

        $pdf = Pdf::loadView('reports.sales', compact('orders', 'from', 'to'));
        
        if ($request->has('download')) {
            return $pdf->download('sales-report-' . $from . '-to-' . $to . '.pdf');
        }
        
        return $pdf->stream('sales-report-' . $from . '-to-' . $to . '.pdf');
    }
}
