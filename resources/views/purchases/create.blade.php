<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Purchase Order') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="purchaseForm()">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('purchases.store') }}">
                        @csrf
                        
                        <div class="mb-6">
                            <x-input-label for="supplier_id" :value="__('Select Supplier')" />
                            <select id="supplier_id" name="supplier_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full md:w-1/2" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('supplier_id')" class="mt-2" />
                        </div>

                        <!-- Products Section -->
                        <div class="mt-8 border-t pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Items Details</h3>
                            
                            <table class="w-full text-left mb-4">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="p-2">Product</th>
                                        <th class="p-2 w-32">Qty</th>
                                        <th class="p-2 w-48">Unit Price</th>
                                        <th class="p-2 w-24">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr class="border-b">
                                            <td class="p-2">
                                                <select x-model="item.product_id" :name="'items['+index+'][product_id]'" class="w-full border-gray-300 rounded text-sm" required>
                                                    <option value="">Select Product...</option>
                                                    @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-2">
                                                <input type="number" x-model="item.quantity" :name="'items['+index+'][quantity]'" min="1" class="w-full border-gray-300 rounded text-sm" required>
                                            </td>
                                            <td class="p-2">
                                                <input type="number" step="0.01" x-model="item.unit_price" :name="'items['+index+'][unit_price]'" min="0" class="w-full border-gray-300 rounded text-sm" required>
                                            </td>
                                            <td class="p-2 text-center">
                                                <button type="button" @click="removeItem(index)" class="text-red-500 hover:text-red-700 text-sm font-bold">X</button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                            
                            <button type="button" @click="addItem" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm font-semibold py-1 px-3 rounded">
                                + Add Product
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-8 pt-4 border-t">
                            <a href="{{ route('purchases.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Complete Purchase') }}
                            </x-primary-button>
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
                oldItems = [{ product_id: '', quantity: 1, unit_price: 0 }];
            }

            Alpine.data('purchaseForm', () => ({
                items: oldItems,
                addItem() {
                    this.items.push({ product_id: '', quantity: 1, unit_price: 0 });
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
