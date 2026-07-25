{{-- resources/views/blog/index.blade.php --}}
@extends('layouts.blog')

@section('title', 'Jurnal & Edukasi Bisnis CoreSite')
@section('description', 'Temukan panduan praktis, strategi pemasaran, manajemen keuangan, serta pembaruan fitur terbaru untuk memajukan bisnis UMKM Anda.')

@section('content')
<!-- Blog Header -->
<div class="mb-12">
    <h1 class="text-2xl md:text-3xl font-extrabold text-text-primary dark:text-text-dark-primary mb-3 tracking-tight leading-tight">
        Jurnal & Edukasi Bisnis CoreSite
    </h1>
    <p class="text-text-secondary dark:text-text-dark-secondary text-base leading-relaxed max-w-2xl">
        Temukan panduan praktis, strategi pemasaran, manajemen keuangan, serta pembaruan fitur terbaru untuk memajukan bisnis UMKM Anda.
    </p>
</div>

<!-- Blog Posts List -->
<div class="space-y-14">
    @forelse($posts ?? [] as $post)
    <article class="p-2 hover:bg-light-surface/20 dark:hover:bg-dark-surface/10 rounded-xl transition">
        <!-- Category Badge -->
        <div class="mb-2">
            <span class="text-xs font-bold text-accent uppercase tracking-wider bg-accent/10 px-2 py-0.5 rounded">
                {{ $post->category->name ?? 'Edukasi UMKM' }}
            </span>
        </div>

        <!-- Title -->
        <h2 class="text-xl md:text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-2 leading-tight tracking-tight">
            <a href="{{ route('blog.post', $post->slug) }}" class="hover:text-accent transition">
                {{ $post->title }}
            </a>
        </h2>

        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-xs font-semibold text-text-secondary/60 mb-3 uppercase tracking-wider">
            <span>{{ $post->user->name ?? 'Tim Pakar CoreSite' }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('d/m/Y') }}</span>
            <span>•</span>
            <span>{{ $post->read_time ?? 4 }} menit baca</span>
        </div>

        <!-- Excerpt -->
        <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed text-sm max-w-2xl">
            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}
        </p>

        <!-- Read More -->
        <div class="mt-3">
            <a href="{{ route('blog.post', $post->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-accent hover:gap-2 transition-all">
                Baca selengkapnya
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </article>
    @empty
    <!-- Empty State -->
    <div class="text-center py-16 bg-white dark:bg-dark-surface border border-light-border dark:border-dark-border rounded-2xl p-8 max-w-xl mx-auto space-y-4 shadow-xs">
        <div class="w-14 h-14 bg-accent/10 text-accent rounded-full flex items-center justify-center mx-auto shadow-sm">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 4a2 2 0 11-4 0h4zm-4 4h4m-4 4h3m-5-10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        <div>
            <h4 class="text-sm font-bold text-text-primary dark:text-text-dark-primary">Belum ada artikel yang ditemukan</h4>
            <p class="text-xs text-text-secondary max-w-md mx-auto leading-relaxed mt-1">
                Coba gunakan kata kunci pencarian lain atau jelajahi kategori artikel kami. Anda juga bisa membaca panduan dasar kami.
            </p>
        </div>
        <div class="pt-2">
            <a href="{{ route('guides') }}" class="btn btn-primary text-xs font-bold py-2 px-5 rounded-xl shadow-md shadow-accent/10">
                Lihat Panduan Dasar CoreSite →
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if(isset($posts) && method_exists($posts, 'links'))
<div class="mt-14 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
    {{ $posts->links() }}
</div>
@endif
@endsection