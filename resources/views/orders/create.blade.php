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
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 border-b pb-6">
                            <div class="md:col-span-1">
                                <h3 class="text-2xl font-black text-gray-800 tracking-tight">Generate Sale</h3>
                                <p class="text-sm text-gray-500">Select customer and add products.</p>
                            </div>

                            <div class="space-y-4 md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Customer
                                        Selection</label>
                                    <select name="customer_id" id="customer_select" class="w-full select2" required>
                                        <option value="">Select Customer Name...</option>
                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">{{ $customer->name }}
                                                ({{ $customer->phone ?? 'No Phone' }})
                                            </option>
                                        @endforeach
                                    </select>

                                    {{-- Credit badge + checkbox --}}
                                    <div x-show="creditAmount > 0"
                                        class="mt-2 p-3 bg-indigo-50 border border-indigo-200 rounded-lg">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="text-[10px] font-black uppercase text-indigo-500 tracking-widest">Advance
                                                Credit Available</span>
                                            <span
                                                class="text-sm font-black text-indigo-700">{{ env('CURRENCY_SIGN') }}<span
                                                    x-text="formatNumber(creditAmount)"></span></span>
                                        </div>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="use_credit" value="1" x-model="useCredit"
                                                class="rounded">
                                            <span class="text-xs font-bold text-indigo-700">Apply advance credit to this
                                                order</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label
                                            class="block text-xs font-bold text-gray-400 uppercase mb-1">Status</label>
                                        <select name="status" class="bg-gray-50 border-gray-200 text-sm font-semibold">
                                            <option value="pending">Pending</option>
                                            <option value="completed" selected>Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Paid
                                            Amount</label>
                                        <div class="relative">
                                            <span
                                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs font-bold">{{ env('CURRENCY_SIGN') }}</span>
                                            <input type="number" name="paid_amount" step="0.01" min="0"
                                                value="0"
                                                class="pl-12 bg-gray-50 border-gray-200 text-sm font-black text-indigo-700"
                                                placeholder="0.00">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Products Table -->
                        <div class="mb-6">
                            <table class="w-full text-sm text-left border-separate border-spacing-y-2">
                                <thead>
                                    <tr class="text-gray-400 uppercase text-[10px] font-black tracking-widest">
                                        <th class="px-4 py-2">Product selection</th>
                                        <th class="px-4 py-2 w-32">Qty</th>
                                        <th class="px-4 py-2 w-32 text-right">Subtotal</th>
                                        <th class="px-4 py-2 w-24 text-center">Delete</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="(item, index) in items" :key="index">
                                        <tr
                                            class="bg-gray-50 rounded-lg group hover:bg-white hover:shadow-md transition-all duration-200">
                                            <td class="p-2">
                                                <select x-select2 x-model="item.product_id"
                                                    :name="'items[' + index + '][product_id]'" class="w-full select2"
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
                                                <input type="number" x-model.number="item.quantity"
                                                    :name="'items[' + index + '][quantity]'" min="1"
                                                    class="border-gray-200 focus:ring-primary focus:border-primary font-bold"
                                                    required>
                                            </td>
                                            <td class="p-2 text-right font-black text-gray-700">
                                                {{ env('CURRENCY_SIGN') }}<span
                                                    x-text="formatNumber(calculateSubtotal(item))"></span>
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

                            <div class="flex justify-between items-end mt-4">
                                <button type="button" @click="addItem"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 text-xs font-black uppercase tracking-widest hover:bg-indigo-100 rounded-md border border-indigo-200 transition">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Add Row
                                </button>

                                <div class="space-y-3 min-w-[260px]">
                                    {{-- Overpayment → ask to add to credit --}}
                                    <div x-show="paidAmount + (useCredit ? Math.min(creditAmount, Math.max(0, grandTotal - paidAmount)) : 0) > grandTotal && grandTotal > 0"
                                        class="p-3 bg-amber-50 border border-amber-300 rounded-lg">
                                        <p class="text-[10px] font-black uppercase text-amber-600 tracking-widest mb-2">
                                            Overpayment Detected</p>
                                        <p class="text-xs text-amber-700 mb-2">Customer paid
                                            <strong>{{ env('CURRENCY_SIGN') }}<span
                                                    x-text="formatNumber(paidAmount - grandTotal)"></span></strong>
                                            extra.
                                            Add to advance credit?
                                        </p>
                                        <label class="flex items-center gap-2 cursor-pointer">
                                            <input type="checkbox" name="add_to_credit" value="1" checked
                                                class="rounded">
                                            <span class="text-xs font-bold text-amber-700">Yes, add overpayment to
                                                advance credit</span>
                                        </label>
                                    </div>

                                    {{-- Totals Card --}}
                                    <div class="bg-indigo-600 text-white p-6 rounded-xl shadow-lg text-right">
                                        <p
                                            class="text-[10px] font-black uppercase text-indigo-200 tracking-widest mb-1">
                                            Grand Total</p>
                                        <div class="text-4xl font-black mb-4">
                                            {{ env('CURRENCY_SIGN') }}<span x-text="formatNumber(grandTotal)"></span>
                                        </div>
                                        <div class="space-y-1 text-sm border-t border-indigo-500 pt-4">
                                            <div class="flex justify-between opacity-80">
                                                <span>Cash Paid:</span>
                                                <span>{{ env('CURRENCY_SIGN') }}<span
                                                        x-text="formatNumber(paidAmount)"></span></span>
                                            </div>
                                            <div x-show="useCredit && creditAmount > 0"
                                                class="flex justify-between opacity-80 text-indigo-200">
                                                <span>Credit Applied:</span>
                                                <span>{{ env('CURRENCY_SIGN') }}<span
                                                        x-text="formatNumber(Math.min(creditAmount, Math.max(0, grandTotal - paidAmount)))"></span></span>
                                            </div>
                                            <div class="flex justify-between font-black text-lg">
                                                <span>Balance Due:</span>
                                                <span>{{ env('CURRENCY_SIGN') }}<span
                                                        x-text="formatNumber(Math.max(0, grandTotal - paidAmount - (useCredit ? Math.min(creditAmount, Math.max(0, grandTotal - paidAmount)) : 0)))"></span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-12 pt-6 border-t space-x-4">
                            <a href="{{ route('orders.index') }}"
                                class="text-sm font-bold text-gray-400 hover:text-gray-600">Cancel Transaction</a>
                            <button type="submit"
                                class="bg-gray-900 border border-transparent rounded-md font-black text-xs text-white uppercase tracking-widest hover:bg-black active:bg-gray-900 focus:outline-none focus:border-gray-900 px-8 py-3 transition shadow-lg">
                                Process & Check-out
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
                productPrices: @json($product_prices),
                customerCredits: @json($customer_credits),
                paidAmount: {{ old('paid_amount', 0) }},
                grandTotal: 0,
                selectedCustomerId: null,
                creditAmount: 0,
                useCredit: false,

                init() {
                    // Watch for paid_amount changes
                    const paidInput = document.querySelector('input[name="paid_amount"]');
                    if (paidInput) {
                        paidInput.addEventListener('input', (e) => {
                            this.paidAmount = parseFloat(e.target.value) || 0;
                            this.updateTotals();
                        });
                    }

                    // Watch for customer selection to show credit info
                    this.$nextTick(() => {
                        const self = this;
                        $('#customer_select').on('change', function() {
                            self.selectedCustomerId = $(this).val();
                            self.creditAmount = parseFloat(self.customerCredits[self
                                .selectedCustomerId]) || 0;
                            self.useCredit = self.creditAmount >
                            0; // auto-check if credit exists
                        });

                        self._bindSelect2Events();
                    });

                    this.updateTotals();
                    this.$watch('items', () => {
                        this.updateTotals();
                    }, {
                        deep: true
                    });
                },

                // Bind Select2 change events to update Alpine state directly
                _bindSelect2Events() {
                    const self = this;
                    $(document).on('change', 'select[name*="[product_id]"]', function() {
                        const name = $(this).attr('name');
                        const match = name.match(/items\[(\d+)\]\[product_id\]/);
                        if (match) {
                            const idx = parseInt(match[1]);
                            if (self.items[idx] !== undefined) {
                                self.items[idx].product_id = $(this).val();
                                self.updateTotals();
                            }
                        }
                    });
                },

                setProduct(index, value) {
                    this.items[index].product_id = value;
                    this.updateTotals();
                },

                updateTotals() {
                    this.grandTotal = this.calculateGrandTotal();
                },

                calculateSubtotal(item) {
                    const price = parseFloat(this.productPrices[item.product_id]) || 0;
                    const qty = parseInt(item.quantity) || 0;
                    return price * qty;
                },

                calculateGrandTotal() {
                    return this.items.reduce((total, item) => total + this.calculateSubtotal(item), 0);
                },

                formatNumber(num) {
                    return new Intl.NumberFormat(undefined, {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    }).format(num || 0);
                },

                addItem() {
                    this.items.push({
                        product_id: '',
                        quantity: 1
                    });
                    this.$nextTick(() => {
                        // Re-initialize Select2 on newly added rows
                        $('select[name*="[product_id]"]').not('.select2-hidden-accessible')
                            .select2({
                                width: '100%'
                            });
                    });
                },

                removeItem(index) {
                    if (this.items.length > 1) {
                        this.items.splice(index, 1);
                        this.updateTotals();
                    }
                }
            }))
        })
    </script>
</x-app-layout>
