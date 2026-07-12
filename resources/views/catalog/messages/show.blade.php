{{-- resources/views/catalog/messages/show.blade.php --}}
@extends('layouts.catalog')

@section('title', 'Detail Percakapan')

@section('content')
<div x-data="messageDetail()" x-init="init()" class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('catalog.messages.index') }}" class="text-text-secondary hover:text-accent transition-colors group">
            <svg class="w-6 h-6 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div class="flex-1">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold"
                         :class="conversation.avatar_color || 'bg-accent/10 text-accent'">
                        <span x-text="conversation.avatar"></span>
                    </div>
                    <span x-show="conversation.is_online" 
                          class="absolute bottom-0 right-0 w-3 h-3 bg-success rounded-full border-2 border-white dark:border-dark-bg"></span>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-text-primary dark:text-text-dark-primary" x-text="conversation.name"></h2>
                    <p class="text-sm text-text-secondary">
                        <span x-text="conversation.type === 'store' ? '🏪 Toko' : '👤 Pelanggan'"></span>
                        <span x-show="conversation.is_online" class="text-success ml-2">● Online</span>
                        <span x-show="!conversation.is_online" class="text-text-secondary ml-2">● Offline</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button @click="togglePin" class="p-2 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                <svg class="w-5 h-5" :class="conversation.pinned ? 'text-warning' : 'text-text-secondary'" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
            </button>
            <button @click="deleteConversation" class="p-2 rounded-lg hover:bg-error/10 transition">
                <svg class="w-5 h-5 text-text-secondary hover:text-error transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Conversation Info -->
    <div class="card mb-6 bg-accent/5 border border-accent/20">
        <div class="card-body py-3">
            <div class="flex flex-wrap items-center justify-between gap-4 text-sm">
                <div class="flex items-center gap-4">
                    <span class="text-text-secondary">Percakapan dimulai: <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="formatDate(conversation.start_time)"></span></span>
                    <span class="text-text-secondary">|</span>
                    <span class="text-text-secondary">Total pesan: <span class="font-medium text-text-primary dark:text-text-dark-primary" x-text="conversation.messages?.length || 0"></span></span>
                </div>
                <div x-show="conversation.unread" class="flex items-center gap-2">
                    <span class="w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                    <span class="text-accent font-medium">Ada pesan baru</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Container -->
    <div class="card">
        <div class="card-body p-0">
            <div class="flex flex-col h-[500px]">
                <!-- Messages List -->
                <div class="flex-1 overflow-y-auto p-4 space-y-4" id="messagesContainer" x-ref="messagesContainer">
                    <!-- Date Separator -->
                    <div x-show="messages.length > 0" class="flex items-center gap-4 my-4">
                        <div class="flex-1 h-px bg-light-border/40 dark:bg-dark-border/40"></div>
                        <span class="text-xs text-text-secondary">Hari Ini</span>
                        <div class="flex-1 h-px bg-light-border/40 dark:bg-dark-border/40"></div>
                    </div>

                    <template x-for="(message, index) in messages" :key="message.id">
                        <div class="flex" :class="message.sender === 'user' ? 'justify-end' : 'justify-start'">
                            <!-- Store Avatar (for incoming messages) -->
                            <div x-show="message.sender !== 'user'" class="flex-shrink-0 mr-3">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold"
                                     :class="conversation.avatar_color || 'bg-accent/10 text-accent'">
                                    <span x-text="conversation.avatar"></span>
                                </div>
                            </div>
                            
                            <div class="max-w-[80%] sm:max-w-[70%]">
                                <div class="rounded-2xl p-3"
                                     :class="message.sender === 'user' ? 'bg-accent text-white rounded-tr-none' : 'bg-light-surface dark:bg-dark-surface rounded-tl-none'">
                                    <p class="text-sm leading-relaxed" 
                                       :class="message.sender === 'user' ? 'text-white' : 'text-text-primary dark:text-text-dark-primary'"
                                       x-text="message.message"></p>
                                </div>
                                <p class="text-xs text-text-secondary mt-1 px-2" x-text="formatTime(message.time)"></p>
                            </div>
                            
                            <!-- User Avatar (for outgoing messages) -->
                            <div x-show="message.sender === 'user'" class="flex-shrink-0 ml-3">
                                <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center text-xs font-bold text-accent">
                                    <span>Y</span>
                                </div>
                            </div>
                        </div>
                    </template>

                    <!-- Typing Indicator -->
                    <div x-show="isTyping" class="flex justify-start">
                        <div class="flex-shrink-0 mr-3">
                            <div class="w-8 h-8 bg-accent/10 rounded-full flex items-center justify-center text-xs font-bold text-accent">
                                <span x-text="conversation.avatar"></span>
                            </div>
                        </div>
                        <div class="bg-light-surface dark:bg-dark-surface rounded-2xl rounded-tl-none p-3">
                            <div class="flex items-center gap-1">
                                <div class="w-2 h-2 bg-text-secondary/40 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                                <div class="w-2 h-2 bg-text-secondary/40 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                                <div class="w-2 h-2 bg-text-secondary/40 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Loading -->
                    <div x-show="loading" class="flex justify-center py-4">
                        <div class="spinner"></div>
                    </div>
                </div>

                <!-- Message Input -->
                <div class="border-t border-light-border/40 dark:border-dark-border/40 p-4">
                    <form @submit.prevent="sendMessage" class="flex items-end gap-3">
                        <div class="flex-1 relative">
                            <textarea x-model="newMessage" 
                                      @keydown.enter.prevent="sendMessage" 
                                      rows="2"
                                      placeholder="Ketik pesan..." 
                                      class="w-full px-4 py-2.5 bg-light-surface/50 dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-lg resize-none focus:ring-1 focus:ring-accent transition outline-none text-sm"
                                      style="min-height: 48px; max-height: 120px;"
                                      x-ref="messageInput"></textarea>
                            <div class="absolute bottom-2 right-3 flex items-center gap-1">
                                <button type="button" @click="attachFile" class="p-1 rounded-lg hover:bg-light-surface/50 dark:hover:bg-dark-surface/50 transition">
                                    <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <button type="submit" 
                                class="btn btn-primary h-12 w-12 flex items-center justify-center flex-shrink-0 rounded-full"
                                :disabled="!newMessage.trim()">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                        </button>
                    </form>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-xs text-text-secondary/60">Tekan Enter untuk mengirim</p>
                        <div class="flex items-center gap-3 text-xs text-text-secondary/60">
                            <button @click="emojiPicker" class="hover:text-text-primary transition">😊 Emoji</button>
                            <span>|</span>
                            <button @click="attachFile" class="hover:text-text-primary transition">📎 Lampiran</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Replies -->
    <div class="mt-4 flex flex-wrap gap-2">
        <span class="text-sm text-text-secondary mr-2">Balas cepat:</span>
        <button @click="quickReply('Terima kasih')" class="px-3 py-1 bg-light-surface/50 dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-full text-sm hover:border-accent/50 transition">
            Terima kasih
        </button>
        <button @click="quickReply('Baik, akan saya cek')" class="px-3 py-1 bg-light-surface/50 dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-full text-sm hover:border-accent/50 transition">
            Baik, akan saya cek
        </button>
        <button @click="quickReply('Saya setuju')" class="px-3 py-1 bg-light-surface/50 dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-full text-sm hover:border-accent/50 transition">
            Saya setuju
        </button>
        <button @click="quickReply('Mohon informasinya')" class="px-3 py-1 bg-light-surface/50 dark:bg-dark-surface/50 border border-light-border/40 dark:border-dark-border/40 rounded-full text-sm hover:border-accent/50 transition">
            Mohon informasinya
        </button>
    </div>
