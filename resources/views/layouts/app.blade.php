<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased text-gray-900 bg-gray-50 {{ Auth::check() && Auth::user()->theme === 'dark' ? 'theme-dark' : 'theme-light' }}">

    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        <!-- Sidebar Navigation Component -->
        @include('layouts.navigation')

        <!-- Main Content Container -->
        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <!-- Top Header Bar -->
            <header
                class="sticky top-0 z-30 flex items-center justify-between w-full px-4 sm:px-6 lg:px-8 py-4 bg-white border-b border-gray-200 shadow-sm">

                <!-- Mobile Hamburger -->
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-gray-500 hover:text-indigo-600 focus:outline-none lg:hidden transition">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" />
                    </svg>
                </button>

                <!-- Page Title / Breadcrumb Placeholder -->
                <div class="flex items-center space-x-3 w-full ml-4 lg:ml-0">
                    @isset($header)
                        <h2 class="text-xl font-bold text-gray-800 leading-tight">
                            {{ $header }}
                        </h2>
                    @endisset
                </div>

                <!-- Right Top Bar Actions (Profile, Theme Toggle) -->
                <div class="flex items-center space-x-4">
                    <form action="{{ route('profile.theme') }}" method="POST" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                            class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-indigo-600 transition"
                            title="Toggle Sidebar Theme">
                            @if (Auth::check() && Auth::user()->theme === 'dark')
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                                    </path>
                                </svg>
                            @else
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                                    </path>
                                </svg>
                            @endif
                        </button>
                    </form>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out">
                                <div
                                    class="w-8 h-8 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-2 border border-indigo-200">
                                    {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                </div>
                                <div class="hidden md:block">{{ Auth::user()->name ?? 'Guest' }}</div>
                                <div class="ml-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">{{ __('Profile Settings') }}</x-dropdown-link>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">{{ __('Log Out') }}</x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </header>

            <!-- Page Content Region -->
            <main class="w-full">
                {{ $slot }}
            </main>

        </div>
    </div>

    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Confirmed!',
                    text: "{!! addslashes(session('success')) !!}",
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Action Failed',
                    text: "{!! addslashes(session('error')) !!}",
                    timer: 4500,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'warning',
                    title: 'Wait a second...',
                    html: `
                            <ul style="text-align: left; padding: 0 20px; font-size: 14px;">
                                @foreach ($errors->all() as $error)
                                    <li>- {{ $error }}</li>
                                @endforeach
                            </ul>
                        `,
                    confirmButtonColor: '#4f46e5'
                });
            @endif

            // Global SweetAlert Delete Confirmation Interceptor
            document.addEventListener('submit', function(e) {
                if (e.target && e.target.classList.contains('sweet-alert-delete')) {
                    e.preventDefault();
                    let form = e.target;
                    let message = form.getAttribute('data-message') || 'Are you sure you want to proceed?';

                    Swal.fire({
                        title: 'Confirm Deletion',
                        text: message,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ef4444',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                }
            });
        });
    </script>

</body>

</html>
