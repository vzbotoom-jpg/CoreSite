{{-- resources/views/developer/stores/index.blade.php --}}
@extends('layouts.developer')

@section('title', 'Store Management')
@section('page-title', 'Store Management')

@section('content')
<div x-data="storeManagement()" x-init="init()" class="space-y-6">
    <!-- Header -->
    <div class="flex flex-wrap justify-between items-center gap-4">
        <div>
            <p class="text-text-secondary dark:text-text-dark-secondary">Kelola semua toko di sistem CoreSite</p>
        </div>
        <button @click="openCreateModal" class="btn btn-primary">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Toko
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Toko</p>
                        <p class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="stats.total"></p>
                    </div>
                    <div class="w-10 h-10 bg-primary/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Aktif</p>
                        <p class="text-xl font-bold text-success" x-text="stats.active"></p>
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
                        <p class="text-xs text-text-secondary">Nonaktif</p>
                        <p class="text-xl font-bold text-error" x-text="stats.inactive"></p>
                    </div>
                    <div class="w-10 h-10 bg-error/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-error" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body py-3">
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-xs text-text-secondary">Total Users</p>
                        <p class="text-xl font-bold text-accent" x-text="stats.users"></p>
                    </div>
                    <div class="w-10 h-10 bg-accent/10 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card">
        <div class="card-body">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" x-model="filters.search" @input="debounceSearch" 
                           placeholder="Cari toko..." class="input">
                </div>
                <div>
                    <select x-model="filters.status" @change="loadStores" class="input">
                        <option value="">Semua Status</option>
                        <option value="active">Aktif</option>
                        <option value="inactive">Nonaktif</option>
                    </select>
                </div>
                <div>
                    <select x-model="filters.sort" @change="loadStores" class="input">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="name">Nama A-Z</option>
                        <option value="users">User Terbanyak</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Stores Grid -->
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <template x-for="store in (stores || [])" :key="store?.id">
            <div class="card hover:shadow-lg transition group">
                <div class="card-body">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 bg-accent/10 rounded-xl flex items-center justify-center">
                                <span class="text-xl font-bold text-accent" x-text="getInitials(store.name)"></span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary" x-text="store.name"></h3>
                                <p class="text-xs text-text-secondary dark:text-text-dark-secondary" x-text="store.slug"></p>
                            </div>
                        </div>
                        <span :class="store.is_active ? 'badge-success' : 'badge-error'" class="badge">
                            <span x-text="store.is_active ? 'Aktif' : 'Nonaktif'"></span>
                        </span>
                    </div>

                    <div class="space-y-2 text-sm mb-4">
                        <div class="flex items-center gap-2 text-text-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="store.email"></span>
                        </div>
                        <div class="flex items-center gap-2 text-text-secondary" x-show="store.phone">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                            </svg>
                            <span x-text="store.phone"></span>
                        </div>
                        <div class="flex items-center gap-2 text-text-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            <span x-text="store.users_count + ' user(s)'"></span>
                        </div>
                        <div class="flex items-center gap-2 text-text-secondary">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span x-text="formatDate(store.created_at)"></span>
                        </div>
                    </div>

                    <div class="pt-3 border-t border-light-border dark:border-dark-border flex justify-between items-center">
                        <div class="flex gap-2">
                            <a :href="`/developer/stores/${store.id}`" class="text-info hover:text-info/80 transition text-sm" title="Detail">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a :href="`/developer/stores/${store.id}/edit`" class="text-info hover:text-info/80 transition text-sm" title="Edit">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <button @click="toggleStoreStatus(store)" class="text-warning hover:text-warning/80 transition text-sm" title="Toggle Status">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
                                </svg>
                            </button>
                            <button @click="deleteStore(store)" class="text-error hover:text-error/80 transition text-sm" title="Hapus">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                        <span class="text-xs text-text-secondary">
                            🏪 <span x-text="store.products_count || 0"></span> produk
                        </span>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="stores.length === 0 && !loading" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <p class="text-text-secondary dark:text-text-dark-secondary">Belum ada toko</p>
        <button @click="openCreateModal" class="btn btn-ghost btn-sm">
            Tambah toko pertama →
        </button>
    </div>

    <!-- Loading State -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data...</p>
    </div>

    <!-- Create/Edit Store Modal -->
    <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50" @click.away="closeModal">
        <div class="card w-full max-w-2xl mx-4 max-h-[90vh] overflow-y-auto" @click.stop>
            <div class="card-header flex justify-between items-center">
                <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="modalTitle"></h3>
                <button @click="closeModal" class="text-text-secondary hover:text-text-primary">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="card-body">
                <form @submit.prevent="saveStore">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Toko *</label>
                            <input type="text" x-model="form.name" required class="input" placeholder="Nama toko">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Slug *</label>
                            <input type="text" x-model="form.slug" required class="input" placeholder="slug-toko" :readonly="form.id">
                            <p class="text-xs text-text-secondary mt-1">URL unik untuk toko: coresite.com/[slug]</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                            <input type="email" x-model="form.email" required class="input" placeholder="email@example.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Telepon</label>
                            <input type="tel" x-model="form.phone" class="input" placeholder="08123456789">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat</label>
                            <textarea x-model="form.address" rows="2" class="input" placeholder="Alamat lengkap toko"></textarea>
                        </div>
                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" x-model="form.is_active" class="w-4 h-4 rounded border-gray-300 text-accent">
                                <span class="text-sm text-text-primary dark:text-text-dark-primary">Toko Aktif</span>
                            </label>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border dark:border-dark-border">
                        <button type="button" @click="closeModal" class="btn btn-secondary">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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
                        Toko <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="deleteData?.name || '-'"></span> akan dihapus permanen.
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
function storeManagement() {
    return {
        stores: [],
        loading: false,
        stats: {
            total: 0,
            active: 0,
            inactive: 0,
            users: 0
        },
        filters: {
            search: '',
            status: '',
            sort: 'newest'
        },
        searchTimeout: null,
        showModal: false,
        showDeleteModal: false,
        modalTitle: '',
        deleteData: null,
        form: {
            id: null,
            name: '',
            slug: '',
            email: '',
            phone: '',
            address: '',
            is_active: true
        },

        init() {
            this.loadStores();
        },

        async loadStores() {
            this.loading = true;
            const params = new URLSearchParams({
                search: this.filters.search,
                status: this.filters.status,
                sort: this.filters.sort
            });

            try {
                const response = await axios.get(`/api/developer/stores?${params}`);
                if (response.data.success) {
                    this.stores = response.data.data;
                    this.stats = response.data.stats || this.stats;
                }
            } catch (error) {
                console.error('Failed to load stores:', error);
                window.showToast('Gagal memuat toko', 'error');
            }
            this.loading = false;
        },

        debounceSearch() {
            clearTimeout(this.searchTimeout);
            this.searchTimeout = setTimeout(() => {
                this.loadStores();
            }, 300);
        },

        openCreateModal() {
            this.modalTitle = 'Tambah Toko Baru';
            this.form = {
                id: null,
                name: '',
                slug: '',
                email: '',
                phone: '',
                address: '',
                is_active: true
            };
            this.showModal = true;
        },

        openEditModal(store) {
            this.modalTitle = 'Edit Toko';
            this.form = {
                id: store.id,
                name: store.name,
                slug: store.slug,
                email: store.email,
                phone: store.phone || '',
                address: store.address || '',
                is_active: store.is_active
            };
            this.showModal = true;
        },

        closeModal() {
            this.showModal = false;
        },

        async saveStore() {
            try {
                const url = this.form.id ? `/api/developer/stores/${this.form.id}` : '/api/developer/stores';
                const method = this.form.id ? 'PUT' : 'POST';
                
                const response = await axios({
                    method: method,
                    url: url,
                    data: this.form
                });

                if (response.data.success) {
                    this.closeModal();
                    this.loadStores();
                    window.showToast(this.form.id ? 'Toko berhasil diupdate' : 'Toko berhasil ditambahkan', 'success');
                }
            } catch (error) {
                window.showToast(error.response?.data?.message || 'Gagal menyimpan toko', 'error');
            }
        },

        async toggleStoreStatus(store) {
            const action = store.is_active ? 'nonaktifkan' : 'aktifkan';
            if (!confirm(`Yakin ingin ${action} toko "${store.name}"?`)) return;

            try {
                const response = await axios.post(`/api/developer/stores/${store.id}/toggle-status`);
                if (response.data.success) {
                    this.loadStores();
                    window.showToast(`Toko berhasil ${action}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengubah status toko', 'error');
            }
        },

        deleteStore(store) {
            this.deleteData = store;
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            if (!this.deleteData) return;

            try {
                const response = await axios.delete(`/api/developer/stores/${this.deleteData.id}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    this.deleteData = null;
                    this.loadStores();
                    window.showToast('Toko berhasil dihapus', 'success');
                }
            } catch (error) {
                window.showToast('Gagal menghapus toko', 'error');
            }
        },

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },

        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }
    }
}
</script>
@endpush
@endsection