</div>

@push('scripts')
<script>
function messageDetail() {
    return {
        conversation: {
            id: 1,
            name: 'Toko CoreSite Official',
            avatar: 'C',
            avatar_color: 'bg-primary/10 text-primary',
            is_online: true,
            type: 'store',
            pinned: true,
            unread: true,
            start_time: '2026-06-20T09:00:00'
        },
        messages: [
            { id: 1, sender: 'store', message: 'Halo, ada yang bisa kami bantu?', time: '2026-06-20T09:00:00' },
            { id: 2, sender: 'user', message: 'Saya ingin tanya tentang status pesanan saya', time: '2026-06-20T09:15:00' },
            { id: 3, sender: 'store', message: 'Pesanan Anda telah dikirim. Silakan cek tracking.', time: '2026-06-20T10:30:00' }
        ],
        newMessage: '',
        isTyping: false,
        loading: false,
        
        init() {
            this.scrollToBottom();
            // Simulate typing indicator
            setInterval(() => {
                if (this.messages.length > 0 && this.messages[this.messages.length - 1].sender !== 'store') {
                    this.isTyping = true;
                    setTimeout(() => {
                        this.isTyping = false;
                        // Simulate auto-reply
                        if (this.messages.length > 0) {
                            setTimeout(() => {
                                this.messages.push({
                                    id: Date.now(),
                                    sender: 'store',
                                    message: 'Terima kasih telah menghubungi kami. Ada yang bisa kami bantu lagi?',
                                    time: new Date().toISOString()
                                });
                                this.scrollToBottom();
                            }, 1000);
                        }
                    }, 2000);
                }
            }, 30000);
        },
        
        sendMessage() {
            if (!this.newMessage.trim()) return;
            
            this.messages.push({
                id: Date.now(),
                sender: 'user',
                message: this.newMessage,
                time: new Date().toISOString()
            });
            
            this.newMessage = '';
            this.scrollToBottom();
            
            // Simulate reply
            this.isTyping = true;
            setTimeout(() => {
                this.isTyping = false;
                this.messages.push({
                    id: Date.now() + 1,
                    sender: 'store',
                    message: 'Baik, akan kami proses segera. Terima kasih.',
                    time: new Date().toISOString()
                });
                this.scrollToBottom();
            }, 2000);
        },
        
        scrollToBottom() {
            setTimeout(() => {
                const container = this.$refs.messagesContainer;
                if (container) {
                    container.scrollTop = container.scrollHeight;
                }
            }, 100);
        },
        
        quickReply(message) {
            this.newMessage = message;
            this.sendMessage();
        },
        
        togglePin() {
            this.conversation.pinned = !this.conversation.pinned;
            window.showToast(this.conversation.pinned ? 'Percakapan disematkan' : 'Percakapan tidak disematkan', 'info');
        },
        
        deleteConversation() {
            if (confirm('Hapus percakapan ini?')) {
                window.showToast('Percakapan dihapus', 'info');
                setTimeout(() => {
                    window.location.href = '/messages';
                }, 1000);
            }
        },
        
        attachFile() {
            window.showToast('Fitur lampiran akan segera tersedia', 'info');
        },
        
        emojiPicker() {
            window.showToast('Fitur emoji akan segera tersedia', 'info');
        },
        
        formatDate(date) {
            const d = new Date(date);
            return d.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        },
        
        formatTime(date) {
            const d = new Date(date);
            return d.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }
}
</script>

@push('styles')
<style>
#messagesContainer {
    scroll-behavior: smooth;
}
#messagesContainer::-webkit-scrollbar {
    width: 4px;
}
#messagesContainer::-webkit-scrollbar-track {
    background: transparent;
}
#messagesContainer::-webkit-scrollbar-thumb {
    background: var(--color-light-border);
    border-radius: 2px;
}
.dark #messagesContainer::-webkit-scrollbar-thumb {
    background: var(--color-dark-border);
}
</style>
@endpush
@endsection