<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles & Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">Available Roles</h3>
                        <a href="{{ route('roles.create') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            + Create New Role
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50 uppercase tracking-widest text-[11px] font-black text-gray-500">
                                <tr>
                                    <th class="px-6 py-4 text-left font-bold">Role Name</th>
                                    <th class="px-6 py-4 text-left font-bold">Permissions Mapping</th>
                                    <th class="px-6 py-4 text-right font-bold">System Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($roles as $role)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ $role->name }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-700">
                                            <div class="flex flex-wrap gap-1">
                                                @foreach ($role->permissions as $permission)
                                                    <span
                                                        class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-blue-50 text-blue-700 border border-blue-100">
                                                        {{ $permission->name }}
                                                    </span>
                                                @endforeach
                                                @if ($role->permissions->isEmpty())
                                                    <span
                                                        class="text-gray-400 italic text-[10px] font-medium tracking-tight">No
                                                        specific permissions assigned</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('roles.edit', $role) }}"
                                                    class="inline-block rounded bg-indigo-50 px-3 py-1.5 text-[10px] font-black uppercase text-indigo-600 hover:bg-indigo-600 hover:text-white transition">Edit</a>
                                                @if ($role->name !== 'Admin')
                                                    <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                                        class="inline-block sweet-alert-delete"
                                                        data-message="Warning: This will permanently delete the '{{ $role->name }}' role. All users assigned to this role will lose their associated permissions.">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-block rounded bg-red-50 px-3 py-1.5 text-[10px] font-black uppercase text-red-600 hover:bg-red-600 hover:text-white transition">Delete</button>
                                                    </form>
                                                @endif
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
