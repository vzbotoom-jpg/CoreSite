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
        <div class="card hover:shadow-lg transition-all group cursor-pointer bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click="navigateTo('users')">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-text-secondary uppercase tracking-wider">Total Users</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_users)"></p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-success font-semibold" x-text="'↑ ' + (stats.user_growth || 0) + '%'"></span>
                            <span class="text-[10px] font-medium text-text-secondary">this month</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center group-hover:bg-primary/20 transition">
                        <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-t border-light-border dark:border-dark-border/40 flex justify-between text-xs font-semibold">
                    <span class="text-success">Active: <span x-text="formatNumber(stats.active_users)"></span></span>
                    <span class="text-error">Inactive: <span x-text="formatNumber(stats.inactive_users)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click="navigateTo('stores')">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-text-secondary uppercase tracking-wider">Total Stores</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_stores)"></p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-xs text-success font-semibold" x-text="'↑ ' + (stats.store_growth || 0) + '%'"></span>
                            <span class="text-[10px] font-medium text-text-secondary">this month</span>
                        </div>
                    </div>
                    <div class="w-12 h-12 bg-success/10 rounded-xl flex items-center justify-center group-hover:bg-success/20 transition">
                        <svg class="w-6 h-6 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-t border-light-border dark:border-dark-border/40 flex justify-between text-xs font-semibold">
                    <span class="text-success">Active: <span x-text="formatNumber(stats.active_stores)"></span></span>
                    <span class="text-error">Inactive: <span x-text="formatNumber(stats.inactive_stores)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click="navigateTo('roles')">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-text-secondary uppercase tracking-wider">Total Roles</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_roles)"></p>
                        <p class="text-[10px] text-text-secondary mt-1 font-medium">System & Custom Roles</p>
                    </div>
                    <div class="w-12 h-12 bg-info/10 rounded-xl flex items-center justify-center group-hover:bg-info/20 transition">
                        <svg class="w-6 h-6 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-t border-light-border dark:border-dark-border/40 flex justify-between text-xs font-semibold">
                    <span class="text-primary">System: <span x-text="formatNumber(stats.system_roles)"></span></span>
                    <span class="text-warning">Custom: <span x-text="formatNumber(stats.custom_roles)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click="navigateTo('permissions')">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-text-secondary uppercase tracking-wider">Permissions</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.total_permissions)"></p>
                        <p class="text-[10px] text-text-secondary mt-1 font-medium">Granular Access Control</p>
                    </div>
                    <div class="w-12 h-12 bg-warning/10 rounded-xl flex items-center justify-center group-hover:bg-warning/20 transition">
                        <svg class="w-6 h-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-t border-light-border dark:border-dark-border/40 flex justify-between text-xs font-semibold">
                    <span class="text-success">Assigned: <span x-text="formatNumber(stats.assigned_permissions)"></span></span>
                    <span class="text-error">Unassigned: <span x-text="formatNumber(stats.unassigned_permissions)"></span></span>
                </div>
            </div>
        </div>

        <div class="card hover:shadow-lg transition-all group cursor-pointer bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border" @click="navigateTo('activity')">
            <div class="card-body p-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-[10px] font-bold text-text-secondary uppercase tracking-wider">Today's Activity</p>
                        <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mt-1" x-text="formatNumber(stats.today_activity)"></p>
                        <p class="text-[10px] text-text-secondary mt-1 font-medium">Last 24 hours</p>
                    </div>
                    <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center group-hover:bg-accent/20 transition">
                        <svg class="w-6 h-6 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                </div>
                <div class="mt-4 pt-2 border-t border-light-border dark:border-dark-border/40 flex justify-between text-xs font-semibold">
                    <span class="text-info">Unique: <span x-text="formatNumber(stats.unique_activity_users)"></span></span>
                    <span class="text-text-secondary">users</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border/60 pb-4 flex justify-between items-center">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">User Growth</h3>
                <div class="flex gap-2">
                    <button @click="chartPeriod = 'week'; updateCharts()" :class="chartPeriod === 'week' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Week</button>
                    <button @click="chartPeriod = 'month'; updateCharts()" :class="chartPeriod === 'month' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Month</button>
                    <button @click="chartPeriod = 'year'; updateCharts()" :class="chartPeriod === 'year' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Year</button>
                </div>
            </div>
            <div class="card-body p-5">
                <div style="height: 280px;">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>
        </div>

        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border/60 pb-4 flex justify-between items-center">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Revenue Trend</h3>
                <div class="flex gap-2">
                    <button @click="chartPeriod = 'week'; updateCharts()" :class="chartPeriod === 'week' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Week</button>
                    <button @click="chartPeriod = 'month'; updateCharts()" :class="chartPeriod === 'month' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Month</button>
                    <button @click="chartPeriod = 'year'; updateCharts()" :class="chartPeriod === 'year' ? 'bg-accent text-white' : 'bg-light-surface dark:bg-dark-bg text-text-secondary hover:bg-accent/10'" class="px-2.5 py-1 text-xs font-bold rounded-lg transition-colors">Year</button>
                </div>
            </div>
            <div class="card-body p-5">
                <div style="height: 280px;">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Quick Actions -->
    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Recent Activity -->
        <div class="lg:col-span-2 card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4 flex justify-between items-center">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Recent Activity</h3>
                <a href="{{ route('developer.activity.index') }}" class="text-xs text-accent font-bold hover:underline">View All →</a>
            </div>
            <div class="card-body p-5">
                <div class="space-y-3.5 max-h-80 overflow-y-auto">
                    <template x-for="activity in recentActivities" :key="activity.id">
                        <div class="flex items-start gap-3.5 p-3 rounded-lg hover:bg-light-bg/50 dark:hover:bg-dark-bg/40 border border-light-border/40 dark:border-dark-border/10 transition">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center shrink-0 shadow-xs"
                                 :class="getActivityColor(activity.type)">
                                <span x-html="getActivityIcon(activity.type)" class="flex items-center justify-center"></span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-xs font-semibold text-text-primary dark:text-text-dark-primary" x-text="activity.description"></p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-[10px] font-bold text-text-secondary uppercase" x-text="activity.user?.name || 'System'"></span>
                                    <span class="w-1.5 h-1.5 rounded-full bg-text-secondary/20"></span>
                                    <span class="text-[10px] text-text-secondary font-medium" x-text="timeAgo(activity.created_at)"></span>
                                </div>
                            </div>
                            <span class="text-[10px] text-text-secondary/60 shrink-0 font-mono" x-text="formatTime(activity.created_at)"></span>
                        </div>
                    </template>
                    <div x-show="recentActivities.length === 0" class="text-center py-12 text-text-secondary">
                        <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="text-xs italic">Belum ada aktivitas terbaru</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions & System Status -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Quick Actions</h3>
                </div>
                <div class="card-body p-4">
                    <div class="grid grid-cols-2 gap-2">
                        <a href="{{ route('developer.users.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span>Users</span>
                        </a>
                        <a href="{{ route('developer.roles.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Roles</span>
                        </a>
                        <a href="{{ route('developer.permissions.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                            <span>Permissions</span>
                        </a>
                        <a href="{{ route('developer.stores.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            <span>Stores</span>
                        </a>
                        <a href="{{ route('developer.system.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                            <span>System</span>
                        </a>
                        <a href="{{ route('developer.logs.index') }}" class="btn btn-outline text-center py-2.5 text-xs font-semibold text-text-primary dark:text-text-dark-primary hover:text-accent dark:hover:text-accent border-light-border dark:border-dark-border flex flex-col justify-center items-center gap-1 hover:scale-[1.02] transition shadow-xs group">
                            <svg class="w-5 h-5 mx-auto group-hover:text-accent transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <span>Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- System Status -->
            <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
                <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                    <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">System Status</h3>
                </div>
                <div class="card-body p-5 space-y-2">
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border/60 dark:border-dark-border/40">
                        <span class="text-xs text-text-secondary">PHP Version</span>
                        <span class="text-xs font-bold text-text-primary dark:text-text-dark-primary">{{ phpversion() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border/60 dark:border-dark-border/40">
                        <span class="text-xs text-text-secondary">Laravel</span>
                        <span class="text-xs font-bold text-text-primary dark:text-text-dark-primary">{{ app()->version() }}</span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border/60 dark:border-dark-border/40">
                        <span class="text-xs text-text-secondary">Environment</span>
                        <span class="text-xs font-bold text-white px-2 py-0.5 rounded-full" :class="'{{ app()->environment() }}' === 'production' ? 'bg-emerald-500' : 'bg-amber-500'">
                            {{ app()->environment() }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border/60 dark:border-dark-border/40">
                        <span class="text-xs text-text-secondary">Debug Mode</span>
                        <span class="text-xs font-bold text-white px-2 py-0.5 rounded-full" :class="'{{ config('app.debug') }}' ? 'bg-rose-500' : 'bg-emerald-500'">
                            {{ config('app.debug') ? 'Enabled' : 'Disabled' }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5 border-b border-light-border/60 dark:border-dark-border/40">
                        <span class="text-xs text-text-secondary">Database</span>
                        <span class="text-xs font-bold text-white bg-emerald-500 px-2 py-0.5 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> Connected
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-1.5">
                        <span class="text-xs text-text-secondary">Queue Worker</span>
                        <span class="text-xs font-bold text-white bg-emerald-500 px-2 py-0.5 rounded-full flex items-center gap-1">
                            <span class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></span> Running
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Server Resources -->
    <div class="grid md:grid-cols-3 gap-6">
        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">CPU Usage</h3>
            </div>
            <div class="card-body p-6">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-bg" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-accent" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.cpu_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-text-primary dark:text-text-dark-primary" x-text="(stats.cpu_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs font-semibold text-text-secondary mt-3 uppercase tracking-wider">Current CPU Load</p>
                </div>
            </div>
        </div>

        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Memory Usage</h3>
            </div>
            <div class="card-body p-6">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-bg" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-info" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.memory_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-text-primary dark:text-text-dark-primary" x-text="(stats.memory_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs font-semibold text-text-secondary mt-3 uppercase tracking-wider">Memory Used</p>
                </div>
            </div>
        </div>

        <div class="card bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border">
            <div class="card-header border-b border-light-border dark:border-dark-border pb-4">
                <h3 class="font-bold text-text-primary dark:text-text-dark-primary text-sm uppercase tracking-wider">Storage</h3>
            </div>
            <div class="card-body p-6">
                <div class="text-center">
                    <div class="relative inline-flex">
                        <svg class="w-32 h-32 transform -rotate-90">
                            <circle class="text-light-surface dark:text-dark-bg" stroke-width="8" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64"/>
                            <circle class="text-warning" stroke-width="8" stroke-linecap="round" stroke="currentColor" fill="transparent" r="56" cx="64" cy="64" 
                                    stroke-dasharray="351.858" :stroke-dashoffset="351.858 - (351.858 * (stats.storage_usage || 0) / 100)"/>
                        </svg>
                        <span class="absolute inset-0 flex items-center justify-center text-2xl font-extrabold text-text-primary dark:text-text-dark-primary" x-text="(stats.storage_usage || 0) + '%'"></span>
                    </div>
                    <p class="text-xs font-semibold text-text-secondary mt-3 uppercase tracking-wider">Storage Used</p>
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
            system_roles: {{ $stats['system_roles'] ?? 0 }},
            custom_roles: {{ $stats['custom_roles'] ?? 0 }},
            total_permissions: {{ $stats['total_permissions'] ?? 0 }},
            assigned_permissions: {{ $stats['assigned_permissions'] ?? 0 }},
            unassigned_permissions: {{ $stats['unassigned_permissions'] ?? 0 }},
            today_activity: {{ $stats['today_activity'] ?? 0 }},
            unique_activity_users: {{ $stats['unique_activity_users'] ?? 0 }},
            user_growth: {{ $stats['user_growth'] ?? 0 }},
            store_growth: {{ $stats['store_growth'] ?? 0 }},
            cpu_usage: {{ $stats['cpu_usage'] ?? 0 }},
            memory_usage: {{ $stats['memory_usage'] ?? 0 }},
            storage_usage: {{ $stats['storage_usage'] ?? 0 }}
        },
        chartsData: null,
        recentActivities: [],
        chartPeriod: 'month',
        refreshing: false,
        userGrowthChart: null,
        revenueChart: null,

        async init() {
            await this.refreshDashboard();
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
            }
        },

        initCharts() {
            this.initUserGrowthChart();
            this.initRevenueChart();
        },

        initUserGrowthChart() {
            const ctx = document.getElementById('userGrowthChart');
            if (!ctx) return;

            if (this.userGrowthChart) {
                this.userGrowthChart.destroy();
            }

            const data = this.getChartData('user');

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
                                color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#94A3B8',
                                stepSize: 1
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94A3B8'
                            }
                        }
                    }
                }
            });
        },

        initRevenueChart() {
            const ctx = document.getElementById('revenueChart');
            if (!ctx) return;

            if (this.revenueChart) {
                this.revenueChart.destroy();
            }

            const data = this.getChartData('revenue');

            this.revenueChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: data.labels,
                    datasets: [{
                        label: 'Revenue (IDR)',
                        data: data.values,
                        backgroundColor: 'rgba(0, 210, 122, 0.85)',
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
                                color: document.documentElement.classList.contains('dark') ? 'rgba(255, 255, 255, 0.05)' : 'rgba(0, 0, 0, 0.05)'
                            },
                            ticks: {
                                color: '#94A3B8',
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return 'Rp ' + (value / 1000).toFixed(0) + 'k';
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#94A3B8'
                            }
                        }
                    }
                }
            });
        },

        getChartData(type) {
            const period = this.chartPeriod || 'month';
            if (this.chartsData && this.chartsData[type] && this.chartsData[type][period]) {
                return this.chartsData[type][period];
            }
            // Standard fallback
            return {
                labels: period === 'week' ? ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] : ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                values: period === 'week' ? [0, 0, 0, 0, 0, 0, 0] : [0, 0, 0, 0]
            };
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
                    const resData = response.data.data;
                    this.stats = { ...this.stats, ...resData };
                    this.chartsData = resData.charts || null;
                    this.updateCharts();
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
            // High-fidelity Heroicons inline SVGs for professional dashboard list
            const icons = {
                'login': `<svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m0 0a2 2 0 01-2 2m2-2h3m-3 4a2 2 0 01-2 2m0 0a2 2 0 01-2-2m2 2v3m-2-3H9m2-4H3m6-4a2 2 0 11-4 0 2 2 0 014 0z"/></svg>`,
                'logout': `<svg class="w-5 h-5 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>`,
                'create': `<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>`,
                'update': `<svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>`,
                'delete': `<svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>`,
                'status_change': `<svg class="w-5 h-5 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>`,
                'role_change': `<svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>`,
                'permission_change': `<svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>`,
                'export': `<svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>`,
                'import': `<svg class="w-5 h-5 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4-4v12"/></svg>`,
                'system': `<svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>`
            };
            return icons[type] || `<svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5h5v5H5zm10 0h5v5h-5zM5 15h5v5H5zm10 0h5v5h-5z"/></svg>`;
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