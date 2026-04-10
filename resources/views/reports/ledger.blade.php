<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Client Financial Ledger') }}
            </h2>
            <div class="flex gap-2">
                <button onclick="window.print()"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-xs font-bold border border-gray-300 transition">
                    Print Statement
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Total Outstanding
                        Debt</p>
                    <h4 class="text-3xl font-black text-red-600">
                        {{ env('CURRENCY_SIGN') }}{{ number_format($customers->sum(fn($c) => $c->orders->sum('total_amount') - $c->orders->sum('paid_amount')), 2) }}
                    </h4>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Total Advance Credit
                    </p>
                    <h4 class="text-3xl font-black text-green-600">
                        {{ env('CURRENCY_SIGN') }}{{ number_format($customers->sum('credit_balance'), 2) }}
                    </h4>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Active Accounts</p>
                    <h4 class="text-3xl font-black text-indigo-700">
                        {{ $customers->count() }}
                    </h4>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-100">
                <div class="p-8 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50 text-[11px] uppercase tracking-widest font-black text-gray-500">
                                <tr>
                                    <th class="px-6 py-4 text-left">Customer</th>
                                    <th class="px-6 py-4 text-right">Total Purchased</th>
                                    <th class="px-6 py-4 text-right">Total Paid</th>
                                    <th class="px-6 py-4 text-right">Balance Due</th>
                                    <th class="px-6 py-4 text-right">Advance Credit</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($customers as $customer)
                                    @php
                                        $total_purchased = $customer->orders->sum('total_amount');
                                        $total_paid = $customer->orders->sum('paid_amount');
                                        $balance = $total_purchased - $total_paid;
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900 capitalize">
                                                {{ $customer->name }}</div>
                                            <div class="text-[10px] text-gray-400 font-medium">
                                                {{ $customer->phone ?? 'No Phone' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-gray-800">
                                            {{ env('CURRENCY_SIGN') }}{{ number_format($total_purchased, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-green-600">
                                            {{ env('CURRENCY_SIGN') }}{{ number_format($total_paid, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right">
                                            @if ($balance > 0)
                                                <span class="text-sm font-black text-red-600 italic">
                                                    {{ env('CURRENCY_SIGN') }}{{ number_format($balance, 2) }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-400">Clear</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right font-bold text-indigo-600">
                                            {{ env('CURRENCY_SIGN') }}{{ number_format($customer->credit_balance, 2) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-xs font-black">
                                            <a href="{{ route('customers.show', $customer) }}"
                                                class="text-indigo-600 hover:text-indigo-900">Full Profile</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
