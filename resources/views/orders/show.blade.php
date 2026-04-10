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
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-6 border-b">
                        <div>
                            <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Customer /
                                Client</p>
                            <p class="font-semibold text-lg text-indigo-700">
                                {{ $order->customer->name ?? 'Guest/Unknown' }}</p>
                            <p class="text-xs text-gray-500">{{ $order->customer->phone ?? 'No Phone' }} |
                                {{ $order->customer->email ?? 'No Email' }}</p>
                            <p class="text-[10px] text-gray-400 mt-1 uppercase">{{ $order->customer->address ?? '' }}
                            </p>
                        </div>
                        <div class="text-right border-l pl-6 border-gray-100 grid grid-cols-2 gap-4">
                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Invoice
                                    Date</p>
                                <p class="font-mono text-base">{{ $order->created_at->format('F d, Y') }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-500 uppercase tracking-wider font-semibold mb-1">Status</p>
                                <div class="flex flex-col items-end gap-1">
                                    <span
                                        class="inline-flex items-center justify-center rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-tighter {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">Fulfillment:
                                        {{ $order->status }}</span>
                                    <span
                                        class="inline-flex items-center justify-center rounded-full px-3 py-1 text-[10px] font-black uppercase tracking-tighter {{ $order->payment_status === 'paid' ? 'bg-blue-100 text-blue-700' : 'bg-purple-100 text-purple-700' }}">Payment:
                                        {{ $order->payment_status }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Purchased Items</h3>
                    <div class="overflow-hidden border border-gray-200 rounded-lg mb-8 shadow-sm">
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
                            <tfoot class="bg-gray-50 border-t-2 border-gray-200 font-black">
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-4 text-right text-gray-700 uppercase tracking-wider">Order Total
                                    </td>
                                    <td class="px-6 py-4 text-right text-indigo-700 text-lg">
                                        {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="4"
                                        class="px-6 py-4 text-right text-green-700 uppercase tracking-wider">Amount Paid
                                    </td>
                                    <td class="px-6 py-4 text-right text-green-700">
                                        {{ env('CURRENCY_SIGN') . number_format($order->paid_amount, 2) }}</td>
                                </tr>
                                @if ($order->total_amount > $order->paid_amount)
                                    <tr class="bg-red-50">
                                        <td colspan="4"
                                            class="px-6 py-4 text-right text-red-700 uppercase tracking-wider">Current
                                            Balance Due</td>
                                        <td class="px-6 py-4 text-right text-red-700 text-xl font-black italic">
                                            {{ env('CURRENCY_SIGN') . number_format($order->total_amount - $order->paid_amount, 2) }}
                                        </td>
                                    </tr>
                                @endif
                            </tfoot>
                        </table>
                    </div>

                    <!-- Payment Section -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-12 mb-8">
                        <!-- History -->
                        <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                            <h4 class="text-sm font-black uppercase text-gray-500 mb-4 tracking-widest">Transaction
                                History</h4>
                            <div class="space-y-3">
                                @forelse($order->payments as $payment)
                                    <div
                                        class="flex justify-between items-center bg-white p-3 rounded-lg shadow-sm border border-gray-100">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center mr-3">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-gray-800 tracking-tight">
                                                    {{ $payment->method }} Payment Received</p>
                                                <p class="text-[10px] text-gray-400">
                                                    {{ $payment->created_at->format('M d, Y - H:i') }}</p>
                                            </div>
                                        </div>
                                        <p class="text-sm font-black text-green-600">+
                                            {{ env('CURRENCY_SIGN') }}{{ number_format($payment->amount, 2) }}</p>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic">No payments recorded yet.</p>
                                @endforelse
                            </div>
                        </div>

                        <!-- Manual Payment Form -->
                        @if ($order->payment_status !== 'paid' && $order->status !== 'cancelled')
                            <div class="bg-indigo-50/30 rounded-xl p-6 border border-indigo-100">
                                <h4 class="text-sm font-black uppercase text-indigo-700 mb-4 tracking-widest">Settle
                                    Outstanding Balance</h4>
                                <form action="{{ route('orders.payments.collect', $order) }}" method="POST"
                                    class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <x-input-label for="amount" :value="__('Payment Amount')" class="text-indigo-700" />
                                            <div class="relative mt-1">
                                                <span
                                                    class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold text-gray-400">{{ env('CURRENCY_SIGN') }}</span>
                                                <input id="amount" type="number" name="amount" step="0.01"
                                                    min="0.01"
                                                    max="{{ $order->total_amount - $order->paid_amount }}"
                                                    class="pl-8 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-black"
                                                    required
                                                    value="{{ $order->total_amount - $order->paid_amount }}" />
                                            </div>
                                        </div>
                                        <div>
                                            <x-input-label for="method" :value="__('Source Method')" class="text-indigo-700" />
                                            <select id="method" name="method"
                                                class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm font-bold"
                                                required>
                                                <option value="Cash">Cash</option>
                                                <option value="Bank">Bank Transfer</option>
                                                <option value="Online">Online Gateway</option>
                                            </select>
                                        </div>
                                    </div>
                                    <button type="submit"
                                        class="w-full inline-flex justify-center items-center px-4 py-3 bg-indigo-600 border border-transparent rounded-md font-black text-[10px] text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-md">
                                        Confirm Collection
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex justify-end gap-3 pt-6 border-t font-black">
                        <a href="{{ route('orders.edit', $order) }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-indigo-200 rounded-md font-black text-[10px] text-indigo-700 uppercase tracking-widest hover:bg-indigo-50 transition shadow-sm">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                            Fulfillment
                        </a>
                        <a href="{{ route('orders.invoice.pdf', $order) }}" target="_blank"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-black text-[10px] text-white uppercase tracking-widest hover:bg-indigo-700 transition shadow-md">
                            <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Download PDF
                        </a>
                        <button onclick="window.print()"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-black text-[10px] text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
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
