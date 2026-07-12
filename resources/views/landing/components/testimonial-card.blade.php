{{-- resources/views/landing/components/testimonial-card.blade.php --}}
@props(['name', 'role', 'content', 'rating' => 5, 'avatar' => null])

<div class="card">
    <div class="card-body">
        <div class="flex items-center gap-1 mb-4">
            @for($i = 1; $i <= 5; $i++)
                <svg class="w-5 h-5 {{ $i <= $rating ? 'text-warning' : 'text-gray-300' }}" 
                     fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            @endfor
        </div>
        <p class="text-text-secondary mb-4 italic">"{{ $content }}"</p>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-accent/10 rounded-full flex items-center justify-center">
                @if($avatar)
                    <img src="{{ $avatar }}" alt="{{ $name }}" class="w-10 h-10 rounded-full object-cover">
                @else
                    <span class="text-accent font-semibold">
                        {{ strtoupper(substr($name, 0, 2)) }}
                    </span>
                @endif
            </div>
            <div>
                <p class="font-semibold">{{ $name }}</p>
                <p class="text-xs text-text-secondary">{{ $role }}</p>
            </div>
        </div>
    </div>
</div>