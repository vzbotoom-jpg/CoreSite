{{-- resources/views/components/forms/button.blade.php --}}
@props([
    'type' => 'button',
    'variant' => 'primary',
    'size' => 'md',
    'icon' => null,
    'iconPosition' => 'left',
    'loading' => false,
    'disabled' => false,
    'fullWidth' => false
])

@php
    $sizeClasses = [
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base'
    ];
    
    $variantClasses = [
        'primary' => 'btn-primary',
        'secondary' => 'btn-secondary',
        'danger' => 'btn-danger',
        'warning' => 'btn-warning',
        'success' => 'btn-success',
        'outline' => 'btn-outline'
    ];
    
    $widthClass = $fullWidth ? 'w-full' : '';
    $disabledClass = ($disabled || $loading) ? 'opacity-50 cursor-not-allowed' : '';
    
    $classes = trim($sizeClasses[$size] . ' ' . $variantClasses[$variant] . ' ' . $widthClass . ' ' . $disabledClass);
@endphp

<button type="{{ $type }}" 
        {{ $disabled || $loading ? 'disabled' : '' }}
        {{ $attributes->merge(['class' => $classes]) }}>
    
    @if($loading)
        <svg class="animate-spin h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    @elseif($icon && $iconPosition === 'left')
        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
    @endif
    
    {{ $slot }}
    
    @if($icon && $iconPosition === 'right' && !$loading)
        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
        </svg>
    @endif
</button>