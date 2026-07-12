{{-- resources/views/components/layout/section.blade.php --}}
@props([
    'title' => null,
    'subtitle' => null,
    'background' => 'default',
    'padding' => '12',
    'centered' => true,
    'id' => null,
])

@php
    $backgrounds = [
        'default' => 'bg-light-bg dark:bg-dark-bg',
        'surface' => 'bg-light-surface dark:bg-dark-surface',
        'accent' => 'bg-accent/5',
        'primary' => 'bg-accent text-white',
        'dark' => 'bg-dark-bg text-white',
        'transparent' => 'bg-transparent',
        'gradient' => 'bg-gradient-to-b from-accent/5 to-transparent',
    ];
    
    $bgClass = $backgrounds[$background] ?? 'bg-light-bg dark:bg-dark-bg';
    
    $paddingClasses = match($padding) {
        '4' => 'py-4',
        '8' => 'py-8',
        '12' => 'py-12',
        '16' => 'py-16',
        '20' => 'py-20',
        '24' => 'py-24',
        '32' => 'py-32',
        default => 'py-12',
    };
    
    $titleClasses = match($background) {
        'primary', 'dark' => 'text-white',
        default => 'text-text-primary dark:text-text-dark-primary',
    };
    
    $subtitleClasses = match($background) {
        'primary', 'dark' => 'text-white/80',
        default => 'text-text-secondary dark:text-text-dark-secondary',
    };
@endphp

<section {{ $attributes->merge(['class' => $bgClass . ' ' . $paddingClasses]) }} @if($id) id="{{ $id }}" @endif>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($title || $subtitle)
            <div class="text-center {{ $centered ? 'text-center' : 'text-left' }} mb-12">
                @if($title)
                    <h2 class="text-3xl md:text-4xl font-bold {{ $titleClasses }} mb-4">
                        {{ $title }}
                    </h2>
                @endif
                @if($subtitle)
                    <p class="text-lg {{ $subtitleClasses }} max-w-2xl {{ $centered ? 'mx-auto' : '' }}">
                        {{ $subtitle }}
                    </p>
                @endif
            </div>
        @endif
        
        {{ $slot }}
    </div>
</section>