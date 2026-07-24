{{-- resources/views/developer/dashboard.blade.php --}}
@extends('layouts.developer')

@section('title', 'Developer Dashboard')
@section('page-title', 'Developer Dashboard')

@section('content')
<div x-data="developerDashboard()" x-init="init()" class="space-y-6">
    <!-- Welcome Banner -->
    <div class="card bg-gradient-to-r from-accent/5 via-accent/10 to-primary/5 border-accent/20">
        <div class="card-body">
            <div class="flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-accent/30 to-accent/10 rounded-2xl flex items-center justify-center shadow-lg shadow-accent/10">
                        <svg class="w-8 h-8 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Developer Dashboard</h1>
                        <p class="text-text-secondary dark:text-text-dark-secondary">Selamat datang, Anda memiliki akses penuh sebagai Developer</p>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2 px-3 py-1.5 bg-accent/10 text-accent text-sm rounded-full border border-accent/20">
                        <span class="inline-block w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                        <span>System Online</span>
                        <span class="w-px h-4 bg-accent/20"></span>
                        <span class="text-xs opacity-70">v{{ config('app.version', '1.0.0') }}</span>
                    </div>
                    <button @click="refreshDashboard" class="p-2 hover:bg-light-surface dark:hover:bg-dark-surface rounded-lg transition" title="Refresh Dashboard">
                        <svg class="w-5 h-5 text-text-secondary" :class="{'animate-spin': refreshing}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats - Real-time -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="card hover:shadow-lg transition-all group cursor-pointer" @click="navigateTo('users')">
            <div class="card-body py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider">Total Users</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_users)"></p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-success" x-text="'↑ ' + (stats.user_growth || 0) + '%'"></span>
                            <span class="text-xs text-text-secondary">this month</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary/20 transition">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-t border-light-border dark:border-dark-border flex justify-between text-xs">
                    <span class="text-success">Active: <span x-text="formatNumber(stats.active_users)"></span></span>
                    <span class="text-error">Inactive: <span x-text="formatNumber(stats.inactive_users)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer" @click="navigateTo('stores')">
            <div class="card-body py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider">Total Stores</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_stores)"></p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-success" x-text="'↑ ' + (stats.store_growth || 0) + '%'"></span>
                            <span class="text-xs text-text-secondary">this month</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center group-hover:bg-success/20 transition">
                        <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-t border-light-border dark:border-dark-border flex justify-between text-xs">
                    <span class="text-success">Active: <span x-text="formatNumber(stats.active_stores)"></span></span>
                    <span class="text-error">Inactive: <span x-text="formatNumber(stats.inactive_stores)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer" @click="navigateTo('roles')">
            <div class="card-body py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider">Total Roles</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_roles)"></p>
                        <p class="text-xs text-text-secondary mt-1">System & Custom Roles</p>
                    </div>
                    <div class="w-12 h-12 bg-info/10 rounded-xl flex items-center justify-center group-hover:bg-info/20 transition">
                        <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-t border-light-border dark:border-dark-border flex justify-between text-xs">
                    <span class="text-primary">System: <span x-text="formatNumber(stats.system_roles)"></span></span>
                    <span class="text-warning">Custom: <span x-text="formatNumber(stats.custom_roles)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer" @click="navigateTo('permissions')">
            <div class="card-body py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider">Permissions</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_permissions)"></p>
                        <p class="text-xs text-text-secondary mt-1">Granular Access Control</p>
                    </div>
                    <div class="w-12 h-12 bg-warning/10 rounded-xl flex items-center justify-center group-hover:bg-warning/20 transition">
                        <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-t border-light-border dark:border-dark-border flex justify-between text-xs">
                    <span class="text-success">Assigned: <span x-text="formatNumber(stats.assigned_permissions)"></span></span>
                    <span class="text-error">Unassigned: <span x-text="formatNumber(stats.unassigned_permissions)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer" @click="navigateTo('activity')">
            <div class="card-body py-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-text-secondary uppercase tracking-wider">Today's Activity</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.today_activity)"></p>
                        <p class="text-xs text-text-secondary mt-1">Last 24 hours</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-t border-light-border dark:border-dark-border flex justify-between text-xs">
                    <span class="text-info">Unique: <span x-text="formatNumber(stats.unique_activity_users)"></span></span>
                    <span class="text-text-secondary">users</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Growth</h3>
                <div class="flex gap-2">
                    <button @click="chartPeriod = 'week'; updateCharts()" :class="chartPeriod === 'week' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Week</button>
                    <button @click="chartPeriod = 'month'; updateCharts()" :class="chartPeriod === 'month' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Month</button>
                    <button @click="chartPeriod = 'year'; updateCharts()" :class="chartPeriod === 'year' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Year</button>
                </div>
            </div>
            <div class="card-body">
                <div class="h-64">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Revenue Trend</h3>
                <span class="text-xs text-text-secondary">Last 30 days</span>
            </div>
            <div class="card-body">
                <div class="h-64">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 card">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Recent Activity</h3>
                <a href="{{ route('developer.activity.index') }}" class="text-xs text-accent hover:underline">View All →</a>
            </div>
            <div class="card-body">
                <div class="space-y-3 max-h-80 overflow-y-auto">
                    <template x-for="activity in recentActivities" :key="activity.id">
                        <div class="flex items-start gap-3 p-3 rounded-lg hover:bg-light-surface dark:hover:bg-dark-surface transition">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0" 
                                 :class="getActivityColor(activity.type)">
                                <span x-text="getActivityIcon(activity.type)" class="text-lg"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm text-text-primary dark:text-text-dark-primary" x-text="activity.description"></p>
                                <div class="flex items-center gap-2 mt-0.5">
                                    <span class="text-xs text-text-secondary" x-text="activity.user?.name || 'System'"></span>
                                    <span class="w-1 h-1 rounded-full bg-text-secondary/30"></span>
                                    <span class="text-xs text-text-secondary" x-text="timeAgo(activity.created_at)"></span>
                                </div>
                            </div>
                            <span class="text-xs text-text-secondary flex-shrink-0" x-text="formatTime(activity.created_at)"></span>
                        </div>
                    </template>
                    <div x-show="recentActivities.length === 0" class="text-center py-8 text-text-secondary">
                        <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p>Belum ada aktivitas</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Status -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Quick Actions</h3>
                </div>
                <div class="card-body">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('developer.users.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span class="text-xs">Users</span>
                        </a>
                        <a href="{{ route('developer.roles.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-xs">Roles</span>
                        </a>
                        <a href="{{ route('developer.permissions.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span class="text-xs">Permissions</span>
                        </a>
                        <a href="{{ route('developer.stores.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span class="text-xs">Stores</span>
                        </a>
                        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                            <span class="text-xs">System</span>
                        </a>
                        <a href="{{ route('developer.logs.index') }}" class="btn btn-outline text-center py-2.5 text-sm hover:border-accent hover:text-accent transition group">
                            <svg class="w-5 h-5 mx-auto mb-1 group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span class="text-xs">Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">System Status</h3>
                </div>
                <div class="card-body space-y-2">
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border dark:border-dark-border">
                        <span class="text-xs text-text-secondary">PHP Version</span>
                        <span class="text-xs font-medium text-text-primary dark:text-text-dark-primary">{{ phpversion() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border dark:border-dark-border">
                        <span class="text-xs text-text-secondary">Laravel</span>
                        <span class="text-xs font-medium text-text-primary dark:text-text-dark-primary">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border dark:border-dark-border">
                        <span class="text-xs text-text-secondary">Environment</span>
                        <span class="text-xs font-medium" :class="'{{ app()->environment() }}' === 'production' ? 'text-success' : 'text-warning'">
                            {{ app()->environment() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border dark:border-dark-border">
                        <span class="text-xs text-text-secondary">Debug Mode</span>
                        <span class="text-xs font-medium" :class="'{{ config('app.debug') }}' ? 'text-error' : 'text-success'">
                            {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border dark:border-dark-border">
                        <span class="text-xs text-text-secondary">Database</span>
                        <span class="text-xs font-medium text-success">🟢 Connected</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-xs text-text-secondary">Queue Worker</span>
                        <span class="text-xs font-medium text-success">🟢 Running</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid md:grid-cols-2 gap-6">
        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Growth</h3>
                <div class="flex gap-2">
                    <button @click="chartPeriod = 'week'; updateCharts()" :class="chartPeriod === 'week' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Week</button>
                    <button @click="chartPeriod = 'month'; updateCharts()" :class="chartPeriod === 'month' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Month</button>
                    <button @click="chartPeriod = 'year'; updateCharts()" :class="chartPeriod === 'year' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Year</button>
                </div>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header flex justify-between items-center">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Revenue</h3>
                <div class="flex gap-2">
                    <button @click="chartPeriod = 'week'; updateCharts()" :class="chartPeriod === 'week' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Week</button>
                    <button @click="chartPeriod = 'month'; updateCharts()" :class="chartPeriod === 'month' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Month</button>
                    <button @click="chartPeriod = 'year'; updateCharts()" :class="chartPeriod === 'year' ? 'btn btn-sm btn-primary' : 'btn btn-sm btn-outline'">Year</button>
                </div>
            </div>
            <div class="card-body">
                <div style="height: 300px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Server Resources -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">CPU Usage</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-surface" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-accent" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.cpu_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="(stats.cpu_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Current CPU Load</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Memory Usage</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-surface" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-info" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.memory_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="(stats.memory_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Memory Usage</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Storage</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-surface" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-warning" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.storage_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="(stats.storage_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs text-text-secondary mt-2">Storage Used</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function developerDashboard() {
    return {
        stats: {
            total_users: {{ $stats['total_users'] ?? 0 }},
            active_users: {{ $stats['active_users'] ?? 0 }},
            inactive_users: {{ $stats['inactive_users'] ?? 0 }},
            total_stores: {{ $stats['total_stores'] ?? 0 }},
            active_stores: {{ $stats['active_stores'] ?? 0 }},
            inactive_stores: {{ $stats['inactive_stores'] ?? 0 }},
            total_roles: {{ $stats['total_roles'] ?? 0 }},
            system_roles: 4,
            custom_roles: {{ ($stats['total_roles'] ?? 0) - 4 }},
            total_permissions: {{ $stats['total_permissions'] ?? 0 }},
            assigned_permissions: 0,
            unassigned_permissions: 0,
            today_activity: 0,
            unique_activity_users: 0,
            user_growth: 12.5,
            store_growth: 8.3,
            cpu_usage: 45,
            memory_usage: 62,
            storage_usage: 38
        },
        recentActivities: [],
        chartPeriod: 'month',
        refreshing: false,
        userGrowthChart: null,
        revenueChart: null,

        init() {
            this.loadRecentActivities();
            this.initCharts();
            // Auto-refresh every 60 seconds
            setInterval(() => {
                this.refreshDashboard();
            }, 60000);
        },

        async loadRecentActivities() {
            try {
                const response = await axios.get('/developer/api/activity/recent');
                if (response.data.success) {
                    this.recentActivities = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load recent activities:', error);
                // Fallback sample data
                this.recentActivities = [
                    { id: 1, type: 'login', description: 'User logged in', user: { name: 'Admin' }, created_at: new Date().toISOString() },
                    { id: 2, type: 'update', description: 'Updated product settings', user: { name: 'Developer' }, created_at: new Date(Date.now() - 3600000).toISOString() },
                    { id: 3, type: 'create', description: 'Created new user account', user: { name: 'Manager' }, created_at: new Date(Date.now() - 7200000).toISOString() }
                ];
            }
        },

        initCharts() {
            this.initUserGrowthChart();
            this.initRevenueChart();
        },

        initUserGrowthChart() {
            const ctx = document.getElementById('userGrowthChart');
            if (!ctx) {
                console.warn('Canvas element #userGrowthChart not found');
                return;
            }

            // Destroy existing chart if it exists
            if (this.userGrowthChart) {
                this.userGrowthChart.destroy();
            }

            // Sample data - will be updated by period
            const data = this.getChartData('user');

            try {
                this.userGrowthChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'New Users',
                        data: data.values,
                        borderColor: '#00D27A',
                        backgroundColor: 'rgba(0, 210, 122, 0.1)',
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#00D27A',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            } catch (error) {
                console.error('Failed to initialize user growth chart:', error);
            }
        },

        initRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) {
                console.warn('Canvas element #revenueChart not found');
                return;
            }

            // Destroy existing chart if it exists
            if (this.revenueChart) {
                this.revenueChart.destroy();
            }

            const data = this.getChartData('revenue');

            try {
                this.revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Revenue (IDR)',
                        data: data.values,
                        backgroundColor: [
                            'rgba(0, 210, 122, 0.6)',
                            'rgba(0, 210, 122, 0.8)',
                            'rgba(0, 210, 122, 0.6)',
                            'rgba(0, 210, 122, 0.9)'
                        ],
                        borderColor: '#00D27A',
                        borderWidth: 1,
                        borderRadius: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            } catch (error) {
                console.error('Failed to initialize revenue chart:', error);
            }
        },

        getChartData(type) {
            // Sample data by period
            const userData = {
                week: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    values: [12, 19, 15, 22, 18, 25, 20]
                },
                month: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    values: [65, 78, 90, 85]
                },
                year: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    values: [65, 78, 90, 85, 95, 110, 120, 115, 130, 145, 150, 165]
                }
            };

            const revenueData = {
                week: {
                    labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                    values: [2500000, 3200000, 2800000, 4500000, 3800000, 5200000, 4800000]
                },
                month: {
                    labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                    values: [2500000, 3200000, 2800000, 4500000]
                },
                year: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    values: [2500000, 3200000, 2800000, 4500000, 3800000, 5200000, 4800000, 6000000, 5500000, 7000000, 6500000, 8500000]
                }
            };

            const data = type === 'user' ? userData : revenueData;
            const period = this.chartPeriod || 'month';
            return data[period] || data.month;
        },

        updateCharts() {
            if (this.userGrowthChart) {
                const data = this.getChartData('user');
                this.userGrowthChart.data.labels = data.labels;
                this.userGrowthChart.data.datasets[0].data = data.values;
                this.userGrowthChart.update();
            }
            if (this.revenueChart) {
                const data = this.getChartData('revenue');
                this.revenueChart.data.labels = data.labels;
                this.revenueChart.data.datasets[0].data = data.values;
                this.revenueChart.update();
            }
        },

        async refreshDashboard() {
            this.refreshing = true;
            try {
                const response = await axios.get('/developer/api/stats');
                if (response.data.success) {
                    this.stats = { ...this.stats, ...response.data.data };
                }
                await this.loadRecentActivities();
            } catch (error) {
                console.error('Failed to refresh dashboard:', error);
            }
            this.refreshing = false;
        },

        navigateTo(page) {
            const routes = {
                'users': '{{ route("developer.users.index") }}',
                'stores': '{{ route("developer.stores.index") }}',
                'roles': '{{ route("developer.roles.index") }}',
                'permissions': '{{ route("developer.permissions.index") }}',
                'activity': '{{ route("developer.activity.index") }}'
            };
            window.location.href = routes[page] || '#';
        },

        getActivityColor(type) {
            const colors = {
                'login': 'bg-success/10 text-success',
                'logout': 'bg-secondary/10 text-secondary',
                'create': 'bg-primary/10 text-primary',
                'update': 'bg-info/10 text-info',
                'delete': 'bg-error/10 text-error',
                'status_change': 'bg-warning/10 text-warning',
                'role_change': 'bg-accent/10 text-accent',
                'permission_change': 'bg-purple-100 text-purple-600',
                'export': 'bg-cyan-100 text-cyan-600',
                'import': 'bg-cyan-100 text-cyan-600',
                'system': 'bg-gray-100 text-gray-600'
            };
            return colors[type] || 'bg-gray-100 text-gray-600';
        },

        getActivityIcon(type) {
            const icons = {
                'login': '🔑',
                'logout': '🚪',
                'create': '📝',
                'update': '✏️',
                'delete': '🗑️',
                'status_change': '🔄',
                'role_change': '🎭',
                'permission_change': '🔐',
                'export': '📤',
                'import': '📥',
                'system': '⚙️'
            };
            return icons[type] || '📌';
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        },

        formatTime(date) {
            if (!date) return '-';
            return new Date(date).toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        },

        timeAgo(date) {
            if (!date) return '-';
            const seconds = Math.floor((new Date() - new Date(date)) / 1000);
            const intervals = {
                year: 31536000,
                month: 2592000,
                week: 604800,
                day: 86400,
                hour: 3600,
                minute: 60,
                second: 1
            };
            
            for (const [unit, secondsInUnit] of Object.entries(intervals)) {
                const count = Math.floor(seconds / secondsInUnit);
                if (count >= 1) {
                    return count + ' ' + unit + (count > 1 ? 's' : '') + ' ago';
                }
            }
            return 'Just now';
        }
    }
}
</script>
@endpush
@endsection