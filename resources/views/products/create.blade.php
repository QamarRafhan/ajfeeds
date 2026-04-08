<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Product') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div>
                                <div class="mb-4">
                                    <x-input-label for="name" :value="__('Product Name')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="sku" :value="__('SKU')" />
                                    <x-text-input id="sku" class="block mt-1 w-full" type="text" name="sku" :value="old('sku')" required />
                                    <x-input-error :messages="$errors->get('sku')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="category_id" :value="__('Category')" />
                                    <select id="category_id" name="category_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" required>
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                                </div>
                                
                                <div class="mb-4">
                                    <x-input-label for="image" :value="__('Product Image')" />
                                    <input id="image" class="block mt-1 w-full border border-gray-300 rounded p-2" type="file" name="image" onchange="previewImage(this)" />
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                    
                                    <div id="image-preview" class="mt-4 hidden text-center border p-2 rounded bg-gray-50">
                                        <p class="text-xs text-gray-500 mb-2">Image Preview</p>
                                        <img src="" alt="Preview" class="max-h-48 mx-auto rounded shadow-sm">
                                    </div>
                                </div>
                            </div>

                            <!-- Right Column -->
<script>
    function previewImage(input) {
        const preview = document.querySelector('#image-preview');
        const img = preview.querySelector('img');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                img.src = e.target.result;
                preview.classList.remove('hidden');
            }
            
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.classList.add('hidden');
        }
    }
</script>
                            <div>
                                <div class="mb-4">
                                    <x-input-label for="purchase_price" :value="__('Purchase Price')" />
                                    <x-text-input id="purchase_price" class="block mt-1 w-full" type="number" step="0.01" name="purchase_price" :value="old('purchase_price')" required />
                                    <x-input-error :messages="$errors->get('purchase_price')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="sale_price" :value="__('Sale Price')" />
                                    <x-text-input id="sale_price" class="block mt-1 w-full" type="number" step="0.01" name="sale_price" :value="old('sale_price')" required />
                                    <x-input-error :messages="$errors->get('sale_price')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="stock_quantity" :value="__('Initial Stock Quantity')" />
                                    <x-text-input id="stock_quantity" class="block mt-1 w-full bg-gray-50" type="number" name="stock_quantity" :value="old('stock_quantity', 0)" title="Typically updated via Purchases" />
                                    <x-input-error :messages="$errors->get('stock_quantity')" class="mt-2" />
                                </div>

                                <div class="mb-4">
                                    <x-input-label for="min_stock_alert" :value="__('Min Stock Alert')" />
                                    <x-text-input id="min_stock_alert" class="block mt-1 w-full" type="number" name="min_stock_alert" :value="old('min_stock_alert', 5)" required />
                                    <x-input-error :messages="$errors->get('min_stock_alert')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4 pt-4 border-t">
                            <a href="{{ route('products.index') }}" class="text-sm text-gray-600 hover:text-gray-900 mr-4">Cancel</a>
                            <x-primary-button>
                                {{ __('Save Product') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
