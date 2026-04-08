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
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th
                                        class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left cursor-default">
                                        Name</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Email
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Phone
                                    </th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Address
                                    </th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($suppliers as $supplier)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">
                                            {{ $supplier->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $supplier->email ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ $supplier->phone ?? '-' }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            {{ Str::limit($supplier->address, 30) }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('suppliers.edit', $supplier) }}"
                                                    class="inline-block rounded bg-indigo-600 px-4 py-2 text-xs font-medium text-white hover:bg-indigo-700">Edit</a>
                                                <form action="{{ route('suppliers.destroy', $supplier) }}"
                                                    method="POST" class="sweet-alert-delete"
                                                    data-message="Delete this supplier permanently?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-block rounded bg-red-600 px-4 py-2 text-xs font-medium text-white hover:bg-red-700">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-4 py-8 text-center text-gray-500">No suppliers
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $suppliers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
