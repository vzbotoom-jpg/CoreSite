{{-- resources/views/components/ui/card.blade.php --}}
@props([
    'title' => null,
    'subtitle' => null,
    'padding' => true,
    'hoverable' => false,
    'class' => ''
])

<div {{ $attributes->merge(['class' => 'card ' . ($hoverable ? 'hover:shadow-lg transition-all duration-300' : '') . ' ' . $class]) }}>
    @if($title || $subtitle)
        <div class="card-header">
            @if($title)
                <h3 class="text-lg font-semibold">{{ $title }}</h3>
            @endif
            @if($subtitle)
                <p class="text-sm text-text-secondary">{{ $subtitle }}</p>
            @endif
            @if(isset($header))
                {{ $header }}
            @endif
        </div>
    @endif
    
    <div @class(['card-body' => $padding, 'p-0' => !$padding])>
        {{ $slot }}
    </div>
    
    @if(isset($footer))
        <div class="card-footer">
            {{ $footer }}
        </div>
    @endif
</div>