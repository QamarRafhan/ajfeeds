<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Purchases
                        </h2>

                        <a href="{{ route('purchases.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            New Purchase
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Ref No.
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Supplier
                                    </th>
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
                                @forelse($purchases as $purchase)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                            {{ $purchase->reference_no }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $purchase->supplier->name ?? 'Deleted' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            <span
                                                class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700 capitalize">
                                                {{ $purchase->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            ${{ number_format($purchase->total_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $purchase->created_at->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <a href="{{ route('purchases.show', $purchase) }}"
                                                class="inline-block rounded bg-gray-600 px-4 py-2 text-xs font-medium text-white hover:bg-gray-700">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No purchases
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $purchases->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
