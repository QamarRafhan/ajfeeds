<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Order') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="orderForm()">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border border-gray-200">
                <div class="p-8 text-gray-900">
                    <form method="POST" action="{{ route('orders.store') }}">
                        @csrf

                        <!-- Header Logic -->
                        <div class="flex justify-between items-start mb-8 border-b pb-6">
                            <div>
                                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Generate New Sale</h3>
                                <p class="text-sm text-gray-500">Add products and set initial status for this
                                    transaction.</p>
                            </div>
                            <div class="w-48">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Initial
                                    Status</label>
                                <select name="status" class="bg-gray-50 border-gray-200 text-sm font-semibold">
                                    <option value="pending">Pending</option>
                                    <option value="completed" selected>Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="mb-6">
                            <table class="w-full text-sm text-left border-separate border-spacing-y-2">
                                <thead>
                                    <tr class="text-gray-400 uppercase text-[10px] font-black tracking-widest">
                                        <th class="px-4 py-2">Product selection</th>
                                        <th class="px-4 py-2 w-32">Qty</th>
                                        <th class="px-4 py-2 w-24 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr
                                            class="bg-gray-50 rounded-lg group hover:bg-white hover:shadow-md transition-all duration-200">
                                            <td class="p-2">
                                                <select x-select2 x-model="item.product_id"
                                                    :name="'items[' + index + '][product_id]'" class="w-full no-select2"
                                                    required>
                                                    <option value="">Search Poultry/Cattle Feed...</option>
                                                    @foreach ($products as $product)
                                                        <option value="{{ $product->id }}">
                                                            {{ $product->name }} ({{ $product->sku }}) -
                                                            {{ env('CURRENCY_SIGN') }}{{ number_format($product->sale_price, 2) }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="p-2">
                                                <input type="number" x-model="item.quantity"
                                                    :name="'items[' + index + '][quantity]'" min="1"
                                                    class="border-gray-200 focus:ring-primary focus:border-primary font-bold"
                                                    required>
                                            </td>
                                            <td class="p-2 text-center">
                                                <button type="button" @click="removeItem(index)"
                                                    class="w-8 h-8 flex items-center justify-center text-red-400 hover:text-red-700 hover:bg-red-50 rounded-full transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>

                            <button type="button" @click="addItem"
                                class="mt-4 inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-black uppercase tracking-widest hover:bg-indigo-100 rounded-md border border-indigo-200 transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Row
                            </button>
                        </div>

                        <div class="flex items-center justify-end mt-12 pt-6 border-t space-x-4">
                            <a href="{{ route('orders.index') }}"
                                class="text-sm font-bold text-gray-400 hover:text-gray-600">Cancel Transaction</a>
                            <button type="submit"
                                class="bg-gray-900 border border-transparent rounded-md font-black text-xs text-white uppercase tracking-widest hover:bg-black active:bg-gray-900 focus:outline-none focus:border-gray-900 px-8 py-3 transition">
                                Process Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('orderForm', () => ({
                items: @json(old('items', [['product_id' => '', 'quantity' => 1]])),
                addItem() {
                    this.items.push({
                        product_id: '',
                        quantity: 1
                    });
                },
                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                    }
                }
            }))
        })
    </script>
</x-app-layout>
