{{-- resources/views/components/ui/dropdown.blade.php --}}
@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-light-bg dark:bg-dark-bg',
    'trigger' => null,
    'triggerClass' => '',
    'placement' => 'bottom',
    'offset' => 8,
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        'right' => 'ltr:origin-top-right rtl:origin-top-left end-0',
        'center' => 'left-1/2 -translate-x-1/2 origin-top',
        default => 'origin-top',
    };
    
    $placementClasses = match ($placement) {
        'top' => 'bottom-full mb-2',
        'bottom' => 'top-full mt-2',
        'left' => 'right-full mr-2 top-1/2 -translate-y-1/2',
        'right' => 'left-full ml-2 top-1/2 -translate-y-1/2',
        default => 'top-full mt-2',
    };
    
    $widthClasses = match ($width) {
        '48' => 'w-48',
        '64' => 'w-64',
        '80' => 'w-80',
        '96' => 'w-96',
        'full' => 'w-full',
        default => 'w-48',
    };
@endphp

<div x-data="{ open: false }" 
     @click.outside="open = false" 
     @close.stop="open = false"
     class="relative inline-block">
    
    <!-- Trigger -->
    <div @click="open = !open" class="cursor-pointer {{ $triggerClass }}">
        {{ $trigger ?? $slot }}
    </div>

    <!-- Dropdown Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="absolute z-50 {{ $placementClasses }} {{ $alignmentClasses }} {{ $widthClasses }}"
         style="display: none;"
         @click="open = false">
        
        <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 dark:ring-white/10 {{ $contentClasses }}">
            {{ $content ?? '' }}
        </div>
    </div>
</div>