{{-- resources/views/blog/partials/comments.blade.php --}}
<div class="mt-16 pt-8 border-t border-light-border/40 dark:border-dark-border/40">
    <h3 class="text-lg font-bold text-text-primary dark:text-text-dark-primary mb-6">
        Komentar <span class="text-text-secondary/60 text-sm font-normal">({{ $post->comments_count ?? 0 }})</span>
    </h3>

    <!-- Comment Form -->
    <form action="{{ route('blog.comment', $post->slug) }}" method="POST" class="mb-10">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="comment-content" class="sr-only">Komentar Anda</label>
                <textarea 
                    id="comment-content"
                    name="content" 
                    rows="4" 
                    class="w-full px-4 py-3 bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border rounded-lg text-text-primary dark:text-text-dark-primary placeholder:text-text-secondary/60 focus:ring-1 focus:ring-accent/50 transition outline-none resize-y text-sm"
                    placeholder="Bagikan pemikiran Anda..."
                    required
                ></textarea>
            </div>
            <div>
                <button type="submit" class="btn btn-primary text-xs font-bold py-2.5 px-6 rounded-xl shadow-md shadow-accent/10">
                    Kirim Komentar
                </button>
            </div>
        </div>
    </form>

    <!-- Comments List -->
    <div class="space-y-6">
        @forelse($post->comments ?? [] as $comment)
        <div class="flex gap-4">
            <div class="w-9 h-9 bg-accent/10 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-accent font-bold text-xs">
                    {{ strtoupper(substr($comment->user->name ?? $comment->author_name ?? 'A', 0, 1)) }}
                </span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-text-primary dark:text-text-dark-primary text-xs">
                        {{ $comment->user->name ?? $comment->author_name ?? 'Anonim' }}
                    </span>
                    <span class="text-xs text-text-secondary/60">•</span>
                    <span class="text-[11px] text-text-secondary/60">{{ $comment->created_at->diffForHumans() }}</span>
                </div>
                <p class="text-text-secondary dark:text-text-dark-secondary mt-1 text-xs leading-relaxed">
                    {{ $comment->content }}
                </p>
                <button 
                    onclick="likeComment({{ $comment->id }})" 
                    class="mt-2 text-[10px] font-bold text-text-secondary/60 hover:text-accent transition flex items-center gap-1 bg-light-surface dark:bg-dark-surface border border-light-border dark:border-dark-border/40 py-1 px-2.5 rounded-full"
                >
                    <svg class="w-3.5 h-3.5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                    <span id="like-count-{{ $comment->id }}">{{ $comment->likes }}</span> Menyukai
                </button>
            </div>
        </div>
        @empty
        <div class="text-center py-8">
            <p class="text-text-secondary/70 text-xs italic">Belum ada komentar. Jadilah yang pertama!</p>
        </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script>
function likeComment(id) {
    fetch(`/blog/comment/like/${id}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`like-count-${id}`).textContent = data.likes;
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush