<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payments Tracker') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 flex justify-between border-b">
                     <p class="font-medium text-gray-700">Accounting Records</p>
                </div>
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Type</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Method</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Amount</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Reference Link</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($payments ?? collect() as $payment)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium">
                                            @if($payment->type === 'incoming')
                                                <span class="text-green-600 font-semibold">&plus; Incoming</span>
                                            @else
                                                <span class="text-red-500 font-semibold">&minus; Outgoing</span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $payment->method }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-900 font-bold">${{ number_format($payment->amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ class_basename($payment->reference_type) }} #{{ $payment->reference_id }}
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700 text-xs">{{ $payment->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No payment records found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
