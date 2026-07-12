{{-- resources/views/catalog/partials/store-header.blade.php --}}
@props(['store'])

<div class="bg-gradient-to-r from-accent/10 to-transparent border-b">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-white dark:bg-dark-bg rounded-2xl shadow-lg flex items-center justify-center overflow-hidden">
                @if($store->logo)
                    <img src="{{ Storage::url($store->logo) }}" alt="{{ $store->name }}" class="w-full h-full object-cover">
                @else
                    <span class="text-3xl font-bold text-accent">{{ strtoupper(substr($store->name, 0, 2)) }}</span>
                @endif
            </div>
            <div class="text-center md:text-left">
                <h1 class="text-2xl font-bold mb-2">{{ $store->name }}</h1>
                <p class="text-text-secondary mb-3">{{ $store->description ?? 'Toko online resmi ' . $store->name }}</p>
                <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        <span>Terdaftar {{ $store->created_at->format('M Y') }}</span>
                    </span>
                    <a href="mailto:{{ $store->email }}" class="btn btn-ghost btn-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Hubungi Toko
                    </a>
                    @if($store->phone)
                        <a href="https://wa.me/{{ $store->phone }}" target="_blank" class="btn btn-ghost btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                            </svg>
                            WhatsApp
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>