{{-- resources/views/catalog/reviews/partials/review-card.blade.php --}}
@props(['review'])

<div class="card hover:shadow-lg transition-all duration-300">
    <div class="card-body">
        <div class="flex items-start gap-4">
            <div class="w-12 h-12 bg-accent/10 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-lg font-bold text-accent">{{ strtoupper(substr($review['name'] ?? 'U', 0, 2)) }}</span>
            </div>
            <div class="flex-1">
                <div class="flex flex-wrap items-center justify-between gap-2">
                    <div>
                        <h4 class="font-semibold text-text-primary dark:text-text-dark-primary">{{ $review['name'] ?? 'Anonymous' }}</h4>
                        <div class="flex items-center gap-2 mt-0.5">
                            <div class="flex">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= ($review['rating'] ?? 0) ? 'text-warning' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="text-xs text-text-secondary">{{ $review['date'] ?? '-' }}</span>
                        </div>
                    </div>
                    <span class="text-xs text-text-secondary">Produk: {{ $review['product'] ?? '-' }}</span>
                </div>
                
                <p class="text-text-secondary dark:text-text-dark-secondary mt-3 leading-relaxed">{{ $review['content'] ?? '' }}</p>
                
                @if(!empty($review['photos']))
                    <div class="flex gap-2 mt-3">
                        @foreach($review['photos'] as $photo)
                            <div class="w-16 h-16 bg-light-surface dark:bg-dark-surface rounded-lg overflow-hidden">
                                <img src="{{ $photo }}" alt="Review photo" class="w-full h-full object-cover">
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <div class="flex items-center gap-4 mt-3">
                    <button class="text-sm text-text-secondary hover:text-accent transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                        </svg>
                        Membantu ({{ $review['helpful'] ?? 0 }})
                    </button>
                    <button class="text-sm text-text-secondary hover:text-accent transition flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                        Balas
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>