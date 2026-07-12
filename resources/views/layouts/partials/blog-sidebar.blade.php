{{-- resources/views/layouts/partials/blog-sidebar.blade.php --}}
<div class="sticky top-24 max-h-[calc(100vh-6rem)] overflow-y-auto space-y-10 pr-2">
    <!-- Journal Title -->
    <div class="pb-6 border-b border-light-border/40 dark:border-dark-border/40">
        <h2 class="text-xl font-bold text-text-primary dark:text-text-dark-primary tracking-tight">
            Journal
        </h2>
        <p class="text-sm text-text-secondary/70 mt-1 leading-relaxed">
            Thoughts on building, fixing, and learning.
        </p>
    </div>

    <!-- Search -->
    <div>
        <h4 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Search
        </h4>
        <form action="{{ route('blog.search') }}" method="GET" class="relative">
            <input 
                type="text" 
                name="q" 
                placeholder="Search articles..." 
                class="w-full px-4 py-2.5 bg-light-surface dark:bg-dark-surface border-0 rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/60 focus:ring-1 focus:ring-accent/50 transition outline-none text-sm"
            >
            <button 
                type="submit" 
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-text-secondary/60 hover:text-accent transition"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </button>
        </form>
    </div>

    <!-- Subscribe -->
    <div class="bg-light-surface/50 dark:bg-dark-surface/50 rounded-xl p-5">
        <h4 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-2">
            Subscribe
        </h4>
        <p class="text-sm text-text-secondary dark:text-text-dark-secondary mb-4 leading-relaxed">
            Get the latest posts delivered right to your inbox.
        </p>
        <form action="{{ route('blog.subscribe') }}" method="POST" class="space-y-3">
            @csrf
            <input 
                type="email" 
                name="email" 
                placeholder="Your email address" 
                class="w-full px-4 py-2 bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/60 focus:ring-1 focus:ring-accent/50 transition outline-none text-sm"
                required
            >
            <button 
                type="submit" 
                class="w-full px-4 py-2 bg-text-primary dark:bg-text-dark-primary text-light-bg dark:text-dark-bg font-medium rounded-lg hover:opacity-80 transition text-sm"
            >
                Subscribe
            </button>
        </form>
    </div>

    <!-- Categories -->
    <div>
        <h4 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Categories
        </h4>
        <div class="space-y-1.5">
            @foreach($categories ?? [] as $category)
            <a 
                href="{{ route('blog.category', $category->slug) }}" 
                class="flex justify-between items-center py-1.5 text-sm text-text-secondary hover:text-text-primary dark:hover:text-text-dark-primary transition group"
            >
                <span class="group-hover:underline">{{ $category->name }}</span>
                <span class="text-xs text-text-secondary/60">{{ $category->posts_count ?? 0 }}</span>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Recent Posts -->
    <div>
        <h4 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Recent Posts
        </h4>
        <div class="space-y-4">
            @foreach($recentPosts ?? [] as $recent)
            <a href="{{ route('blog.post', $recent->slug) }}" class="block group">
                <p class="text-sm text-text-primary dark:text-text-dark-primary group-hover:text-accent transition leading-snug">
                    {{ $recent->title }}
                </p>
                <p class="text-xs text-text-secondary/60 mt-1">{{ $recent->created_at->format('M d, Y') }}</p>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Tags -->
    @if(isset($tags) && count($tags) > 0)
    <div>
        <h4 class="text-xs font-semibold text-text-secondary dark:text-text-dark-secondary uppercase tracking-wider mb-4">
            Tags
        </h4>
        <div class="flex flex-wrap gap-1.5">
            @foreach($tags as $tag)
            <a 
                href="{{ route('blog.tag', $tag->slug) }}" 
                class="text-xs px-2.5 py-1 rounded-full bg-light-surface dark:bg-dark-surface text-text-secondary hover:text-accent hover:bg-accent/5 transition"
            >
                {{ $tag->name }}
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>