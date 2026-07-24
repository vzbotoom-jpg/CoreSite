{{-- resources/views/layouts/partials/developer-sidebar.blade.php --}}
<aside x-data="{ collapsed: false }"
       class="relative bg-light-bg dark:bg-dark-bg border-r border-light-border dark:border-dark-border text-text-primary dark:text-text-dark-primary flex-shrink-0 flex flex-col transition-all duration-300 overflow-hidden h-screen"
       :class="collapsed ? 'w-20' : 'w-64'">

    <!-- Logo -->
    <div class="flex items-center justify-between gap-2 p-4 border-b border-light-border dark:border-dark-border flex-shrink-0">
        <a href="{{ route('developer.dashboard') }}" class="flex items-center gap-3 overflow-hidden">
            <div class="w-10 h-10 bg-accent rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg shadow-accent/20">
                <span class="text-white font-bold text-xl">C</span>
            </div>
            <div class="flex items-center gap-2 whitespace-nowrap transition-all duration-300"
                 :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                <span class="text-xl font-bold text-text-primary dark:text-text-dark-primary">CoreSite</span>
                <span class="text-xs bg-accent/20 text-accent px-2 py-0.5 rounded">Dev</span>
            </div>
        </a>
    </div>

    <!-- Collapse Toggle -->
    <button @click="collapsed = !collapsed"
            class="absolute -right-3 top-[4.5rem] bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-full p-1 hover:bg-accent/20 transition z-20 hidden lg:block">
        <svg class="w-4 h-4 text-text-primary dark:text-text-dark-primary transition-transform duration-300"
             :class="collapsed ? 'rotate-180' : ''"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
    </button>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto p-3 space-y-1">

        {{-- Reusable section label --}}
        @php
            $sections = [
                'main' => 'Main Menu',
                'management' => 'Management',
                'system' => 'System',
                'tools' => 'Tools',
            ];
        @endphp

        <!-- Main Menu -->
        <p class="text-xs text-gray-500 uppercase tracking-wider px-3 py-2 whitespace-nowrap overflow-hidden"
           :class="collapsed ? 'text-center' : ''">
            <span x-show="!collapsed" x-cloak>Main Menu</span>
            <span x-show="collapsed" x-cloak>&middot;&middot;&middot;</span>
        </p>

        <a href="{{ route('developer.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('developer.dashboard') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Dashboard' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Dashboard</span>
        </a>

        <!-- User Management -->
        <p class="text-xs text-gray-500 uppercase tracking-wider px-3 py-2 mt-4 whitespace-nowrap overflow-hidden"
           :class="collapsed ? 'text-center' : ''">
            <span x-show="!collapsed" x-cloak>Management</span>
            <span x-show="collapsed" x-cloak>&middot;&middot;&middot;</span>
        </p>

        <a href="{{ route('developer.users.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.users.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Users' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Users</span>
        </a>

        <a href="{{ route('developer.roles.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.roles.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Roles' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Roles</span>
        </a>

        <a href="{{ route('developer.permissions.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.permissions.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Permissions' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Permissions</span>
        </a>

        <a href="{{ route('developer.stores.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.stores.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Stores' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Stores</span>
        </a>

        <!-- System -->
        <p class="text-xs text-gray-500 uppercase tracking-wider px-3 py-2 mt-4 whitespace-nowrap overflow-hidden"
           :class="collapsed ? 'text-center' : ''">
            <span x-show="!collapsed" x-cloak>System</span>
            <span x-show="collapsed" x-cloak>&middot;&middot;&middot;</span>
        </p>

        <a href="{{ route('developer.system.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.system.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'System' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">System</span>
        </a>

        <a href="{{ route('developer.logs.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.logs.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Logs' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Logs</span>
        </a>

        <a href="{{ route('developer.activity.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.activity.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Activity' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Activity</span>
        </a>

        <a href="{{ route('developer.stats.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.stats.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Statistics' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Statistics</span>
        </a>

        <!-- Tools -->
        <p class="text-xs text-gray-500 uppercase tracking-wider px-3 py-2 mt-4 whitespace-nowrap overflow-hidden"
           :class="collapsed ? 'text-center' : ''">
            <span x-show="!collapsed" x-cloak>Tools</span>
            <span x-show="collapsed" x-cloak>&middot;&middot;&middot;</span>
        </p>

        <a href="{{ route('developer.maintenance.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.maintenance.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Maintenance' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Maintenance</span>
        </a>

        <a href="{{ route('developer.backup.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.backup.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Backup' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Backup</span>
        </a>

        <a href="{{ route('developer.jobs.index') }}"
           class="sidebar-link {{ request()->routeIs('developer.jobs.*') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'Jobs' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">Jobs</span>
        </a>

        <a href="{{ route('developer.system.phpinfo') }}" target="_blank"
           class="sidebar-link {{ request()->routeIs('developer.system.phpinfo') ? 'sidebar-link-active' : '' }}"
           :class="collapsed ? 'justify-center' : ''"
           :title="collapsed ? 'PHP Info' : ''">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="whitespace-nowrap overflow-hidden transition-all duration-300" :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">PHP Info</span>
        </a>
    </nav>

    <!-- User Info -->
    <div class="flex-shrink-0 p-4 border-t border-light-border dark:border-dark-border bg-light-surface/50 dark:bg-dark-surface/50 backdrop-blur">
        <div class="flex items-center gap-3" :class="collapsed ? 'justify-center' : ''">
            <div class="w-9 h-9 bg-accent/20 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-accent font-semibold text-sm">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0 overflow-hidden whitespace-nowrap transition-all duration-300"
                 :class="collapsed ? 'opacity-0 w-0' : 'opacity-100 w-auto'">
                <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary truncate">
                    {{ auth()->user()->name }}
                </p>
                <p class="text-xs text-accent">Developer</p>
            </div>
            <button onclick="document.getElementById('logout-form-sidebar').submit()"
                    class="text-text-secondary hover:text-error dark:text-text-dark-secondary dark:hover:text-error transition flex-shrink-0"
                    :class="collapsed ? 'hidden' : ''"
                    title="Logout">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
            </button>
            <form id="logout-form-sidebar" method="POST" action="{{ route('logout') }}" class="hidden">
                @csrf
            </form>
        </div>
    </div>
</aside>

<!-- Sidebar CSS -->
<style>
.sidebar-link {
    @apply flex items-center gap-3 px-3 py-2.5 rounded-lg text-text-secondary hover:text-accent hover:bg-accent/10 transition-all duration-200 text-sm dark:text-text-dark-secondary dark:hover:text-accent dark:hover:bg-accent/20;
}

.sidebar-link-active {
    @apply text-accent bg-accent/10 shadow-lg shadow-accent/5 dark:bg-accent/20 dark:shadow-accent/10;
}

.sidebar-link-active svg {
    @apply text-accent;
}
</style>