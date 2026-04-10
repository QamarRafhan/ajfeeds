<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Breadcrumbs / Action Bar -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h2 class="text-3xl font-black text-gray-800 tracking-tight">Staff Performance Report</h2>
                    <p class="text-sm text-gray-500 font-medium">Detailed activity ledger for <span
                            class="text-primary-600 font-bold">{{ $user->name }}</span></p>
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('users.index') }}"
                        class="inline-flex items-center px-4 py-2 bg-white border border-gray-200 rounded-lg text-sm font-bold text-gray-600 hover:bg-gray-50 transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Staff
                    </a>
                    <button onclick="window.print()"
                        class="inline-flex items-center px-4 py-2 bg-gray-900 border border-transparent rounded-lg text-sm font-bold text-white hover:bg-black transition shadow-lg">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                        </svg>
                        Print Activity
                    </button>
                </div>
            </div>

            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white to-indigo-50/30">
                    <p class="text-[10px] font-black text-indigo-400 uppercase tracking-widest mb-1">Total Orders</p>
                    <p class="text-3xl font-black text-gray-900">{{ number_format($stats['total_orders']) }}</p>
                    <div class="mt-2 text-xs font-bold text-gray-400">Lifetime Transactions</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white to-green-50/30">
                    <p class="text-[10px] font-black text-green-400 uppercase tracking-widest mb-1">Cash Generated</p>
                    <p class="text-3xl font-black text-gray-900">
                        {{ env('CURRENCY_SIGN') }}{{ number_format($stats['total_sales'], 2) }}</p>
                    <div class="mt-2 text-xs font-bold text-gray-400">Total Completed Value</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white to-yellow-50/30">
                    <p class="text-[10px] font-black text-yellow-500 uppercase tracking-widest mb-1">Active / Pending
                    </p>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['pending_orders'] }}</p>
                    <div class="mt-2 text-xs font-bold text-gray-400">Awaiting Settlement</div>
                </div>

                <div
                    class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 bg-gradient-to-br from-white to-red-50/30">
                    <p class="text-[10px] font-black text-red-400 uppercase tracking-widest mb-1">Cancelled</p>
                    <p class="text-3xl font-black text-gray-900">{{ $stats['cancelled_orders'] }}</p>
                    <div class="mt-2 text-xs font-bold text-gray-400">Voided Transactions</div>
                </div>
            </div>

            <!-- Detailed Ledger Table -->
            <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-200">
                <div class="px-8 py-6 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="text-sm font-black text-gray-800 uppercase tracking-widest">Transaction Ledger</h3>
                    <span
                        class="px-3 py-1 bg-white border border-gray-200 rounded-full text-[10px] font-bold text-gray-500">Live
                        Data</span>
                </div>
                <div class="p-8">
                    <table class="datatable w-full text-sm text-left">
                        <thead>
                            <tr class="text-gray-400 uppercase text-[10px] font-black tracking-widest">
                                <th class="px-4 py-3">Order Ref</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Amount</th>
                                <th class="px-4 py-3">Date Processed</th>
                                <th class="px-4 py-3 text-center">Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $order)
                                <tr class="hover:bg-gray-50 transition border-b border-gray-50 last:border-0">
                                    <td class="px-4 py-4 font-bold text-indigo-600">{{ $order->reference_no }}</td>
                                    <td class="px-4 py-4">
                                        <span
                                            class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest
                                            {{ $order->status === 'completed' ? 'bg-green-50 text-green-700 border border-green-100' : ($order->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-100' : 'bg-yellow-50 text-yellow-700 border border-yellow-100') }}">
                                            {{ $order->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 font-black text-gray-800">
                                        {{ env('CURRENCY_SIGN') }}{{ number_format($order->total_amount, 2) }}
                                    </td>
                                    <td class="px-4 py-4 text-xs font-bold text-gray-400 uppercase">
                                        {{ $order->created_at->format('d M Y, h:i A') }}
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        <a href="{{ route('orders.show', $order) }}"
                                            class="text-indigo-500 hover:text-indigo-800 font-black text-[10px] uppercase tracking-tighter underline underline-offset-4">
                                            Quick View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
