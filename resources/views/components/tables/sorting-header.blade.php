{{-- resources/views/components/tables/sorting-header.blade.php --}}
@props([
    'field',
    'label',
    'currentSort',
    'currentDirection',
    'onSort'
])

@php
    $isActive = $currentSort === $field;
    $nextDirection = '';
    if ($isActive) {
        $nextDirection = $currentDirection === 'asc' ? 'desc' : 'asc';
    } else {
        $nextDirection = 'asc';
    }
@endphp

<th class="text-left px-4 py-3 text-sm font-medium text-text-secondary">
    <button onclick="{{ $onSort }}('{{ $field }}', '{{ $nextDirection }}')" 
            class="flex items-center gap-1 hover:text-accent group">
        {{ $label }}
        <span class="opacity-0 group-hover:opacity-100 transition-opacity">
            @if($isActive)
                @if($currentDirection === 'asc')
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
                    </svg>
                @else
                    <svg class="w-4 h-4 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                @endif
            @else
                <svg class="w-4 h-4 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                </svg>
            @endif
        </span>
    </button>
</th>