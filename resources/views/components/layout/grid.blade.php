{{-- resources/views/components/layout/grid.blade.php --}}
@props([
    'cols' => 1,
    'gap' => 6,
    'responsive' => true,
    'align' => 'stretch',
])

@php
    $colClasses = match($cols) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 sm:grid-cols-2',
        3 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4',
        5 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5',
        6 => 'grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6',
        default => 'grid-cols-1',
    };
    
    if (!$responsive) {
        $colClasses = "grid-cols-{$cols}";
    }
    
    $gapClasses = match($gap) {
        1 => 'gap-1',
        2 => 'gap-2',
        3 => 'gap-3',
        4 => 'gap-4',
        5 => 'gap-5',
        6 => 'gap-6',
        8 => 'gap-8',
        10 => 'gap-10',
        12 => 'gap-12',
        16 => 'gap-16',
        default => 'gap-6',
    };
    
    $alignClasses = match($align) {
        'start' => 'items-start',
        'end' => 'items-end',
        'center' => 'items-center',
        'baseline' => 'items-baseline',
        'stretch' => 'items-stretch',
        default => 'items-stretch',
    };
@endphp

<div class="grid {{ $colClasses }} {{ $gapClasses }} {{ $alignClasses }}">
    {{ $slot }}
</div>