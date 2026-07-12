{{-- resources/views/components/ui/avatar.blade.php --}}
@props([
    'src' => null,
    'name' => null,
    'size' => 'md',
    'rounded' => 'full'
])

@php
    $sizes = [
        'xs' => 'w-6 h-6 text-xs',
        'sm' => 'w-8 h-8 text-sm',
        'md' => 'w-10 h-10 text-base',
        'lg' => 'w-12 h-12 text-lg',
        'xl' => 'w-16 h-16 text-xl'
    ];
    
    $roundedStyles = [
        'none' => 'rounded-none',
        'sm' => 'rounded',
        'md' => 'rounded-md',
        'lg' => 'rounded-lg',
        'full' => 'rounded-full'
    ];
    
    $sizeClass = $sizes[$size];
    $roundedClass = $roundedStyles[$rounded];
    
    $initials = '';
    if ($name) {
        $words = explode(' ', $name);
        $initials = strtoupper(substr($words[0], 0, 1));
        if (isset($words[1])) {
            $initials .= strtoupper(substr($words[1], 0, 1));
        }
    }
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center bg-accent/10 ' . $sizeClass . ' ' . $roundedClass]) }}>
    @if($src)
        <img src="{{ $src }}" alt="{{ $name }}" class="w-full h-full object-cover {{ $roundedClass }}">
    @else
        <span class="font-semibold text-accent">{{ $initials ?: '?' }}</span>
    @endif
</div>