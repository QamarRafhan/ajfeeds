<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Categories
                        </h2>

                        <a href="{{ route('categories.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            + Create Category
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead
                                class="ltr:text-left rtl:text-right bg-gray-50 uppercase tracking-widest text-[11px] font-black text-gray-500">
                                <tr>
                                    <th class="whitespace-nowrap px-6 py-4 font-medium text-left cursor-default">
                                        Name</th>
                                    <th class="whitespace-nowrap px-6 py-4 font-medium text-left">
                                        Description</th>
                                    <th class="whitespace-nowrap px-6 py-4 font-medium text-left">Products
                                        Count</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200">
                                @forelse($categories as $category)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-6 py-4 font-bold text-gray-900">
                                            {{ $category->name }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-700">
                                            {{ Str::limit($category->description, 50) }}</td>
                                        <td class="whitespace-nowrap px-6 py-4 text-gray-700">
                                            <span
                                                class="inline-flex items-center justify-center rounded-full bg-blue-100 px-2.5 py-0.5 text-blue-700 text-[10px] font-black uppercase">
                                                {{ $category->products_count }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('categories.edit', $category) }}"
                                                    class="inline-block rounded bg-indigo-50 px-4 py-2 text-[10px] font-black uppercase text-indigo-600 hover:bg-indigo-600 hover:text-white transition">Edit</a>
                                                <form action="{{ route('categories.destroy', $category) }}"
                                                    method="POST" class="sweet-alert-delete"
                                                    data-message="Are you sure you want to delete this category?">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-block rounded bg-red-50 px-4 py-2 text-[10px] font-black uppercase text-red-600 hover:bg-red-600 hover:text-white transition">Delete</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <!-- Handled by Datatables -->
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
