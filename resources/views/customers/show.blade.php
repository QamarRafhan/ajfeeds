<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight capitalize">
                    {{ $customer->name }}
                </h2>
                <p class="text-xs text-gray-400 font-medium mt-0.5">Client Full Profile &amp; Ledger</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}"
                    class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-600 hover:text-white text-xs font-black uppercase tracking-widest transition border border-indigo-200">
                    Edit Client
                </a>
                <a href="{{ route('reports.ledger') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-xs font-black uppercase tracking-widest transition border border-gray-200">
                    ← Back to Ledger
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Stats Cards --}}
            @php
                $totalPurchased = $customer->orders->sum('total_amount');
                $totalPaid      = $customer->orders->sum('paid_amount');
                $balanceDue     = max(0, $totalPurchased - $totalPaid);
                $credit         = $customer->credit_balance ?? 0;
            @endphp

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Total Purchased</p>
                    <h4 class="text-2xl font-black text-gray-800">{{ env('CURRENCY_SIGN') }}{{ number_format($totalPurchased, 2) }}</h4>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Total Paid</p>
                    <h4 class="text-2xl font-black text-green-600">{{ env('CURRENCY_SIGN') }}{{ number_format($totalPaid, 2) }}</h4>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Balance Due</p>
                    <h4 class="text-2xl font-black {{ $balanceDue > 0 ? 'text-red-600' : 'text-gray-400' }}">
                        {{ $balanceDue > 0 ? env('CURRENCY_SIGN') . number_format($balanceDue, 2) : 'Settled' }}
                    </h4>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-[10px] font-black uppercase text-gray-400 tracking-widest mb-1">Advance Credit</p>
                    <h4 class="text-2xl font-black {{ $credit > 0 ? 'text-indigo-600' : 'text-gray-400' }}">
                        {{ $credit > 0 ? env('CURRENCY_SIGN') . number_format($credit, 2) : 'None' }}
                    </h4>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Client Info --}}
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-4">Contact Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span class="font-bold text-gray-800 capitalize">{{ $customer->name }}</span>
                        </div>
                        @if($customer->phone)
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            <span class="text-gray-600 font-mono">{{ $customer->phone }}</span>
                        </div>
                        @endif
                        @if($customer->email)
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span class="text-gray-600">{{ $customer->email }}</span>
                        </div>
                        @endif
                        @if($customer->address)
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            <span class="text-gray-600">{{ $customer->address }}</span>
                        </div>
                        @endif
                        <div class="flex items-start gap-3">
                            <svg class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span class="text-gray-400 text-xs">Client since {{ $customer->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="md:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-xs font-black uppercase text-gray-400 tracking-widest mb-4">Order History ({{ $customer->orders->count() }} orders)</h3>
                    @if($customer->orders->isEmpty())
                        <p class="text-sm text-gray-400 italic">No orders yet.</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full text-sm">
                                <thead>
                                    <tr class="text-[10px] uppercase tracking-widest font-black text-gray-400 border-b">
                                        <th class="pb-2 text-left">Ref</th>
                                        <th class="pb-2 text-left">Date</th>
                                        <th class="pb-2 text-right">Total</th>
                                        <th class="pb-2 text-right">Paid</th>
                                        <th class="pb-2 text-center">Status</th>
                                        <th class="pb-2 text-right">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($customer->orders->sortByDesc('created_at') as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="py-2 font-mono text-xs font-bold text-indigo-600">{{ $order->reference_no }}</td>
                                        <td class="py-2 text-gray-400 text-xs">{{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="py-2 text-right font-bold text-gray-800">{{ env('CURRENCY_SIGN') }}{{ number_format($order->total_amount, 2) }}</td>
                                        <td class="py-2 text-right font-bold text-green-600">{{ env('CURRENCY_SIGN') }}{{ number_format($order->paid_amount, 2) }}</td>
                                        <td class="py-2 text-center">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[9px] font-black uppercase
                                                {{ $order->payment_status === 'paid' ? 'bg-green-100 text-green-700' : ($order->payment_status === 'partial' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-600') }}">
                                                {{ $order->payment_status }}
                                            </span>
                                        </td>
                                        <td class="py-2 text-right">
                                            <a href="{{ route('orders.show', $order) }}" class="text-[10px] font-black text-indigo-500 hover:text-indigo-900 uppercase tracking-tight">View</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
