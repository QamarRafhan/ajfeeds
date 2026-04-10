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
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Ref No</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Cashier</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Status</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Total Amount</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Order Date</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-4 py-3 font-bold text-primary-600">
                                            {{ $order->reference_no }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700">
                                            {{ $order->user->name ?? 'System' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 font-semibold">
                                            {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-500">
                                            {{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-200 text-xs font-bold border border-gray-300">
                                                    View
                                                </a>
                                                <a href="{{ route('orders.edit', $order) }}"
                                                    class="inline-flex items-center px-3 py-1 bg-indigo-50 text-indigo-700 rounded-md hover:bg-indigo-100 text-xs font-bold border border-indigo-200">
                                                    Status
                                                </a>
                                            </div>
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
