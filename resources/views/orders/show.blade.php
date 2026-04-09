<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Order Details:') }} <span class="text-indigo-600 ml-1">{{ $order->reference_no }}</span>
            </h2>
            <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-900 transition font-medium">
                &larr; Back to Orders
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900">

                    <!-- Header Info -->
                    <div class="flex justify-between items-start mb-8 pb-6 border-b">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Billed To /
                                Cashier</p>
                            <p class="font-semibold text-lg">{{ $order->user->name ?? 'System Guest' }}</p>
                            <p class="text-sm text-gray-600">{{ $order->user->email ?? '' }}</p>
                        </div>
                        <div class="text-right border-l pl-6 border-gray-100">
                            <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Invoice Date
                            </p>
                            <p class="font-mono text-base">{{ $order->created_at->format('F d, Y') }}</p>

                            <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mt-4 mb-1">Status</p>
                            <span
                                class="inline-flex items-center justify-center rounded-full px-3 py-1 text-sm font-semibold capitalize
                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                {{ $order->status }}
                            </span>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Purchased Items</h3>
                    <div class="overflow-hidden border border-gray-200 rounded-lg mb-8">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left">
                                <tr>
                                    <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider">Product
                                        Name</th>
                                    <th class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider">SKU</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider text-right">
                                        Unit Price</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider text-right">
                                        Qty</th>
                                    <th
                                        class="px-6 py-3 font-semibold text-gray-600 uppercase tracking-wider text-right">
                                        Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($order->items as $item)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">
                                            {{ $item->product->name ?? 'Product Deleted' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-500 font-mono text-xs">
                                            {{ $item->product->sku ?? '-' }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-700">
                                            {{ env('CURRENCY_SIGN') . number_format($item->unit_price, 2) }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 font-semibold">
                                            {{ $item->quantity }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-gray-900 font-semibold">
                                            {{ env('CURRENCY_SIGN') . number_format($item->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-4 text-right font-bold text-gray-700 uppercase tracking-wider">
                                        Grand Total</td>
                                    <td class="px-6 py-4 text-right font-black text-indigo-700 text-lg">
                                        {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-4 border-t">
                        <a href="{{ route('orders.invoice.pdf', $order) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Save PDF
                        </a>
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            Print Invoice
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
