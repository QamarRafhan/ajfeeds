<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- jQuery & Select2 -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Tailwind CSS (Play CDN) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e',
                        },
                    }
                }
            }
        }
    </script>

    <style>
        /* BASE THEME (LIGHT BLUE - PREMIUM WHITE & BLUE) */
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --bg-main: #f8fafc;
            --bg-card: #ffffff;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border: #e2e8f0;
            --hover-text: #ffffff;
        }

        .theme-light_blue {
            --primary: #3b82f6;
            --primary-hover: #2563eb;
            --bg-main: #f0f9ff;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --sidebar-border: #e0f2fe;
            --text-main: #0f172a;
            --text-muted: #475569;
            --border: #e0f2fe;
            --hover-text: #ffffff;
        }

        .theme-midnight {
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --bg-main: #020617;
            --bg-card: #0f172a;
            --bg-sidebar: #0f172a;
            --sidebar-border: #1e293b;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --border: #1e293b;
            --hover-text: #ffffff;
        }

        .theme-modern_dark {
            --primary: #818cf8;
            --primary-hover: #6366f1;
            --bg-main: #0f172a;
            --bg-card: #1e293b;
            --bg-sidebar: #111827;
            --sidebar-border: #334155;
            --text-main: #f8fafc;
            --text-muted: #94a3b8;
            --border: #334155;
            --hover-text: #ffffff;
        }

        body {
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
            transition: all 0.3s ease;
        }
        
        .bg-sidebar { background-color: var(--bg-sidebar) !important; }
        .border-sidebar-border { border-color: var(--sidebar-border) !important; }
        .bg-sidebar-header { background-color: rgba(0,0,0,0.05) !important; }

        main {
            background-color: var(--bg-main) !important;
        }

        .bg-white {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
        }

        .text-gray-900, .text-gray-800, .text-gray-700, .text-gray-600 {
            color: var(--text-main) !important;
        }

        .text-gray-500, .text-gray-400 {
            color: var(--text-muted) !important;
        }

        .border-gray-100, .border-gray-200, .divide-gray-200 {
            border-color: var(--border) !important;
        }

        .bg-gray-50 {
            background-color: var(--bg-main) !important;
        }

        /* Input Field Fixes - Specific selection to avoid breaking checkboxes/radios/swal */
        input[type="text"]:not(.swal2-input), 
        input[type="email"]:not(.swal2-input), 
        input[type="password"]:not(.swal2-input), 
        input[type="number"]:not(.swal2-input), 
        input[type="tel"]:not(.swal2-input), 
        input[type="url"]:not(.swal2-input), 
        select:not(.swal2-select), 
        textarea:not(.swal2-textarea) {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            border-radius: 0.375rem !important;
            padding: 0.5rem 0.75rem !important;
            width: 100% !important;
            display: block !important;
        }
        
        input[type="text"]:focus, 
        input[type="email"]:focus, 
        select:focus, 
        textarea:focus {
            ring: 2px solid var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Checkbox & Radio Styling */
        input[type="checkbox"], 
        input[type="radio"] {
            appearance: checkbox !important;
            width: 1.25rem !important;
            height: 1.25rem !important;
            border-radius: 0.25rem !important;
            border: 2px solid var(--border) !important;
            background-color: var(--bg-card) !important;
            color: var(--primary) !important;
            cursor: pointer !important;
            display: inline-block !important;
            padding: 0 !important;
        }

        input[type="checkbox"]:checked {
            background-color: var(--primary) !important;
            border-color: var(--primary) !important;
        }

        /* Hover Mix Fixes & Contrast Improvements */
        .hover\:bg-indigo-600:hover, 
        .hover\:bg-primary:hover, 
        .hover\:bg-indigo-700:hover {
            background-color: var(--primary-hover) !important;
            color: #ffffff !important;
        }
        
        /* Dropdown & List Hover Fixes (Ensuring text doesn't vanish on light hover) */
        .hover\:bg-gray-50:hover, 
        .hover\:bg-gray-100:hover, 
        .hover\:bg-indigo-50:hover {
            background-color: rgba(79, 70, 229, 0.1) !important;
            color: var(--primary) !important;
        }

        .theme-midnight .hover\:bg-gray-50:hover, 
        .theme-midnight .hover\:bg-indigo-50:hover,
        .theme-modern_dark .hover\:bg-gray-50:hover, 
        .theme-modern_dark .hover\:bg-indigo-50:hover {
            background-color: rgba(255, 255, 255, 0.1) !important;
            color: #ffffff !important;
        }
        
        .hover\:text-white:hover {
            color: #ffffff !important;
        }

        .text-white {
            color: #ffffff !important;
        }

        /* Shadow Enhancements */
        .shadow-sm { box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important; }
        .shadow { box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important; }
        .shadow-xl { box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04) !important; }

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            height: 42px;
            padding-top: 5px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: var(--text-main) !important;
        }
        .select2-dropdown {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .select2-search__field {
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border) !important;
        }

        /* Profile Photo Styles */
        .profile-photo-circle {
            object-fit: cover;
            width: 32px;
            height: 32px;
            border-radius: 9999px;
        }

        /* SweetAlert2 Theme Integration */
        .swal2-popup {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
            border: 1px solid var(--border) !important;
            border-radius: 1rem !important;
        }
        .swal2-title, .swal2-html-container, .swal2-content {
            color: var(--text-main) !important;
        }
        .swal2-toast {
            width: auto !important;
            min-width: 320px !important;
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1) !important;
            border: 1px solid var(--border) !important;
        }
        .swal2-confirm {
            background-color: var(--primary) !important;
            color: #ffffff !important;
        }
        .swal2-cancel {
            background-color: #6b7280 !important;
            color: #ffffff !important;
        }
        .swal2-container {
            z-index: 9999 !important;
        }
        
        .theme-midnight .swal2-success-circular-line-left,
        .theme-midnight .swal2-success-circular-line-right,
        .theme-midnight .swal2-success-fix,
        .theme-modern_dark .swal2-success-circular-line-left,
        .theme-modern_dark .swal2-success-circular-line-right,
        .theme-modern_dark .swal2-success-fix {
            background-color: var(--bg-card) !important;
        }
    </style>
