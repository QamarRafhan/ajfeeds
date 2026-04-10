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
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Ref No</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Supplier</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Status</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Total Cost</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Purchase Date</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($purchases as $purchase)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-4 py-3 font-bold text-indigo-600">
                                            {{ $purchase->reference_no }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-700 font-medium">
                                            {{ $purchase->supplier->name ?? 'Deleted' }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <span
                                                class="inline-flex items-center px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-600 border border-blue-100">
                                                {{ $purchase->status }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 font-bold">
                                            {{ env('CURRENCY_SIGN') . number_format($purchase->total_amount, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-500">
                                            {{ $purchase->created_at->format('M d, Y') }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-center">
                                            <a href="{{ route('purchases.show', $purchase) }}"
                                                class="inline-flex items-center px-4 py-1.5 bg-gray-100 text-gray-700 rounded-md hover:bg-gray-900 hover:text-white text-xs font-black uppercase tracking-widest transition border border-gray-200">
                                                View Details
                                            </a>
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
