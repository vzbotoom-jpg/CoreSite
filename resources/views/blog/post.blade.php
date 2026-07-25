{{-- resources/views/blog/post.blade.php --}}
@extends('layouts.blog')

@section('title', $post->title ?? 'Edukasi UMKM - CoreSite')
@section('description', $post->excerpt ?? '')

@section('content')
<article class="max-w-none">
    <!-- Category -->
    <div class="mb-4">
        <span class="text-xs font-bold text-accent uppercase tracking-wider bg-accent/10 px-2.5 py-0.5 rounded">
            {{ $post->category->name ?? 'Edukasi UMKM' }}
        </span>
    </div>

    <!-- Title -->
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-text-primary dark:text-text-dark-primary mb-6 leading-tight tracking-tight">
        {{ $post->title }}
    </h1>

    <!-- Meta -->
    <div class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm text-text-secondary/70 mb-10 pb-8 border-b border-light-border/40 dark:border-dark-border/40">
        <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-accent/10 rounded-full flex items-center justify-center">
                <span class="text-accent font-bold text-sm">
                    {{ strtoupper(substr($post->user->name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div>
                <span class="font-bold text-text-primary dark:text-text-dark-primary block leading-none">
                    {{ $post->user->name ?? 'Tim Pakar CoreSite' }}
                </span>
                <span class="text-[10px] bg-accent/10 text-accent font-bold px-1.5 py-0.5 rounded inline-block mt-1 uppercase tracking-wider">Tim Pakar UMKM CoreSite</span>
            </div>
        </div>
        <span class="text-text-secondary/30">•</span>
        <span class="flex items-center gap-1.5 text-xs font-semibold">
            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            {{ $post->created_at->format('d/m/Y') }}
        </span>
        <span class="flex items-center gap-1.5 text-xs font-semibold">
            <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
            </svg>
            {{ $post->read_time ?? 4 }} menit baca
        </span>
    </div>

    <!-- Featured Image -->
    @if($post->featured_image)
    <div class="mb-10 rounded-xl overflow-hidden max-h-[400px]">
        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover">
    </div>
    @endif

    <!-- Content -->
    <div class="prose prose-base dark:prose-invert max-w-none prose-headings:font-bold prose-headings:text-text-primary dark:prose-headings:text-text-dark-primary prose-p:text-text-secondary dark:prose-p:text-text-dark-secondary prose-a:text-accent prose-a:no-underline hover:prose-a:underline prose-blockquote:border-l-accent prose-blockquote:text-text-secondary dark:prose-blockquote:text-text-dark-secondary leading-relaxed">
        {!! $post->content ?? '<p class=\"italic\">Konten artikel sedang dalam proses penulisan oleh Tim Ahli CoreSite.</p>' !!}
    </div>

    <!-- Tags -->
    @if(isset($post->tags) && count($post->tags) > 0)
    <div class="mt-10 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
        <div class="flex flex-wrap gap-2">
            @foreach($post->tags as $tag)
            <span class="text-xs px-3 py-1 rounded-full bg-light-surface dark:bg-dark-surface text-text-secondary border border-light-border dark:border-dark-border/40 font-semibold">
                {{ $tag->name }}
            </span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Share -->
    <div class="mt-8 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
        <div class="flex items-center gap-4">
            <span class="text-sm font-bold text-text-secondary/70">Bagikan:</span>
            <a href="#" class="text-text-secondary/60 hover:text-accent transition" aria-label="Share on Twitter">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                </svg>
            </a>
            <a href="#" class="text-text-secondary/60 hover:text-accent transition" aria-label="Share on LinkedIn">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                </svg>
            </a>
            <a href="#" class="text-text-secondary/60 hover:text-accent transition" aria-label="Share on Facebook">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                </svg>
            </a>
        </div>
    </div>
</article>

<!-- Comments -->
@include('blog.partials.comments')
@endsection