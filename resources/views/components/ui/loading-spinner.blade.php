{{-- resources/views/components/ui/loading-spinner.blade.php --}}
@props([
    'size' => 'md',
    'color' => 'accent',
    'text' => null,
    'fullPage' => false
])

@php
    $sizes = [
        'sm' => 'w-4 h-4',
        'md' => 'w-8 h-8',
        'lg' => 'w-12 h-12',
        'xl' => 'w-16 h-16'
    ];
    
    $colors = [
        'accent' => 'text-accent',
        'white' => 'text-white',
        'gray' => 'text-text-secondary'
    ];
    
    $sizeClass = $sizes[$size];
    $colorClass = $colors[$color];
@endphp

@if($fullPage)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="text-center">
            <div class="spinner-lg mx-auto"></div>
            @if($text)
                <p class="mt-4 text-white">{{ $text }}</p>
            @endif
        </div>
    </div>
@else
    <div class="flex flex-col items-center justify-center">
        <div class="animate-spin rounded-full border-2 border-t-transparent {{ $sizeClass }} {{ $colorClass }}" 
             style="border-width: {{ $size === 'sm' ? '2px' : ($size === 'md' ? '3px' : '4px') }}">
        </div>
        @if($text)
            <p class="mt-2 text-sm text-text-secondary">{{ $text }}</p>
        @endif
    </div>
@endif