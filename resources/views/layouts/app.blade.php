<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- DataTables -->
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet" />
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>

    <!-- Select2 -->
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
        }

        .theme-forest_green {
            --primary: #10b981;
            --primary-hover: #059669;
            --bg-main: #f0fdf4;
            --bg-card: #ffffff;
            --bg-sidebar: #064e3b;
            --sidebar-border: #065f46;
            --text-main: #064e3b;
            --text-muted: #1e293b;
            --border: #dcfce7;
        }

        .theme-sunset_gold {
            --primary: #f59e0b;
            --primary-hover: #d97706;
            --bg-main: #fffbeb;
            --bg-card: #ffffff;
            --bg-sidebar: #451a03;
            --sidebar-border: #78350f;
            --text-main: #451a03;
            --text-muted: #1e293b;
            --border: #fef3c7;
        }

        .theme-royal_purple {
            --primary: #8b5cf6;
            --primary-hover: #7c3aed;
            --bg-main: #f5f3ff;
            --bg-card: #ffffff;
            --bg-sidebar: #2e1065;
            --sidebar-border: #4c1d95;
            --text-main: #2e1065;
            --text-muted: #1e293b;
            --border: #ede9fe;
        }

        .theme-ocean_teal {
            --primary: #14b8a6;
            --primary-hover: #0d9488;
            --bg-main: #f0fdfa;
            --bg-card: #ffffff;
            --bg-sidebar: #134e4a;
            --sidebar-border: #115e59;
            --text-main: #134e4a;
            --text-muted: #1e293b;
            --border: #ccfbf1;
        }

        .theme-rose_quartz {
            --primary: #ec4899;
            --primary-hover: #db2777;
            --bg-main: #fff1f2;
            --bg-card: #ffffff;
            --bg-sidebar: #881337;
            --sidebar-border: #9f1239;
            --text-main: #881337;
            --text-muted: #1e293b;
            --border: #ffe4e6;
        }

        .theme-monochrome {
            --primary: #18181b;
            --primary-hover: #000000;
            --bg-main: #f4f4f5;
            --bg-card: #ffffff;
            --bg-sidebar: #ffffff;
            --sidebar-border: #e4e4e7;
            --text-main: #18181b;
            --text-muted: #71717a;
            --border: #e4e4e7;
        }

        .theme-high_contrast {
            --primary: #facc15;
            --primary-hover: #eab308;
            --bg-main: #000000;
            --bg-card: #18181b;
            --bg-sidebar: #000000;
            --sidebar-border: #facc15;
            --text-main: #ffffff;
            --text-muted: #facc15;
            --border: #facc15;
        }

        body {
            background-color: var(--bg-main) !important;
            color: var(--text-main) !important;
            transition: all 0.3s ease;
        }

        .bg-sidebar {
            background-color: var(--bg-sidebar) !important;
        }

        .border-sidebar-border {
            border-color: var(--sidebar-border) !important;
        }

        .bg-sidebar-header {
            background-color: rgba(0, 0, 0, 0.05) !important;
        }

        main {
            background-color: var(--bg-main) !important;
        }

        .bg-white {
            background-color: var(--bg-card) !important;
            color: var(--text-main) !important;
        }

        .text-gray-900,
        .text-gray-800,
        .text-gray-700,
        .text-gray-600 {
            color: var(--text-main) !important;
        }

        .text-gray-500,
        .text-gray-400 {
            color: var(--text-muted) !important;
        }

        .border-gray-100,
        .border-gray-200,
        .divide-gray-200 {
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

        /* DataTables Custom Theme */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_processing,
        .dataTables_wrapper .dataTables_paginate {
            color: var(--text-main) !important;
            margin-bottom: 1rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            background-color: var(--bg-card) !important;
            border: 1px solid var(--border) !important;
            color: var(--text-main) !important;
            margin-left: 0.5rem;
            padding: 0.25rem 0.5rem;
            border-radius: 0.375rem;
            width: auto !important;
            display: inline-block !important;
        }

        table.dataTable {
            border-collapse: collapse !important;
            border: none !important;
            width: 100% !important;
        }

        table.dataTable thead th {
            border-bottom: 2px solid var(--border) !important;
            background-color: var(--bg-main) !important;
            color: var(--text-muted) !important;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        table.dataTable tbody td {
            border-bottom: 1px solid var(--border) !important;
            padding: 1rem 0.5rem !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--text-main) !important;
            border: 1px solid transparent !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--bg-main) !important;
            border: 1px solid var(--border) !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary) !important;
            color: white !important;
            border: 1px solid var(--primary) !important;
        }

        /* Shadow Enhancements */
        .shadow-sm {
            box-shadow: 0 1px 2px 0 rgb(0 0 0 / 0.05) !important;
        }

        .shadow {
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1) !important;
        }

        .shadow-xl {
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 10px 10px -5px rgb(0 0 0 / 0.04) !important;
        }

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

        .swal2-title,
        .swal2-html-container,
        .swal2-content {
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

        .dataTables_length label {
            display: flex;
            align-items: center;
            gap: 6px;
            /* space between text & dropdown */
            margin: 0;
        }

        .dataTables_length select {
            padding: 0.5rem 1.75rem !important;
            margin: 2px;
            width: auto;
            display: inline-block;
        }
    </style>
</head>

<body
    class="font-sans antialiased {{ Auth::check() ? 'theme-' . (Auth::user()->settings->theme_mode->value ?? 'light_blue') : 'theme-light_blue' }}">

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
                    <x-dropdown align="right" width="64">
                        <x-slot name="trigger">
                            <button
                                class="p-2 bg-gray-100 rounded-full hover:bg-gray-200 hover:text-indigo-600 transition"
                                title="Change Theme">
                                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.828 2.828a2 2 0 010 2.828l-8.486 8.486L11 7.343z">
                                    </path>
                                </svg>
                            </button>
                        </x-slot>
                        <x-slot name="content">
                            <div class="px-4 py-2 text-xs font-bold text-gray-400 uppercase border-b">Premium Design
                                Systems</div>
                            <div class="max-h-80 overflow-y-auto">
                                <form action="{{ route('profile.theme') }}" method="POST">
                                    @csrf @method('PATCH')
                                    @php
                                        $themes = [
                                            ['id' => 'light_blue', 'name' => 'Light Blue', 'color' => '#3b82f6'],
                                            ['id' => 'midnight', 'name' => 'Midnight Navy', 'color' => '#0f172a'],
                                            ['id' => 'modern_dark', 'name' => 'Modern Slate', 'color' => '#1e293b'],
                                            ['id' => 'forest_green', 'name' => 'Forest Green', 'color' => '#10b981'],
                                            ['id' => 'sunset_gold', 'name' => 'Sunset Gold', 'color' => '#f59e0b'],
                                            ['id' => 'royal_purple', 'name' => 'Royal Purple', 'color' => '#8b5cf6'],
                                            ['id' => 'ocean_teal', 'name' => 'Ocean Teal', 'color' => '#14b8a6'],
                                            ['id' => 'rose_quartz', 'name' => 'Rose Quartz', 'color' => '#ec4899'],
                                            ['id' => 'monochrome', 'name' => 'Monochrome', 'color' => '#18181b'],
                                            ['id' => 'high_contrast', 'name' => 'High Contrast', 'color' => '#000000'],
                                        ];
                                    @endphp
                                    @foreach ($themes as $t)
                                        <button name="theme_mode" value="{{ $t['id'] }}"
                                            class="group w-full text-left px-4 py-3 text-sm leading-5 text-gray-700 hover:bg-gray-100 transition flex items-center">
                                            <span class="w-4 h-4 rounded-full mr-3 border border-gray-300 shadow-sm"
                                                style="background-color: {{ $t['color'] }}"></span>
                                            <span
                                                class="group-hover:translate-x-1 transition-transform">{{ $t['name'] }}</span>
                                        </button>
                                    @endforeach
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>

                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 transition duration-150 ease-in-out">

                                <div
                                    class="w-8 h-8 rounded-full overflow-hidden mr-2 border border-indigo-200 flex items-center justify-center bg-indigo-100 text-indigo-600 font-bold">
                                    @if (Auth::user()->profile_photo)
                                        <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Profile"
                                            class="profile-photo-circle">
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
            // Global Select2 Initialization Helper
            window.initSelect2 = function(selector = 'select') {
                $(selector).not('.no-select2, .select2-hidden-accessible').select2({
                    width: '100%',
                    placeholder: 'Search and Select...',
                    allowClear: true
                });
            }

            // Global DataTables Initialization Helper
            window.initDataTable = function(selector = '.datatable') {
                $(selector).each(function() {
                    if (!$.fn.dataTable.isDataTable(this)) {
                        $(this).DataTable({
                            responsive: true,
                            pageLength: 10,
                            order: [
                                [0, 'desc']
                            ],

                            initComplete: function() {
                                $('.dataTables_filter input').addClass('m-2');
                            },

                            language: {
                                search: "_INPUT_",
                                searchPlaceholder: "Search records...",
                            }
                        });
                    }
                });
            }

            // Alpine.js Directives
            document.addEventListener('alpine:init', () => {
                Alpine.directive('select2', (el, {
                    expression
                }, {
                    evaluate
                }) => {
                    $(el).select2({
                        width: '100%'
                    });
                    $(el).on('change', () => {
                        el.dispatchEvent(new Event('input'));
                    });

                    Alpine.effect(() => {
                        const value = evaluate(expression);
                        $(el).val(value).trigger('change.select2');
                    });
                });
            });

            // Initial Inits
            initSelect2();
            initDataTable();

            // SweetAlert Handlers (Toast focused)
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: 'var(--bg-card)',
                color: 'var(--text-main)'
            });

            @if (session('success'))
                Toast.fire({
                    icon: 'success',
                    title: "{!! addslashes(session('success')) !!}"
                });
            @endif

            @if (session('error'))
                Toast.fire({
                    icon: 'error',
                    title: "{!! addslashes(session('error')) !!}"
                });
            @endif

            @if ($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Form Validation Error',
                    html: '<ul class="text-left text-sm">@foreach ($errors->all() as $e)<li>- {{ $e }}</li>@endforeach</ul>',
                    confirmButtonColor: 'var(--primary)'
                });
            @endif

            // Global Delete Confirmation
            $(document).on('submit', '.sweet-alert-delete', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit();
                    }
                });
            });
        });
    </script>
</body>

</html>