</head>

<body
    class="font-sans antialiased {{ Auth::check() ? 'theme-' . (Auth::user()->settings->theme_mode ?? 'light_blue') : 'theme-light_blue' }}">

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
                    
                    <!-- Theme Selector Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-indigo-600 transition" title="Change Theme">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-8.486 8.486L11 7.343z"></path>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase">Select Theme</div>
                            <form action="{{ route('profile.theme') }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button name="theme_mode" value="light_blue" class="w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-blue-500 mr-2 border border-blue-600"></span> Light Blue (Premium)
                                </button>
                                <button name="theme_mode" value="midnight" class="w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-slate-900 mr-2 border border-slate-700"></span> Midnight Navy
                                </button>
                                <button name="theme_mode" value="modern_dark" class="w-full text-left px-4 py-2 text-sm leading-5 text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition flex items-center">
                                    <span class="w-3 h-3 rounded-full bg-gray-700 mr-2 border border-gray-900"></span> Modern Slate
                                </button>
                            </form>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out">
                                
                                <div class="w-8 h-8 rounded-full overflow-hidden mr-2 border border-indigo-200 flex items-center justify-center bg-indigo-100 text-indigo-600 font-bold">
                                    @if(Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile" class="profile-photo-circle">
                                    @else
                                        {{ substr(Auth::user()->name ?? 'U', 0, 1) }}
                                    @endif
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
            <main class="w-full flex-1">
                {{ $slot }}
            </main>

        </div>
    </div>

    {{-- Scripts --}}
    <script src="https://unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Global Select2 Initialization
            function initSelect2() {
                $('select').not('.no-select2').select2({
                    width: '100%',
                    placeholder: 'Search and Select...',
                    allowClear: true
                });
            }

            initSelect2();

            // Handle Dynamic Rows (if any)
            document.addEventListener('row-added', function() {
                initSelect2();
            });

            // SweetAlert Handlers
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Confirmed!',
                    text: "{!! addslashes(session('success')) !!}",
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end',
                    background: 'var(--bg-card)',
                    color: 'var(--text-main)',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
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
                    position: 'top-end',
                    background: 'var(--bg-card)',
                    color: 'var(--text-main)',
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
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
            $(document).on('submit', '.sweet-alert-delete', function(e) {
                e.preventDefault();
                let form = this;
                let message = $(form).attr('data-message') || 'Are you sure you want to proceed?';

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
            });
        });
    </script>
</body>

</html>
