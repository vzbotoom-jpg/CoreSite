{{-- resources/views/developer/stats/users.blade.php --}}
@extends('layouts.developer')

@section('title', 'User Statistics')
@section('page-title', 'User Statistics')

@section('content')
<div x-data="userStats()" x-init="init()" class="space-y-6">
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Statistik lengkap pengguna sistem</p>
        </div>
        <a href="{{ route('developer.stats.index') }}" class="btn btn-outline text-sm">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data...</p>
    </div>

    <div x-show="!loading" x-cloak>
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Total Users</p>
                            <p class="text-2xl font-bold" x-text="formatNumber(stats.total)"></p>
                        </div>
                        <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Active Users</p>
                            <p class="text-2xl font-bold text-success" x-text="formatNumber(stats.active)"></p>
                        </div>
                        <div class="w-10 h-10 bg-success/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">New This Month</p>
                            <p class="text-2xl font-bold text-accent" x-text="formatNumber(stats.new_this_month)"></p>
                        </div>
                        <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body py-3">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-xs text-text-secondary">Admins</p>
                            <p class="text-2xl font-bold text-info" x-text="formatNumber(stats.admins)"></p>
                        </div>
                        <div class="w-10 h-10 bg-info/10 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-info" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="grid lg:grid-cols-2 gap-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Growth</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="userGrowthChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">User Distribution</h3>
                </div>
                <div class="card-body">
                    <div class="h-64">
                        <canvas id="userDistributionChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Distribution -->
        <div class="card">
            <div class="card-header">
                <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Role Distribution</h3>
            </div>
            <div class="card-body">
                <div class="space-y-4">
                    <template x-for="role in stats.role_distribution" :key="role.name">
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="text-text-primary dark:text-text-dark-primary" x-text="role.name"></span>
                                <span class="text-text-secondary" x-text="role.count + ' users (' + role.percentage + '%)'"></span>
                            </div>
                            <div class="w-full bg-light-surface dark:bg-dark-surface rounded-full h-2">
                                <div class="bg-accent h-2 rounded-full" :style="`width: ${role.percentage}%`"></div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function userStats() {
    return {
        stats: {},
        loading: false,

        init() {
            this.loadStats();
        },

        async loadStats() {
            this.loading = true;
            try {
                const response = await axios.get('/developer/stats/users');
                if (response.data.success) {
                    this.stats = response.data.data;
                    this.renderCharts();
                }
            } catch (error) {
                console.error('Failed to load user stats:', error);
                window.showToast('Gagal memuat statistik user', 'error');
            }
            this.loading = false;
        },

        renderCharts() {
            // Implementation with Chart.js
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        }
    }
}
</script>
@endpush
@endsection