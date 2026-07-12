{{-- resources/views/components/ui/tooltip.blade.php --}}
@props([
    'text',
    'position' => 'top',
    'delay' => 0,
    'size' => 'md',
    'color' => 'dark',
])

@php
    $positions = [
        'top' => 'bottom-full left-1/2 -translate-x-1/2 mb-2',
        'top-left' => 'bottom-full left-0 mb-2',
        'top-right' => 'bottom-full right-0 mb-2',
        'bottom' => 'top-full left-1/2 -translate-x-1/2 mt-2',
        'bottom-left' => 'top-full left-0 mt-2',
        'bottom-right' => 'top-full right-0 mt-2',
        'left' => 'right-full top-1/2 -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 -translate-y-1/2 ml-2',
    ];
    
    $positionClass = $positions[$position] ?? $positions['top'];
    
    $sizeClasses = match ($size) {
        'sm' => 'px-1.5 py-0.5 text-[10px]',
        'lg' => 'px-3 py-1.5 text-sm',
        default => 'px-2 py-1 text-xs',
    };
    
    $colorClasses = match ($color) {
        'light' => 'bg-white text-text-primary border border-light-border',
        'accent' => 'bg-accent text-white',
        'error' => 'bg-error text-white',
        'warning' => 'bg-warning text-black',
        'info' => 'bg-info text-white',
        default => 'bg-gray-900 dark:bg-gray-700 text-white',
    };
    
    $arrowColor = match ($color) {
        'light' => 'bg-white border-light-border',
        'accent' => 'bg-accent',
        'error' => 'bg-error',
        'warning' => 'bg-warning',
        'info' => 'bg-info',
        default => 'bg-gray-900 dark:bg-gray-700',
    };
    
    $arrowPosition = match ($position) {
        'top', 'top-left', 'top-right' => 'top-full left-1/2 -translate-x-1/2 -mt-[1px]',
        'bottom', 'bottom-left', 'bottom-right' => 'bottom-full left-1/2 -translate-x-1/2 -mb-[1px]',
        'left' => 'left-full top-1/2 -translate-y-1/2 -ml-[1px]',
        'right' => 'right-full top-1/2 -translate-y-1/2 -mr-[1px]',
        default => 'top-full left-1/2 -translate-x-1/2',
    };
    
    $arrowTransform = match ($position) {
        'top', 'top-left', 'top-right' => 'rotate-45',
        'bottom', 'bottom-left', 'bottom-right' => 'rotate-45',
        'left' => 'rotate-45',
        'right' => 'rotate-45',
        default => 'rotate-45',
    };
@endphp

<div class="relative inline-block group">
    <div class="cursor-pointer">
        {{ $slot }}
    </div>
    
    <div class="absolute z-50 invisible group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200 {{ $positionClass }}"
         style="transition-delay: {{ $delay }}ms;">
        <div class="relative">
            <div class="{{ $sizeClasses }} {{ $colorClasses }} rounded shadow-lg whitespace-nowrap max-w-xs">
                {{ $text }}
            </div>
            
            <!-- Arrow -->
            <div class="absolute w-2 h-2 {{ $arrowColor }} {{ $arrowTransform }} {{ $arrowPosition }}"
                 style="border: inherit;"></div>
        </div>
    </div>
</div>