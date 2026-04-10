<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Sales Orders
                        </h2>

                        <a href="{{ route('orders.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            Create Order
                        </a>
                    </div>

                    <!-- Advanced Search & Filter -->
                    <div class="flex flex-wrap gap-4 mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100 items-end">
                        <form method="GET" action="{{ route('orders.index') }}"
                            class="flex flex-wrap gap-4 w-full md:w-auto items-end">
                            <div class="w-full md:w-48">
                                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Status
                                    Filter</label>
                                <select name="status" onchange="this.form.submit()" class="text-sm">
                                    <option value="">All Statuses</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                        Pending</option>
                                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="bg-gray-800 text-white px-4 py-2 rounded text-sm font-bold hover:bg-black transition">Apply
                                Filter</button>
                            <a href="{{ route('orders.index') }}"
                                class="text-sm text-gray-500 hover:text-gray-700 underline px-2 py-2">Reset</a>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50 text-[11px] uppercase tracking-widest font-black text-gray-500">
                                <tr>
                                    <th class="px-6 py-4">Reference</th>
                                    <th class="px-6 py-4">Customer</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4">Fulfillment</th>
                                    <th class="px-6 py-4">Payment</th>
                                    <th class="px-6 py-4 text-right">Total</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="font-mono text-xs font-bold text-indigo-600">{{ $order->reference_no }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">
                                                {{ $order->customer->name ?? 'Guest/Unknown' }}</div>
                                            <div class="text-[10px] text-gray-400 font-medium">
                                                {{ $order->customer->phone ?? '' }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            {{ $order->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-black capitalize
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-amber-100 text-amber-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-black uppercase tracking-tighter
                                                {{ $order->payment_status === 'paid' ? 'bg-blue-100 text-blue-700' : ($order->payment_status === 'partial' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600') }}">
                                                {{ $order->payment_status }}
                                            </span>
                                            @if ($order->payment_status !== 'paid')
                                                <div class="text-[9px] text-red-400 font-bold mt-1">
                                                    Due:
                                                    {{ env('CURRENCY_SIGN') }}{{ number_format($order->total_amount - $order->paid_amount, 2) }}
                                                </div>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-black text-gray-900">
                                            {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}
                                        </td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="text-indigo-600 hover:text-indigo-900 font-bold">Details</a>
                                            <a href="{{ route('orders.edit', $order) }}"
                                                class="text-gray-400 hover:text-gray-600">Update</a>
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
