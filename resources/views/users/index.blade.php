<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 border-b">

                    <!-- Title + Button -->
                    <div class="flex justify-between items-center mb-6 pb-4 border-b">
                        <h2 class="text-xl font-bold text-gray-800">
                            Staff / User Management
                        </h2>

                        <a href="{{ route('users.create') }}"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded text-sm transition">
                            Add New Staff
                        </a>
                    </div>

                    <!-- Filter Bar -->
                    <div class="flex flex-wrap gap-4 mb-6 p-4 bg-gray-50 rounded-lg border border-gray-100 items-end">
                        <form method="GET" action="{{ route('users.index') }}"
                            class="flex flex-wrap gap-4 w-full md:w-auto items-end">
                            <div class="w-full md:w-48">
                                <label class="block text-xs font-bold text-gray-400 uppercase mb-1">Role Filter</label>
                                <select name="role" onchange="this.form.submit()"
                                    class="bg-white border-gray-200 text-sm">
                                    <option value="">All Staff Roles</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ request('role') == $role->name ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit"
                                class="bg-gray-800 text-white px-4 py-2 rounded text-sm font-bold hover:bg-black transition">Apply</button>
                            <a href="{{ route('users.index') }}"
                                class="text-sm text-gray-500 hover:text-gray-700 underline px-2 py-2">Reset</a>
                        </form>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="datatable min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Full Name</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Email Identity</th>
                                    <th class="whitespace-nowrap px-4 py-3 font-bold text-left">Assigned Roles</th>
                                    <th class="px-4 py-3 text-center">Administrative Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="whitespace-nowrap px-4 py-3 font-bold text-gray-900">
                                            {{ $user->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-3 text-gray-500 font-mono text-xs">
                                            {{ $user->email }}</td>
                                        <td class="whitespace-nowrap px-4 py-3">
                                            @foreach ($user->roles as $role)
                                                <span
                                                    class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-black uppercase tracking-widest bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-3 text-center">
                                            <div class="flex justify-center items-center space-x-2">
                                                <a href="{{ route('reports.user', $user->id) }}"
                                                    class="inline-flex items-center px-3 py-1 bg-green-50 text-green-700 rounded-md hover:bg-green-600 hover:text-white text-[10px] font-black uppercase tracking-tighter transition border border-green-200">
                                                    Activity Report
                                                </a>
                                                <a href="{{ route('users.edit', $user) }}"
                                                    class="p-1.5 bg-gray-100 text-gray-600 rounded hover:bg-gray-900 hover:text-white transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                                @if (auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                                                        class="sweet-alert-delete"
                                                        data-message="Are you sure you want to completely delete this user?">
                                                        @csrf @method('DELETE')
                                                        <button type="submit"
                                                            class="p-1.5 bg-red-50 text-red-600 rounded hover:bg-red-600 hover:text-white transition">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif
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
