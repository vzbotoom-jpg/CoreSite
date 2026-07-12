{{-- resources/views/developer/stores/show.blade.php --}}
@extends('layouts.developer')

@section('title', 'Detail Toko')
@section('page-title', 'Detail Toko')

@section('content')
<div x-data="storeDetail()" x-init="init()" class="max-w-4xl mx-auto">
    <!-- Loading -->
    <div x-show="loading" class="text-center py-12">
        <div class="spinner mx-auto"></div>
        <p class="text-text-secondary mt-4">Memuat data toko...</p>
    </div>

    <!-- Store Detail -->
    <div x-show="!loading && store" x-cloak>
        <!-- Header -->
        <div class="flex flex-wrap justify-between items-center gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('developer.stores.index') }}" class="text-text-secondary hover:text-accent transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                </a>
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="store.name"></h1>
                <span :class="store.is_active ? 'badge-success' : 'badge-error'" class="badge">
                    <span x-text="store.is_active ? 'Aktif' : 'Nonaktif'"></span>
                </span>
            </div>
            <div class="flex gap-3">
                <button @click="toggleStatus" class="btn btn-secondary text-sm">
                    <span x-text="store.is_active ? 'Nonaktifkan' : 'Aktifkan'"></span>
                </button>
                <a :href="`/developer/stores/${store.id}/edit`" class="btn btn-primary text-sm">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit Toko
                </a>
            </div>
        </div>

        <!-- Store Info -->
        <div class="grid md:grid-cols-3 gap-6">
            <!-- Profile Card -->
            <div class="card md:col-span-1">
                <div class="card-body text-center">
                    <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-4xl font-bold text-accent" x-text="getInitials(store.name)"></span>
                    </div>
                    <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="store.name"></h3>
                    <p class="text-text-secondary dark:text-text-dark-secondary" x-text="store.slug"></p>
                    <div class="mt-3 flex justify-center gap-2">
                        <span :class="store.is_active ? 'badge-success' : 'badge-error'" class="badge">
                            <span x-text="store.is_active ? 'Aktif' : 'Nonaktif'"></span>
                        </span>
                    </div>
                    <div class="mt-4 pt-4 border-t border-light-border dark:border-dark-border">
                        <p class="text-sm text-text-secondary">Dibuat</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(store.created_at)"></p>
                    </div>
                    <div class="mt-2 pt-2 border-t border-light-border dark:border-dark-border">
                        <p class="text-sm text-text-secondary">Terakhir Update</p>
                        <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(store.updated_at)"></p>
                    </div>
                    <div class="mt-2 pt-2 border-t border-light-border dark:border-dark-border">
                        <a :href="`/${store.slug}`" target="_blank" class="btn btn-ghost btn-sm">
                            🔗 coresite.com/<span x-text="store.slug"></span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="card md:col-span-2">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Toko</h3>
                </div>
                <div class="card-body space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-sm text-text-secondary">Nama Toko</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.name"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Slug</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.slug"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Email</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.email"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Telepon</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.phone || '-'"></p>
                        </div>
                        <div class="md:col-span-2">
                            <label class="text-sm text-text-secondary">Alamat</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.address || '-'"></p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Status</label>
                            <p>
                                <span :class="store.is_active ? 'text-success' : 'text-error'" class="font-medium">
                                    <span x-text="store.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </p>
                        </div>
                        <div>
                            <label class="text-sm text-text-secondary">Total Users</label>
                            <p class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store.users_count || 0"></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Users & Products -->
        <div class="grid md:grid-cols-2 gap-6 mt-6">
            <!-- Users -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Users</h3>
                    <span class="text-xs text-text-secondary" x-text="store.users_count + ' user(s)'"></span>
                </div>
                <div class="card-body">
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        <template x-for="user in store.users" :key="user.id">
                            <div class="flex items-center justify-between py-2 border-b border-light-border dark:border-dark-border last:border-0">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center">
                                        <span class="text-accent font-semibold text-xs" x-text="getInitials(user.name)"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="user.name"></p>
                                        <p class="text-xs text-text-secondary" x-text="user.email"></p>
                                    </div>
                                </div>
                                <span :class="user.is_active ? 'badge-success' : 'badge-error'" class="badge text-xs">
                                    <span x-text="user.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                </span>
                            </div>
                        </template>
                        <div x-show="!store.users || store.users.length === 0" class="text-center text-text-secondary py-4">
                            Belum ada user
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-light-border dark:border-dark-border">
                        <a :href="`/developer/users?store=${store.id}`" class="btn btn-ghost btn-sm">
                            Lihat semua user →
                        </a>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="card">
                <div class="card-header flex justify-between items-center">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Produk</h3>
                    <span class="text-xs text-text-secondary" x-text="store.products_count + ' produk(s)'"></span>
                </div>
                <div class="card-body">
                    <div class="space-y-3 max-h-60 overflow-y-auto">
                        <template x-for="product in store.products" :key="product.id">
                            <div class="flex items-center justify-between py-2 border-b border-light-border dark:border-dark-border last:border-0">
                                <div>
                                    <p class="text-sm font-medium text-text-primary dark:text-text-dark-primary" x-text="product.name"></p>
                                    <p class="text-xs text-text-secondary" x-text="'Rp ' + formatNumber(product.price)"></p>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-text-secondary" x-text="product.stock + ' stok'"></span>
                                    <span :class="product.is_active ? 'badge-success' : 'badge-error'" class="badge text-xs">
                                        <span x-text="product.is_active ? 'Aktif' : 'Nonaktif'"></span>
                                    </span>
                                </div>
                            </div>
                        </template>
                        <div x-show="!store.products || store.products.length === 0" class="text-center text-text-secondary py-4">
                            Belum ada produk
                        </div>
                    </div>
                    <div class="mt-3 pt-3 border-t border-light-border dark:border-dark-border">
                        <a :href="`/admin/products?store=${store.id}`" class="btn btn-ghost btn-sm">
                            Lihat semua produk →
                        </a>
                    </div>
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
                            Toko <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="store?.name"></span> akan dihapus permanen.
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

    <!-- Not Found -->
    <div x-show="!loading && !store" class="text-center py-12">
        <svg class="w-16 h-16 mx-auto text-text-secondary/50 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
        </svg>
        <p class="text-text-secondary">Toko tidak ditemukan</p>
        <a href="{{ route('developer.stores.index') }}" class="btn btn-ghost btn-sm">Kembali ke daftar toko</a>
    </div>
</div>

@push('scripts')
<script>
function storeDetail() {
    return {
        store: null,
        loading: true,
        showDeleteModal: false,
        storeId: {{ $id ?? 0 }},

        init() {
            this.loadStore();
        },

        async loadStore() {
            this.loading = true;
            try {
                const response = await axios.get(`/api/developer/stores/${this.storeId}`);
                if (response.data.success) {
                    this.store = response.data.data;
                }
            } catch (error) {
                console.error('Failed to load store:', error);
                window.showToast('Gagal memuat data toko', 'error');
            }
            this.loading = false;
        },

        async toggleStatus() {
            const action = this.store.is_active ? 'nonaktifkan' : 'aktifkan';
            if (!confirm(`Yakin ingin ${action} toko "${this.store.name}"?`)) return;

            try {
                const response = await axios.post(`/api/developer/stores/${this.storeId}/toggle-status`);
                if (response.data.success) {
                    this.store.is_active = !this.store.is_active;
                    window.showToast(`Toko berhasil ${action}`, 'success');
                }
            } catch (error) {
                window.showToast('Gagal mengubah status toko', 'error');
            }
        },

        deleteStore() {
            this.showDeleteModal = true;
        },

        async confirmDelete() {
            try {
                const response = await axios.delete(`/api/developer/stores/${this.storeId}`);
                if (response.data.success) {
                    this.showDeleteModal = false;
                    window.showToast('Toko berhasil dihapus', 'success');
                    setTimeout(() => {
                        window.location.href = '{{ route("developer.stores.index") }}';
                    }, 1500);
                }
            } catch (error) {
                window.showToast('Gagal menghapus toko', 'error');
            }
        },

        getInitials(name) {
            if (!name) return '?';
            return name.split(' ').map(n => n[0]).join('').toUpperCase().substring(0, 2);
        },

        formatNumber(value) {
            return new Intl.NumberFormat('id-ID').format(value);
        },

        formatDate(date) {
            if (!date) return '-';
            return new Date(date).toLocaleDateString('id-ID', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>
@endpush
@endsection