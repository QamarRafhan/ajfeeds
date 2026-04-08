<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Deliveries') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">
                    

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Delivery ID</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Order Ref.</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Status</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Scheduled Date</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($deliveries ?? collect() as $delivery)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">#{{ $delivery->id }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $delivery->order->reference_no ?? 'N/A' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700 capitalize">{{ $delivery->status }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $delivery->delivery_date ? $delivery->delivery_date->format('M d, Y') : 'Pending' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <a href="{{ route('deliveries.edit', $delivery) }}" class="text-indigo-600 hover:text-indigo-900">Update Status</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No deliveries tracked yet.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
