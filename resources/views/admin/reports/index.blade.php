{{-- resources/views/admin/reports/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Laporan')
@section('page-title', 'Laporan')

@section('content')
<div x-data="reportManager()" x-init="init()" class="space-y-6">
    <!-- Tab Navigation -->
    <div class="flex flex-wrap gap-2 border-b border-light-border dark:border-dark-border">
        <button @click="activeTab = 'financial'" 
                :class="activeTab === 'financial' ? 'tab-active' : ''"
                class="tab">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Laporan Keuangan
        </button>
        <button @click="activeTab = 'sales'" 
                :class="activeTab === 'sales' ? 'tab-active' : ''"
                class="tab">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
            </svg>
            Laporan Penjualan
        </button>
        <button @click="activeTab = 'inventory'" 
                :class="activeTab === 'inventory' ? 'tab-active' : ''"
                class="tab">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            Laporan Inventori
        </button>
    </div>
    
    <!-- Tab Contents -->
    <div x-show="activeTab === 'financial'" x-cloak>
        @include('admin.reports.financial')
    </div>
    
    <div x-show="activeTab === 'sales'" x-cloak>
        @include('admin.reports.sales')
    </div>
    
    <div x-show="activeTab === 'inventory'" x-cloak>
        @include('admin.reports.inventory')
    </div>
</div>

@push('scripts')
<script>
function reportManager() {
    return {
        activeTab: 'financial',
        
        init() {
            // Get tab from URL hash if exists
            const hash = window.location.hash.substring(1);
            if (['financial', 'sales', 'inventory'].includes(hash)) {
                this.activeTab = hash;
            }
        }
    }
}
</script>
@endpush
@endsection