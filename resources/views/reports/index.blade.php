<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('System Reports Hub') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Sales Report Builder -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="flex items-center mb-4 border-b pb-2">
                            <div class="bg-blue-100 p-3 rounded-full mr-4 text-blue-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold">Generate Sales Report (PDF)</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">Select a custom date range to pull all completed
                            commercial sales transactions onto a formal PDF document.</p>

                        <form method="GET" action="{{ route('reports.index') }}" class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="from" :value="__('From Date')" />
                                    <x-text-input id="from" class="block mt-1 w-full" type="date" name="from"
                                        required :value="$from" />
                                </div>
                                <div>
                                    <x-input-label for="to" :value="__('To Date')" />
                                    <x-text-input id="to" class="block mt-1 w-full" type="date" name="to"
                                        required :value="$to" />
                                </div>
                            </div>

                            <div class="flex justify-end pt-4 gap-3 flex-wrap">
                                <button type="submit" name="action" value="view"
                                    class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded shadow transition w-full md:w-auto">
                                    View Report on Screen
                                </button>
                                <button type="submit" formaction="{{ route('reports.sales') }}" formtarget="_blank"
                                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded shadow transition w-full md:w-auto flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                        </path>
                                    </svg>
                                    Open PDF
                                </button>
                                <button type="submit" name="download" value="1"
                                    formaction="{{ route('reports.sales') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded shadow transition w-full md:w-auto flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Download PDF
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Individual Orders Context -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 border-h">
                        <div class="flex items-center mb-4 border-b pb-2">
                            <div class="bg-green-100 p-3 rounded-full mr-4 text-green-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold">Order Invoices</h3>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">Looking to view a receipt for a specific order generated
                            by the cashier?</p>
                        <p class="text-sm font-medium text-gray-800 bg-gray-50 p-4 border rounded">
                            You can directly export PDF receipts inside the "View Details" section of any specific Order
                            transaction.
                        </p>

                        <div class="flex justify-end pt-5 mt-4 border-t">
                            <a href="{{ route('orders.index') }}"
                                class="bg-gray-800 hover:bg-gray-900 text-white font-bold py-2 px-6 rounded shadow transition w-full md:w-auto text-center border">
                                Browse Orders List &rarr;
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            @if ($orders)
                <div class="mt-8 bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-xl font-bold border-b pb-4 mb-6">Sales Results:
                            {{ \Carbon\Carbon::parse($from)->format('M d, Y') }} to
                            {{ \Carbon\Carbon::parse($to)->format('M d, Y') }}</h3>

                        @if ($orders->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                                    <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                        <tr>
                                            <th
                                                class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900 text-left">
                                                Order Ref</th>
                                            <th
                                                class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900 text-left">
                                                Date</th>
                                            <th
                                                class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900 text-left">
                                                Items Detailed</th>
                                            <th
                                                class="whitespace-nowrap px-4 py-3 font-semibold text-gray-900 text-right">
                                                Order Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @php $sum = 0; @endphp
                                        @foreach ($orders as $order)
                                            @php $sum += $order->total_amount; @endphp
                                            <tr>
                                                <td class="whitespace-nowrap px-4 py-4 font-bold text-indigo-600">
                                                    {{ $order->reference_no }}</td>
                                                <td class="whitespace-nowrap px-4 py-4 text-gray-700">
                                                    {{ $order->created_at->format('Y-m-d H:i') }}</td>
                                                <td class="px-4 py-4">
                                                    <ul class="list-disc pl-4 text-gray-600 text-xs space-y-1">
                                                        @foreach ($order->items as $item)
                                                            <li>{{ $item->quantity }}x
                                                                {{ $item->product->name ?? 'N/A' }} <span
                                                                    class="text-gray-400">({{ env('CURRENCY_SIGN') . number_format($item->subtotal, 2) }})</span>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </td>
                                                <td
                                                    class="whitespace-nowrap px-4 py-4 text-right font-bold text-gray-900">
                                                    {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="3"
                                                class="px-4 py-4 text-right font-black uppercase text-gray-600">Net
                                                Accumulated Revenue:</td>
                                            <td class="px-4 py-4 text-right font-black text-xl text-green-600">
                                                {{ env('CURRENCY_SIGN') . number_format($sum, 2) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-8 bg-red-50 text-red-600 font-semibold rounded">
                                No sales transactions recorded during this exact period!
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
