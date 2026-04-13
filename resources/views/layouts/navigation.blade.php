<aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    class="absolute z-40 flex flex-col w-64 h-screen transition-transform duration-300 ease-in-out lg:static lg:translate-x-0 bg-sidebar border-r border-sidebar-border shadow-xl">

    <!-- Sidebar Header / Logo -->
    <div class="flex items-center h-16 px-6 py-4 bg-sidebar-header border-b border-sidebar-border">
        <a href="{{ route('dashboard') }}" class="flex items-center text-lg font-black tracking-wider uppercase">
            <svg class="w-8 h-8 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z">
                </path>
            </svg>
            {{ config('app.name') }}
        </a>
    </div>

    <!-- Sidebar Links Context Menu -->
    <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
        <a href="{{ route('dashboard') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('dashboard') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                </path>
            </svg>
            Dashboard
        </a>

        <p class="px-4 pt-6 pb-2 text-xs font-bold uppercase tracking-wider text-muted">Inventory Settings</p>

        @can('view.categories')
            <a href="{{ route('categories.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('categories.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                    </path>
                </svg>
                Categories
            </a>
        @endcan

        @can('view.products')
            <a href="{{ route('products.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('products.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                </svg>
                Products
            </a>
        @endcan

        @can('view.suppliers')
            <a href="{{ route('suppliers.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('suppliers.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                    </path>
                </svg>
                Brand Suppliers
            </a>
        @endcan


        @canany(['view.purchases', 'view.orders', 'view.customers'])
            <p class="px-4 pt-6 pb-2 text-xs font-bold uppercase tracking-wider text-muted">Finance & Trading</p>
        @endcan

        @can('view.purchases')
            <a href="{{ route('purchases.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('purchases.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Restock (Inbound)
            </a>
        @endcan

        @can('view.orders')
            <a href="{{ route('orders.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('orders.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
                Point of Sale
            </a>
        @endcan

        @can('view.customers')
            <a href="{{ route('customers.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('customers.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                    </path>
                </svg>
                Client Directory
            </a>
        @endcan

        @canany(['view.staff', 'view.roles', 'view.reports'])
            <p class="px-4 pt-6 pb-2 text-xs font-bold uppercase tracking-wider text-muted">Monitoring</p>
        @endcan

        @can('view.staff')
            <a href="{{ route('users.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('users.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 11-8 0 4 4 0 018 0z">
                    </path>
                </svg>
                Staff Accounts
            </a>
        @endcan

        @can('view.roles')
            <a href="{{ route('roles.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('roles.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                    </path>
                </svg>
                Roles & Permissions
            </a>
            <a href="{{ route('permissions.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('permissions.*') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z">
                    </path>
                </svg>
                System Permissions
            </a>
        @endcan

        @can('view.reports')
            <a href="{{ route('reports.index') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('reports.index') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                System Reports
            </a>
            <a href="{{ route('reports.ledger') }}"
                class="flex items-center gap-3 px-4 py-3 rounded-lg font-medium transition {{ request()->routeIs('reports.ledger') ? 'bg-primary text-white shadow' : 'text-muted hover:bg-primary/10 hover:text-primary' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                    </path>
                </svg>
                Financial Ledger
            </a>
        @endcan
    </nav>
</aside>

<!-- Black Overlay for Mobile Drawer Menu -->
<div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
    class="fixed inset-0 z-30 bg-gray-900 bg-opacity-50 backdrop-blur-sm lg:hidden" style="display: none;">
</div>
