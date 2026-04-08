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

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y-2 divide-gray-200 bg-white text-sm">
                            <thead class="ltr:text-left rtl:text-right bg-gray-50">
                                <tr>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Name</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Email</th>
                                    <th class="whitespace-nowrap px-4 py-2 font-medium text-gray-900 text-left">Role</th>
                                    <th class="px-4 py-2"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($users as $user)
                                    <tr>
                                        <td class="whitespace-nowrap px-4 py-2 font-medium text-gray-900">{{ $user->name }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">{{ $user->email }}</td>
                                        <td class="whitespace-nowrap px-4 py-2 text-gray-700">
                                            @foreach($user->roles as $role)
                                                <span class="inline-flex items-center justify-center rounded-full bg-indigo-100 px-2.5 py-0.5 text-indigo-700 text-xs font-bold capitalize">
                                                    {{ $role->name }}
                                                </span>
                                            @endforeach
                                        </td>
                                        <td class="whitespace-nowrap px-4 py-2 text-right">
                                            <div class="flex justify-end gap-2">
                                                <a href="{{ route('users.edit', $user) }}" class="inline-block rounded bg-gray-600 px-3 py-1 text-xs font-medium text-white hover:bg-gray-700">Edit</a>
                                                @if(auth()->id() !== $user->id)
                                                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="sweet-alert-delete" data-message="Are you sure you want to completely delete this user?">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-block rounded bg-red-600 px-3 py-1 text-xs font-medium text-white hover:bg-red-700">Revoke Access</button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
