<x-app-layout>
    <x-slot name="header">
        <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="orderForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Errors -->
            

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Products Section -->
                        <div class="mb-4 border-b pb-4">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Order Items</h3>
                            <p class="text-sm text-gray-500 mb-4">Stock deductions are handled automatically once the order is placed.</p>
                            
                            <table class="w-full text-left mb-4">
                                <thead>
                                    <tr class="bg-gray-50 text-sm text-gray-600">
                                        <th class="p-2">Product (Available Stock)</th>
                                        <th class="p-2 w-32">Quantity</th>
                                        <th class="p-2 w-24 text-center">Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-b">
                                            <td class="p-2">
                                                <select x-model="item.product_id" :name="'items['+index+'][product_id]'" 
                                                    x-init="$nextTick(() => { 
                                                        if(!$el.tomselect) {
                                                            new TomSelect($el, {
                                                                create: false,
                                                                sortField: { field: 'text', direction: 'asc' }
                                                            });
                                                        }
                                                    })"
                                                    class="w-full text-sm" required>
                                                    <option value="">Select a product...</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }} [Stock: {{ $product->stock_quantity }}] - ${{ number_format($product->sale_price, 2) }}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-2">
                                                <input type="number" x-model="item.quantity" :name="'items['+index+'][quantity]'" min="1" class="w-full border-gray-300 rounded focus:ring-indigo-500 text-sm" required>
                                            </td>
                                            <td class="p-2 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 text-sm font-bold p-2 bg-red-50 rounded hover:bg-red-100">X</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            
                            <button type="button" @click="addItem" class="bg-indigo-50 hover:bg-indigo-100 border border-indigo-200 text-indigo-700 text-sm font-semibold py-1.5 px-3 rounded inline-flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                Add Item Row
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('orders.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4 font-medium">Cancel</a>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded shadow transition ease-in-out duration-150">
                                Place Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            let oldItems = @json(old('items', []));
            if (oldItems.length === 0) {
                oldItems = [{ product_id: '', quantity: 1 }];
            }

            Alpine.data('orderForm', () => ({
                items: oldItems,
                addItem() {
                    this.items.push({ product_id: '', quantity: 1 });
                },
                removeItem(index) {
                    if(this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                }
            }))
        })
    </script>
</x-app-layout>
