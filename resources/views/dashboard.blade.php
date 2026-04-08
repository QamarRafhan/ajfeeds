<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <!-- Total Products -->
                <div class="bg-white overflow-hidden shadow-sm flex flex-col p-6 rounded-lg w-full">
                    <p class="text-sm font-medium text-gray-500">Total Products</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalProducts) }}</p>
                </div>
                <!-- Total Orders -->
                <div class="bg-white overflow-hidden shadow-sm flex flex-col p-6 rounded-lg w-full">
                    <p class="text-sm font-medium text-gray-500">Total Orders</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ number_format($totalOrders) }}</p>
                </div>
                <!-- Total Sales -->
                <div class="bg-white overflow-hidden shadow-sm flex flex-col p-6 rounded-lg w-full">
                    <p class="text-sm font-medium text-gray-500">Total Sales</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($totalSales, 2) }}</p>
                </div>
                <!-- Low Stock Alerts -->
                <a href="{{ route('products.index') }}" class="bg-red-50 hover:bg-red-100 transition border border-red-200 overflow-hidden shadow-sm flex flex-col p-6 rounded-lg w-full block">
                    <p class="text-sm font-medium text-red-600">Low Stock Alerts</p>
                    <p class="text-3xl font-bold text-red-700 mt-2">{{ number_format($lowStockAlerts) }}</p>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="md:col-span-2 bg-white shadow-sm p-6 rounded-lg overflow-hidden relative">
                    <div class="flex justify-between items-center border-b pb-2">
                        <h3 class="text-lg font-semibold text-gray-800">Sales Chart (Last 7 Days)</h3>
                        <a href="{{ route('reports.sales') }}" target="_blank" class="inline-flex items-center px-3 py-1 bg-green-600 hover:bg-green-700 text-white text-xs font-semibold rounded transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Download Report
                        </a>
                    </div>
                    <div class="h-64 mt-4 relative">
                        <canvas id="recentSalesChart"></canvas>
                    </div>
                </div>

                <div class="md:col-span-1 bg-white shadow-sm p-6 rounded-lg overflow-hidden">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Monthly Growth</h3>
                    <div class="h-64 mt-4 relative">
                        <canvas id="monthlySalesChart"></canvas>
                    </div>
                </div>

                <div class="md:col-span-3 bg-white shadow-sm p-6 rounded-lg overflow-hidden">
                    <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Low Stock Products</h3>
                    <ul class="mt-4 space-y-3">
                        @forelse ($lowStockProducts as $product)
                            <li>
                                <a href="{{ route('products.edit', $product) }}" class="flex justify-between items-center bg-red-50 hover:bg-red-100 transition p-2 rounded group">
                                    <span class="text-sm font-medium text-red-700 group-hover:underline">{{ $product->name }}</span>
                                    <span class="text-xs bg-red-200 text-red-800 px-2 py-1 rounded-full">{{ $product->stock_quantity }} left</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-sm text-gray-500 italic">No low stock items!</li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>
    <!-- Add Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Chart 1: Last 7 Days Sales (Bar)
            const ctx1 = document.getElementById('recentSalesChart').getContext('2d');
            new Chart(ctx1, {
                type: 'bar',
                data: {
                    labels: @json($chartLabels),
                    datasets: [{
                        label: 'Total Revenue ($)',
                        data: @json($chartData),
                        backgroundColor: '#3b82f6',
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });

            // Chart 2: Monthly Revenue (Line)
            const ctx2 = document.getElementById('monthlySalesChart').getContext('2d');
            new Chart(ctx2, {
                type: 'line',
                data: {
                    labels: @json($monthlyLabels),
                    datasets: [{
                        label: 'Monthly Revenue ($)',
                        data: @json($monthlyData),
                        borderColor: '#10b981',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: { y: { beginAtZero: true } }
                }
            });
        });
    </script>
</x-app-layout>
