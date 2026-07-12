{{-- resources/views/developer/logs/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'View Log')
@section('page-title', 'View Log')

@section('content')
<div x-data="logViewer()" x-init="init()" class="max-w-full">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
        <div class="flex items-center gap-4">
            <a href="{{ route('developer.logs.index') }}" class="text-text-secondary hover:text-accent transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="fileName"></h1>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary" x-text="`${totalLines} lines`"></p>
            </div>
        </div>
        <div class="flex gap-3 flex-wrap">
            <div class="flex gap-2">
                <button @click="loadContent('first')" class="btn btn-outline text-sm">First</button>
                <button @click="loadContent('prev')" class="btn btn-outline text-sm">Prev</button>
                <span class="px-3 py-1 text-text-secondary text-sm">
                    <span x-text="currentPage"></span> / <span x-text="lastPage"></span>
                </span>
                <button @click="loadContent('next')" class="btn btn-outline text-sm">Next</button>
                <button @click="loadContent('last')" class="btn btn-outline text-sm">Last</button>
            </div>
            <div class="flex gap-2">
                <a :href="`/developer/logs/download/${fileName}`" class="btn btn-success text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Download
                </a>
                <button @click="deleteLog" class="btn btn-danger text-sm">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    Delete
                </a>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" x-model="search" @input="debounceSearch" 
                           placeholder="Search in log..." class="input">
                </div>
                <div class="flex gap-2">
                    <select x-model="level" @change="loadContent('current')" class="input">
                        <option value="">All Levels</option>
                        <option value="ERROR">ERROR</option>
                        <option value="WARNING">WARNING</option>
                        <option value="INFO">INFO</option>
                        <option value="DEBUG">DEBUG</option>
                        <option value="NOTICE">NOTICE</option>
                    </select>
                    <button @click="clearFilters" class="btn btn-secondary text-sm">Clear</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Log Content -->
    <div class="card">
        <div class="card-body p-0">
            <div x-show="loading" class="text-center py-12">
                <div class="spinner mx-auto"></div>
                <p class="text-text-secondary mt-4">Loading log content...</p>
            </div>
            <div x-show="!loading && lines.length > 0" class="overflow-x-auto">
                <pre class="text-sm font-mono p-4 space-y-0.5" style="max-height: 70vh; overflow-y: auto;">
                    <template x-for="(line, index) in lines" :key="index">
                        <div :class="getLineClass(line)" class="py-0.5 px-2 hover:bg-light-surface/50 transition">
                            <span class="text-text-secondary text-xs select-none mr-4" x-text="(currentPage - 1) * perPage + index + 1"></span>
                            <span x-text="line"></span>
                        </div>
                    </template>
                </pre>
            </div>
            <div x-show="!loading && lines.length === 0" class="text-center py-12">
                <svg class="w-12 h-12 mx-auto mb-3 text-text-secondary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <p class="text-text-secondary">Tidak ada data untuk ditampilkan</p>
                <p class="text-xs text-text-secondary mt-1" x-show="search">Coba ubah kata kunci pencarian</p>
            </div>
        </div>
        <div class="card-footer flex justify-between items-center" x-show="!loading && lines.length > 0">
            <div class="text-sm text-text-secondary dark:text-text-dark-secondary">
                Showing <span x-text="(currentPage - 1) * perPage + 1"></span> - 
                <span x-text="Math.min(currentPage * perPage, totalLines)"></span> of 
                <span x-text="totalLines"></span> lines
            </div>
            <div class="flex gap-2">
                <button @click="loadContent('first')" :disabled="currentPage === 1" 
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 transition">
                    First
                </button>
                <button @click="loadContent('prev')" :disabled="currentPage === 1" 
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 transition">
                    Prev
                </button>
                <span class="px-3 py-1 text-text-secondary text-sm">
                    <span x-text="currentPage"></span> / <span x-text="lastPage"></span>
                </span>
                <button @click="loadContent('next')" :disabled="currentPage === lastPage" 
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 transition">
                    Next
                </button>
                <button @click="loadContent('last')" :disabled="currentPage === lastPage" 
                        class="px-3 py-1 border rounded hover:bg-light-surface disabled:opacity-50 transition">
                    Last
                </button>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation -->
    <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
        <div class="card w-full max-w-md mx-4" @click.stop>
            <div class="card-header">
                <h3 class="text-xl font-bold text-error">Konfirmasi Hapus</h3>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="w-16 h-16 bg-error/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-text-primary dark:text-text-dark-primary mb-2">Yakin ingin menghapus?</h4>
                    <p class="text-text-secondary dark:text-text-dark-secondary mb-6">
                        Log file <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="fileName"></span> akan dihapus permanen.
                    </p>
                    <div class="flex justify-center gap-3">
                        <button @click="showDeleteModal = false" class="btn btn-secondary">Batal</button>
                        <button @click="confirmDelete" class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function logViewer() {
    return {
        fileName: '{{ $file ?? '' }}',
        lines: [],
        totalLines: 0,
        currentPage: 1,
        lastPage: 1,
        perPage: 100,
        loading: false,
        search: '',
        level: '',
        showDeleteModal: false,
        searchTimeout: null,

        init() {
            this.loadContent('first');
        },

        async loadContent(direction) {
            if (direction === 'first') this.currentPage = 1;
            else if (direction === 'prev' && this.currentPage > 1) this.currentPage--;
            else if (direction === 'next' && this.currentPage < this.lastPage) this.currentPage++;
            else if (direction === 'last') this.currentPage = this.lastPage;
            else if (direction === 'current') {
                // Keep current page
            }

            this.loading = true;
            const params = new URLSearchParams({
                page: this.currentPage,
                per_page: this.perPage,
                search: this.search,
                level: this.level
            });

            try {
                const response = await axios.get(`/api/developer/logs/${this.fileName}?${params}`);
                if (response.data.success) {
                    this.lines = response.data.data;
                    this.totalLines = response.data.total || 0;
                    this.currentPage = response.data.current_page || 1;
                    this.lastPage = response.data.last_page || 1;
                }
            } catch (error) {
                console.error('Failed to load log content:', error);
                window.showToast('Gagal memuat konten log', 'error');
            }
            this.loading = false;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.currentPage = 1;
                this.loadContent('current');
            }, 500);
        },

        clearFilters() {
            this.search = '';
            this.level = '';
            this.currentPage = 1;
            this.loadContent('current');
        },

        getLineClass(line) {
            const lower = line.toLowerCase();
            if (lower.includes('error')) return 'text-error';
            if (lower.includes('warning') || lower.includes('warn')) return 'text-warning';
            if (lower.includes('info')) return 'text-info';
            if (lower.includes('debug')) return 'text-text-secondary';
            return 'text-text-primary';
        },

        deleteLog() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/logs/${this.fileName}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('Log berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.logs.index") }}';
                    }, 1500);
                }
            } catch (error) {
                window.showToast('Gagal menghapus log', 'error');
            }
        },

        formatDate(timestamp) {
            if (!timestamp) return '-';
            const date = new Date(timestamp);
            return date.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection