{{-- resources/views/catalog/account/profile.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Profil Saya')

@section('content')
<div x-data="profileManager()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid md:grid-cols-4 gap-8">
        <div class="md:col-span-1">
            @include('catalog.account.partials.sidebar')
        </div>
        
        <div class="md:col-span-3">
            <div class="mb-6">
                <h1 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary">Profil Saya</h1>
                <p class="text-sm text-text-secondary dark:text-text-dark-secondary">Kelola informasi profil dan akun Anda</p>
            </div>
            
            <!-- Profile Picture -->
            <div class="card mb-6">
                <div class="card-body flex items-center gap-6">
                    <div class="relative">
                        <div class="w-24 h-24 bg-accent/10 rounded-full flex items-center justify-center">
                            <span class="text-4xl font-bold text-accent">B</span>
                        </div>
                        <button class="absolute bottom-0 right-0 w-8 h-8 bg-accent rounded-full flex items-center justify-center text-white hover:bg-accent-hover transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                            </svg>
                        </button>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-text-primary dark:text-text-dark-primary">Budi Santoso</h3>
                        <p class="text-text-secondary dark:text-text-dark-secondary">budi@example.com</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="badge badge-success text-xs">Akun Terverifikasi</span>
                            <span class="badge badge-secondary text-xs">Member sejak Jun 2026</span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="font-semibold text-text-primary dark:text-text-dark-primary">Informasi Pribadi</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="#" @submit.prevent="saveProfile">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nama Lengkap *</label>
                                <input type="text" x-model="profile.name" required class="input" placeholder="Nama lengkap">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Email *</label>
                                <input type="email" x-model="profile.email" required class="input" placeholder="email@example.com" readonly>
                                <p class="text-xs text-text-secondary mt-1">Email tidak dapat diubah</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Nomor Telepon</label>
                                <input type="tel" x-model="profile.phone" class="input" placeholder="08123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Jenis Kelamin</label>
                                <select x-model="profile.gender" class="input">
                                    <option value="">Pilih</option>
                                    <option value="male">Laki-laki</option>
                                    <option value="female">Perempuan</option>
                                </select>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Alamat Lengkap</label>
                                <textarea x-model="profile.address" rows="3" class="input" placeholder="Alamat lengkap Anda"></textarea>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-text-primary dark:text-text-dark-primary mb-2">Catatan (Opsional)</label>
                                <textarea x-model="profile.notes" rows="2" class="input" placeholder="Catatan tambahan untuk toko"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-light-border/40 dark:border-dark-border/40">
                            <button type="button" @click="resetForm" class="btn btn-secondary">Reset</button>
                            <button type="submit" class="btn btn-primary">
                                <span x-show="!loading">Simpan Perubahan</span>
                                <span x-show="loading" class="flex items-center gap-2">
                                    <div class="spinner w-4 h-4"></div>
                                    Menyimpan...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function profileManager() {
    return {
        profile: {
            name: 'Budi Santoso',
            email: 'budi@example.com',
            phone: '08123456789',
            gender: 'male',
            address: 'Jl. Contoh No. 123, RT 01 RW 02, Jakarta Selatan',
            notes: ''
        },
        loading: false,
        
        init() {
            // Load profile data
        },
        
        async saveProfile() {
            this.loading = true;
            // Simulate API call
            await new Promise(resolve => setTimeout(resolve, 1500));
            this.loading = false;
            window.showToast('Profil berhasil diperbarui!', 'success');
        },
        
        resetForm() {
            // Reset to original data
            this.profile = {
                name: 'Budi Santoso',
                email: 'budi@example.com',
                phone: '08123456789',
                gender: 'male',
                address: 'Jl. Contoh No. 123, RT 01 RW 02, Jakarta Selatan',
                notes: ''
            };
            window.showToast('Form direset', 'info');
        }
    }
}
</script>
@endpush
@endsection