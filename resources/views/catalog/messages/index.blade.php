{{-- resources/views/catalog/messages/index.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Pesan')

@section('content')
<div x-data="messageInbox()" x-init="init()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
                Pesan
            </h1>
            <p class="text-text-secondary dark:text-text-dark-secondary mt-1">
                Komunikasi dengan toko dan pelanggan
            </p>
        </div>
        <div class="flex items-center gap-3">
            <span class="text-sm text-text-secondary">
                <span x-text="unreadCount"></span> belum dibaca
            </span>
            <button @click="markAllAsRead" class="btn btn-secondary text-sm" x-show="unreadCount > 0">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Tandai Semua Dibaca
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="card hover:shadow-lg transition-all duration-300">
            <div class="card-body py-3 text-center">
                <p class="text-2xl font-bold text-text-primary dark:text-text-dark-primary" x-text="conversations.length"></p>
                <p class="text-xs text-text-secondary">Total Percakapan</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 border-accent/20">
            <div class="card-body py-3 text-center">
                <p class="text-2xl font-bold text-accent" x-text="unreadCount"></p>
                <p class="text-xs text-text-secondary">Belum Dibaca</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 border-success/20">
            <div class="card-body py-3 text-center">
                <p class="text-2xl font-bold text-success" x-text="readCount"></p>
                <p class="text-xs text-text-secondary">Sudah Dibaca</p>
            </div>
        </div>
        <div class="card hover:shadow-lg transition-all duration-300 border-primary/20">
            <div class="card-body py-3 text-center">
                <p class="text-2xl font-bold text-primary" x-text="activeConversations"></p>
                <p class="text-xs text-text-secondary">Aktif</p>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="card mb-6">
        <div class="card-body">
            <div class="flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-[200px]">
                    <div class="relative">
                        <input type="text" x-model="searchQuery" @input="filterConversations" 
                               placeholder="Cari percakapan..." class="input pl-10">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-text-secondary" 
                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                </div>
                <div class="flex flex-wrap gap-2">
                    <button @click="filter = 'all'" :class="filter === 'all' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        Semua
                    </button>
                    <button @click="filter = 'unread'" :class="filter === 'unread' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        ⭐ Belum Dibaca
                    </button>
                    <button @click="filter = 'read'" :class="filter === 'read' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        ✅ Sudah Dibaca
                    </button>
                    <button @click="filter = 'active'" :class="filter === 'active' ? 'btn-primary' : 'btn-outline'" class="text-sm px-4 py-2">
                        🟢 Aktif
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Conversations List -->
    <div class="space-y-3" x-show="filteredConversations.length > 0">
        <template x-for="conversation in filteredConversations" :key="conversation.id">
            <div class="card hover:shadow-xl transition-all duration-300 cursor-pointer group"
                 :class="conversation.unread ? 'border-accent/30 bg-accent/5' : ''"
                 @click="openConversation(conversation)">
                <div class="card-body p-4">
                    <div class="flex items-center gap-4">
                        <!-- Avatar -->
                        <div class="relative flex-shrink-0">
                            <div class="w-14 h-14 rounded-full flex items-center justify-center text-xl font-bold"
                                 :class="conversation.avatar_color || 'bg-accent/10 text-accent'">
                                <span x-text="conversation.avatar"></span>
                            </div>
                            <span x-show="conversation.is_online" 
                                  class="absolute bottom-0 right-0 w-3.5 h-3.5 bg-success rounded-full border-2 border-white dark:border-dark-bg"></span>
                        </div>
                        
                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-wrap items-start justify-between gap-2">
                                <div>
                                    <h4 class="font-semibold text-text-primary dark:text-text-dark-primary flex items-center gap-2">
                                        <span x-text="conversation.name"></span>
                                        <span x-show="conversation.is_online" class="text-xs text-success font-normal">● Online</span>
                                    </h4>
                                    <p class="text-sm text-text-secondary dark:text-text-dark-secondary truncate max-w-[200px] sm:max-w-[400px]"
                                       x-text="conversation.last_message"></p>
                                </div>
                                <div class="flex flex-col items-end gap-1 flex-shrink-0">
                                    <span class="text-xs text-text-secondary" x-text="formatTime(conversation.last_time)"></span>
                                    <span x-show="conversation.unread" 
                                          class="w-5 h-5 bg-accent rounded-full flex items-center justify-center text-white text-xs font-bold"
                                          x-text="conversation.unread_count"></span>
                                </div>
                            </div>
                            
                            <!-- Tags -->
                            <div class="flex flex-wrap items-center gap-2 mt-2">
                                <span class="text-xs px-2 py-0.5 rounded-full" 
                                      :class="conversation.type === 'store' ? 'bg-primary/10 text-primary' : 'bg-accent/10 text-accent'"
                                      x-text="conversation.type === 'store' ? '🏪 Toko' : '👤 Pelanggan'"></span>
                                <span x-show="conversation.last_message.includes('✓')" 
                                      class="text-xs text-success">✓ Dibalas</span>
                                <span x-show="conversation.pinned" 
                                      class="text-xs text-warning">📌 Disematkan</span>
                            </div>
                        </div>
                        
                        <!-- Action Buttons (on hover) -->
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition">
                            <button @click.stop="togglePin(conversation)" 
                                    class="p-1.5 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition"
                                    title="Sematkan">
                                <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </button>
                            <button @click.stop="deleteConversation(conversation)" 
                                    class="p-1.5 rounded-lg hover:bg-error/10 transition"
                                    title="Hapus">
                                <svg class="w-4 h-4 text-text-secondary hover:text-error transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="filteredConversations.length === 0" class="text-center py-16">
        <div class="w-32 h-32 mx-auto bg-accent/10 rounded-full flex items-center justify-center mb-6">
            <svg class="w-16 h-16 text-accent/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-3">
            Belum Ada Percakapan
        </h2>
        <p class="text-text-secondary dark:text-text-dark-secondary mb-8 max-w-md mx-auto">
            Mulai berkomunikasi dengan toko atau pelanggan melalui pesan.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ route('catalog.store') }}" class="btn btn-primary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                </svg>
                Mulai Belanja
            </a>
            <button @click="startNewConversation" class="btn btn-secondary">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Pesan Baru
            </button>
        </div>
    </div>

    <!-- Pagination -->
    <div x-show="filteredConversations.length > 0" class="mt-8 flex flex-wrap items-center justify-between gap-4">
        <p class="text-sm text-text-secondary">
            Menampilkan <span x-text="filteredConversations.length"></span> dari <span x-text="conversations.length"></span> percakapan
        </p>
        <div class="flex gap-2">
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition disabled:opacity-50 disabled:cursor-not-allowed">
                Sebelumnya
            </button>
            <button class="px-3 py-1 bg-accent text-white rounded-lg text-sm">1</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">2</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">3</button>
            <button class="px-3 py-1 border border-light-border/40 dark:border-dark-border/40 rounded-lg text-sm hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                Selanjutnya
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
function messageInbox() {
    return {
        conversations: [],
        searchQuery: '',
        filter: 'all',
        
        init() {
            this.loadConversations();
        },
        
        loadConversations() {
            // Sample data - replace with API call
            this.conversations = [
                {
                    id: 1,
                    name: 'Toko CoreSite Official',
                    avatar: 'C',
                    avatar_color: 'bg-primary/10 text-primary',
                    is_online: true,
                    type: 'store',
                    last_message: 'Pesanan Anda telah dikirim. Silakan cek tracking.',
                    last_time: '2026-06-20T10:30:00',
                    unread: true,
                    unread_count: 2,
                    pinned: true,
                    messages: [
                        { id: 1, sender: 'store', message: 'Halo, ada yang bisa kami bantu?', time: '2026-06-20T09:00:00' },
                        { id: 2, sender: 'user', message: 'Saya ingin tanya tentang status pesanan saya', time: '2026-06-20T09:15:00' },
                        { id: 3, sender: 'store', message: 'Pesanan Anda telah dikirim. Silakan cek tracking.', time: '2026-06-20T10:30:00' }
                    ]
                },
                {
                    id: 2,
                    name: 'Toko Kopi Sejahtera',
                    avatar: 'K',
                    avatar_color: 'bg-success/10 text-success',
                    is_online: false,
                    type: 'store',
                    last_message: 'Terima kasih sudah berbelanja!',
                    last_time: '2026-06-19T14:20:00',
                    unread: false,
                    unread_count: 0,
                    pinned: false,
                    messages: [
                        { id: 1, sender: 'user', message: 'Apakah kopi arabika masih tersedia?', time: '2026-06-19T13:00:00' },
                        { id: 2, sender: 'store', message: 'Masih tersedia, silakan pesan di toko kami', time: '2026-06-19T14:00:00' },
                        { id: 3, sender: 'user', message: 'Baik, saya akan pesan sekarang', time: '2026-06-19T14:10:00' },
                        { id: 4, sender: 'store', message: 'Terima kasih sudah berbelanja!', time: '2026-06-19T14:20:00' }
                    ]
                },
                {
                    id: 3,
                    name: 'Pelanggan - Andi',
                    avatar: 'A',
                    avatar_color: 'bg-warning/10 text-warning',
                    is_online: true,
                    type: 'customer',
                    last_message: 'Saya tertarik dengan produknya, apakah bisa diskon?',
                    last_time: '2026-06-19T08:45:00',
                    unread: true,
                    unread_count: 1,
                    pinned: false,
                    messages: [
                        { id: 1, sender: 'customer', message: 'Halo, saya tertarik dengan produk Anda', time: '2026-06-19T08:30:00' },
                        { id: 2, sender: 'user', message: 'Silakan, produk mana yang Anda minati?', time: '2026-06-19T08:40:00' },
                        { id: 3, sender: 'customer', message: 'Saya tertarik dengan produknya, apakah bisa diskon?', time: '2026-06-19T08:45:00' }
                    ]
                },
                {
                    id: 4,
                    name: 'Toko Fashion Modern',
                    avatar: 'F',
                    avatar_color: 'bg-info/10 text-info',
                    is_online: false,
                    type: 'store',
                    last_message: 'Kami akan kirim hari ini',
                    last_time: '2026-06-18T16:00:00',
                    unread: false,
                    unread_count: 0,
                    pinned: false,
                    messages: [
                        { id: 1, sender: 'user', message: 'Kapan pesanan saya dikirim?', time: '2026-06-18T15:30:00' },
                        { id: 2, sender: 'store', message: 'Kami akan kirim hari ini', time: '2026-06-18T16:00:00' }
                    ]
                }
            ];
        },
        
        get filteredConversations() {
            let filtered = this.conversations;
            
            // Filter by search
            if (this.searchQuery) {
                const query = this.searchQuery.toLowerCase();
                filtered = filtered.filter(c => 
                    c.name.toLowerCase().includes(query) ||
                    c.last_message.toLowerCase().includes(query)
                );
            }
            
            // Filter by status
            if (this.filter === 'unread') {
                filtered = filtered.filter(c => c.unread);
            } else if (this.filter === 'read') {
                filtered = filtered.filter(c => !c.unread);
            } else if (this.filter === 'active') {
                filtered = filtered.filter(c => c.is_online);
            }
            
            // Sort: pinned first, then by last_time
            filtered.sort((a, b) => {
                if (a.pinned && !b.pinned) return -1;
                if (!a.pinned && b.pinned) return 1;
                return new Date(b.last_time) - new Date(a.last_time);
            });
            
            return filtered;
        },
        
        get unreadCount() {
            return this.conversations.filter(c => c.unread).length;
        },
        
        get readCount() {
            return this.conversations.filter(c => !c.unread).length;
        },
        
        get activeConversations() {
            return this.conversations.filter(c => c.is_online).length;
        },
        
        filterConversations() {
            // Triggered by search input
        },
        
        openConversation(conversation) {
            // Mark as read
            if (conversation.unread) {
                conversation.unread = false;
                conversation.unread_count = 0;
            }
            // Navigate to conversation detail
            window.location.href = `/messages/${conversation.id}`;
        },
        
        markAllAsRead() {
            this.conversations.forEach(c => {
                c.unread = false;
                c.unread_count = 0;
            });
            window.showToast('Semua pesan ditandai dibaca', 'success');
        },
        
        togglePin(conversation) {
            conversation.pinned = !conversation.pinned;
            window.showToast(conversation.pinned ? 'Percakapan disematkan' : 'Percakapan tidak disematkan', 'info');
        },
        
        deleteConversation(conversation) {
            if (confirm(`Hapus percakapan dengan "${conversation.name}"?`)) {
                this.conversations = this.conversations.filter(c => c.id !== conversation.id);
                window.showToast('Percakapan dihapus', 'info');
            }
        },
        
        startNewConversation() {
            window.showToast('Fitur pesan baru akan segera tersedia', 'info');
        },
        
        formatTime(date) {
            const now = new Date();
            const msgDate = new Date(date);
            const diff = (now - msgDate) / 1000 / 60 / 60; // hours
            
            if (diff < 1) {
                return 'Baru saja';
            } else if (diff < 24) {
                return msgDate.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
            } else if (diff < 48) {
                return 'Kemarin';
            } else {
                return msgDate.toLocaleDateString('id-ID', { day: '2-digit', month: 'short' });
            }
        }
    }
}
</script>
@endpush
@endsection