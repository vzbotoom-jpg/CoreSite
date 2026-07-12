{{-- resources/views/catalog/partials/breadcrumb.blade.php --}}
@props(['items' => []])

<nav class="mb-6">
    <ol class="flex flex-wrap items-center gap-2 text-sm">
        <li>
            <a href="{{ url('/') }}" class="text-text-secondary hover:text-accent">
                Beranda
            </a>
        </li>
        
        @foreach($items as $index => $item)
            <li>
                <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </li>
            <li>
                @if($item['url'])
                    <a href="{{ $item['url'] }}" class="text-text-secondary hover:text-accent">
                        {{ $item['name'] }}
                    </a>
                @else
                    <span class="text-text-primary dark:text-text-dark-primary font-medium">
                        {{ $item['name'] }}
                    </span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>