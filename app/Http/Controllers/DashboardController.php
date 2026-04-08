<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Purchase;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalSales = Order::sum('total_amount');
        
        $lowStockProducts = Product::whereColumn('stock_quantity', '<=', 'min_stock_alert')->get();
        $lowStockAlerts = $lowStockProducts->count();

        // Very basic chart data (Last 7 days sales)
        $recentOrders = Order::where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'asc')
            ->get()
            ->groupBy(function($date) {
                return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
            });

        $chartLabels = [];
        $chartData = [];

        foreach ($recentOrders as $date => $ordersGroup) {
            $chartLabels[] = $date;
            $chartData[] = $ordersGroup->sum('total_amount');
        }

        // Monthly Sales (Last 6 Months)
        $monthlyOrders = Order::selectRaw('sum(total_amount) as sums, DATE_FORMAT(created_at, "%Y-%m") as months')
            ->groupBy('months')
            ->orderBy('months', 'desc')
            ->limit(6)
            ->get();

        $monthlyLabels = [];
        $monthlyData = [];

        foreach ($monthlyOrders->reverse() as $data) {
            $monthlyLabels[] = \Carbon\Carbon::parse($data->months . '-01')->format('M Y');
            $monthlyData[] = $data->sums;
        }

        return view('dashboard', compact(
            'totalProducts', 'totalOrders', 'totalSales', 
            'lowStockAlerts', 'lowStockProducts', 
            'chartLabels', 'chartData',
            'monthlyLabels', 'monthlyData'
        ));
    }
}
