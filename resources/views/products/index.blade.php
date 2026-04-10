<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Products
                        </h2>

                        <a href="{{ route('products.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            + Create Product
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">SKU</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Image</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Product Name</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Category</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Price</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Stock</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($products as $product)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-4 py-3 font-bold text-primary-600">
                                            {{ $product->sku }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-10 w-10 rounded shadow-sm object-cover border border-gray-100">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center text-gray-400 border border-gray-100">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-900 font-medium">
                                            {{ $product->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            <span
                                                class="bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs font-bold">{{ $product->category->name ?? 'N/A' }}</span>
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 font-bold text-gray-800">
                                            {{ env('CURRENCY_SIGN') . number_format($product->sale_price, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            @if ($product->stock_quantity <= $product->min_stock_alert)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-black uppercase">
                                                    Low: {{ $product->stock_quantity }}
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-black uppercase">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-center">
                                            <div class="flex justify-center space-x-2">
                                                <a href="{{ route('products.edit', $product) }}"
                                                    class="p-2 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('products.destroy', $product) }}" method="POST"
                                                    class="sweet-alert-delete"
                                                    data-message="All data for this product will be lost!">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 bg-red-50 text-red-600 rounded-md hover:bg-red-600 hover:text-white transition">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                    </button>
                                                </form>
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
