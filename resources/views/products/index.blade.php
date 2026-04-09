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
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">SKU</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Image
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Product
                                        Name</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Category
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Price
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Stock
                                    </th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($products as $product)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                            {{ $product->sku }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            @if ($product->image)
                                                <img src="{{ asset('storage/' . $product->image) }}"
                                                    alt="{{ $product->name }}"
                                                    class="h-10 w-10 rounded shadow-sm object-cover">
                                            @else
                                                <div
                                                    class="h-10 w-10 rounded bg-gray-100 flex items-center justify-center text-gray-400">
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
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $product->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $product->category->name ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            ${{ number_format($product->sale_price, 2) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2">
                                            @if ($product->stock_quantity <= $product->min_stock_alert)
                                                <span
                                                    class="inline-flex items-center justify-center rounded-full bg-red-100 px-2.5 py-0.5 text-red-700">
                                                    {{ $product->stock_quantity }} (Low)
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center justify-center rounded-full bg-green-100 px-2.5 py-0.5 text-green-700">
                                                    {{ $product->stock_quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <!-- Just placeholders for actions, proper UI would use icons from eg. heroicons -->
                                            <a href="{{ route('products.edit', $product) }}"
                                                class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">
                                                Edit
                                            </a>
                                            <!-- Delete button goes here with form -->
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">No products
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
