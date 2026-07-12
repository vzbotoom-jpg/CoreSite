{{-- resources/views/components/ui/tabs.blade.php --}}
@props([
    'tabs' => [],
    'activeTab' => null,
    'variant' => 'underline'
])

@php
    $variants = [
        'underline' => 'border-b',
        'pills' => 'gap-2',
        'buttons' => 'gap-2'
    ];
    
    $variantClass = $variants[$variant];
@endphp

<div x-data="{ active: '{{ $activeTab ?? ($tabs[0]['id'] ?? '') }}' }">
    <div class="flex {{ $variantClass }} mb-6">
        @foreach($tabs as $tab)
            <button @click="active = '{{ $tab['id'] }}'"
                    :class="{
                        'tab-active': active === '{{ $tab['id'] }}',
                        'border-b-2 border-transparent hover:border-accent': '{{ $variant }}' === 'underline',
                        'btn-outline': '{{ $variant }}' === 'pills' && active !== '{{ $tab['id'] }}',
                        'btn-primary': '{{ $variant }}' === 'pills' && active === '{{ $tab['id'] }}',
                        'btn-secondary': '{{ $variant }}' === 'buttons'
                    }"
                    class="tab px-4 py-2 font-medium transition-all">
                @if(isset($tab['icon']))
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $tab['icon'] }}"/>
                    </svg>
                @endif
                {{ $tab['label'] }}
                @if(isset($tab['badge']))
                    <span class="ml-2 px-2 py-0.5 text-xs rounded-full bg-accent/10 text-accent">
                        {{ $tab['badge'] }}
                    </span>
                @endif
            </button>
        @endforeach
    </div>
    
    @foreach($tabs as $tab)
        <div x-show="active === '{{ $tab['id'] }}'" x-cloak>
            {{ $tab['content'] ?? ($slot ?? '') }}
        </div>
    @endforeach
</div>