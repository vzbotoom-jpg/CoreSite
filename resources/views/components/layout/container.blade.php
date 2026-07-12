{{-- resources/views/components/layout/container.blade.php --}}
@props([
    'maxWidth' => '7xl',
    'padding' => true,
    'centered' => false,
    'fullHeight' => false,
])

@php
    $maxWidths = [
        'sm' => 'max-w-screen-sm',
        'md' => 'max-w-screen-md',
        'lg' => 'max-w-screen-lg',
        'xl' => 'max-w-screen-xl',
        '2xl' => 'max-w-screen-2xl',
        '7xl' => 'max-w-7xl',
        'full' => 'max-w-full',
        'none' => '',
    ];
    
    $paddingClass = $padding ? 'px-4 sm:px-6 lg:px-8' : '';
    $widthClass = $maxWidths[$maxWidth] ?? 'max-w-7xl';
    $centeredClass = $centered ? 'mx-auto' : '';
    $heightClass = $fullHeight ? 'min-h-screen' : '';
@endphp

<div class="{{ $widthClass }} {{ $paddingClass }} {{ $centeredClass }} {{ $heightClass }}">
    {{ $slot }}
</div>