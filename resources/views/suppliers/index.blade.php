<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Suppliers
                        </h2>

                        <a href="{{ route('suppliers.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            + Add Supplier
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50 uppercase tracking-widest text-[11px] font-black text-gray-500">
                                <tr>
                                    <th class="whitespace-nowrap px-6 py-4 font-bold text-left">Supplier Name</th>
                                    <th class="whitespace-nowrap px-6 py-4 font-bold text-left">Email Address</th>
                                    <th class="whitespace-nowrap px-6 py-4 font-bold text-left">Phone Number</th>
                                    <th class="whitespace-nowrap px-6 py-4 font-bold text-left">Location / Address</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @foreach ($suppliers as $supplier)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-6 py-4 font-bold text-primary-600">
                                            {{ $supplier->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-700">
                                            {{ $supplier->email ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-700 font-mono text-xs">
                                            {{ $supplier->phone ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-500">
                                            {{ Str::limit($supplier->address, 50) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                                    class="p-2 bg-indigo-50 text-indigo-600 rounded-md hover:bg-indigo-600 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                <form action="{{ route('suppliers.destroy', $supplier) }}"
                                                    method="POST" class="sweet-alert-delete"
                                                    data-message="Delete this supplier permanently?">
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
