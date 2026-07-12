{{-- resources/views/components/ui/badge.blade.php --}}
@props([
    'variant' => 'secondary',
    'size' => 'md',
    'pill' => false
])

@php
    $variants = [
        'primary' => 'bg-accent/10 text-accent',
        'secondary' => 'bg-light-surface dark:bg-dark-surface text-text-secondary',
        'success' => 'bg-success/10 text-success',
        'danger' => 'bg-error/10 text-error',
        'warning' => 'bg-warning/10 text-warning',
        'info' => 'bg-info/10 text-info'
    ];
    
    $sizes = [
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-sm',
        'lg' => 'px-3 py-1.5 text-base'
    ];
    
    $roundedClass = $pill ? 'rounded-full' : 'rounded';
    $classes = trim($variants[$variant] . ' ' . $sizes[$size] . ' ' . $roundedClass);
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center font-medium ' . $classes]) }}>
    {{ $slot }}
</span>