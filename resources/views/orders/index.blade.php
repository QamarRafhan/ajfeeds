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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Order
                                        Ref No.</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">
                                        Cashier/User</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Status
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Total
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Date
                                    </th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($orders as $order)
                                    <tr class="hover:bg-gray-50">
                                        <td class="whitespace-nowrap px-4 py-2 font-bold text-gray-900">
                                            {{ $order->reference_no }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $order->user->name ?? 'System' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            <span
                                                class="inline-flex items-center justify-center rounded-full px-2.5 py-0.5 text-xs font-semibold capitalize
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' : ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ env('CURRENCY_SIGN') . number_format($order->total_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $order->created_at->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <a href="{{ route('orders.show', $order) }}"
                                                class="inline-block rounded bg-gray-600 px-4 py-2 text-xs font-medium text-white hover:bg-gray-700">View
                                                Details</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No orders found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
