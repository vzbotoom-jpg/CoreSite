{{-- resources/views/blog/index.blade.php --}}
@extends('layouts.blog')

@section('title', 'Blog - CoreSite')
@section('description', 'Artikel terbaru tentang teknologi, bisnis, dan tips untuk UMKM.')

@section('content')
<!-- Blog Header -->
<div class="mb-12">
    <h1 class="text-2xl md:text-3xl font-bold text-text-primary dark:text-text-dark-primary mb-3 tracking-tight leading-tight">
        What we're building, fixing, and learning.
    </h1>
    <p class="text-text-secondary dark:text-text-dark-secondary text-base leading-relaxed max-w-2xl">
        Security writeups, release context, model/runtime notes, and the occasional lobster-shaped aside.
    </p>
</div>

<!-- Blog Posts List -->
<div class="space-y-14">
    @forelse($posts ?? [] as $post)
    <article>
        <!-- Category Badge -->
        <div class="mb-2">
            <span class="text-xs font-medium text-accent uppercase tracking-wider">
                {{ $post->category->name ?? 'General' }}
            </span>
        </div>

        <!-- Title -->
        <h2 class="text-xl md:text-2xl font-bold text-text-primary dark:text-text-dark-primary mb-2 leading-tight tracking-tight">
            <a href="{{ route('blog.post', $post->slug) }}" class="hover:text-accent transition">
                {{ $post->title }}
            </a>
        </h2>

        <!-- Meta -->
        <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-text-secondary/60 mb-3">
            <span>{{ $post->user->name ?? 'Admin' }}</span>
            <span>•</span>
            <span>{{ $post->created_at->format('M d, Y') }}</span>
            <span>•</span>
            <span>{{ $post->read_time ?? 4 }} min read</span>
        </div>

        <!-- Excerpt -->
        <p class="text-text-secondary dark:text-text-dark-secondary leading-relaxed text-sm max-w-2xl">
            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 160) }}
        </p>

        <!-- Read More -->
        <div class="mt-3">
            <a href="{{ route('blog.post', $post->slug) }}" class="inline-flex items-center gap-1.5 text-sm font-medium text-accent hover:gap-2 transition-all">
                Read more
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
    </article>
    @empty
    <div class="text-center py-12">
        <svg class="w-12 h-12 mx-auto text-text-secondary/20 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        <p class="text-text-secondary">No articles found.</p>
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