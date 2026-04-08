<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Purchase Details') }} - {{ $purchase->reference_no }}
            </h2>
            <a href="{{ route('purchases.index') }}" class="text-gray-600 hover:text-gray-900 transition">
                &larr; Back to list
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <div class="grid grid-cols-2 gap-4 mb-6 pb-6 border-b">
                        <div>
                            <p class="text-sm text-gray-500">Supplier</p>
                            <p class="font-semibold">{{ $purchase->supplier->name ?? 'N/A' }}</p>
                            <p class="text-sm">{{ $purchase->supplier->email ?? '' }}</p>
                            <p class="text-sm">{{ $purchase->supplier->phone ?? '' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-sm text-gray-500">Purchase Date</p>
                            <p class="font-semibold">{{ $purchase->created_at->format('F d, Y h:i A') }}</p>
                            
                            <p class="text-sm text-gray-500 mt-2">Status</p>
                            <span class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700 capitalize font-medium">
                                {{ $purchase->status }}
                            </span>
                        </div>
                    </div>

                    <h3 class="text-lg font-medium text-gray-900 mb-4">Items Purchased</h3>
                    <div class="overflow-x-auto mb-6">
                        <table class="min-w-full divide-y-2 divide-gray-200 text-sm">
                            <thead class="bg-gray-50 text-left">
                                <tr>
                                    <th class="px-4 py-2">Item</th>
                                    <th class="px-4 py-2">SKU</th>
                                    <th class="px-4 py-2 text-right">Unit Price</th>
                                    <th class="px-4 py-2 text-right">Quantity</th>
                                    <th class="px-4 py-2 text-right border-l">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($purchase->items as $item)
                                <tr>
                                    <td class="px-4 py-2">{{ $item->product->name ?? 'Deleted' }}</td>
                                    <td class="px-4 py-2">{{ $item->product->sku ?? '-' }}</td>
                                    <td class="px-4 py-2 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                    <td class="px-4 py-2 text-right">{{ $item->quantity }}</td>
                                    <td class="px-4 py-2 text-right font-medium">${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-gray-50 border-t-2 border-gray-300 text-base">
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-right font-bold text-gray-700">Total:</td>
                                    <td class="px-4 py-3 text-right font-bold text-gray-900">${{ number_format($purchase->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
