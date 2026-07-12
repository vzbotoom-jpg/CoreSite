{{-- resources/views/components/ui/alert.blade.php --}}
@props([
    'type' => 'info',
    'dismissible' => false,
    'title' => null
])

@php
    $types = [
        'success' => 'bg-success/10 border-success/20 text-success',
        'danger' => 'bg-error/10 border-error/20 text-error',
        'warning' => 'bg-warning/10 border-warning/20 text-warning',
        'info' => 'bg-info/10 border-info/20 text-info'
    ];
    
    $icons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'danger' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ];
    
    $titleDefaults = [
        'success' => 'Berhasil!',
        'danger' => 'Error!',
        'warning' => 'Peringatan!',
        'info' => 'Informasi'
    ];
    
    $alertClass = $types[$type];
    $iconPath = $icons[$type];
    $displayTitle = $title ?? $titleDefaults[$type];
@endphp

<div x-data="{ show: true }" x-show="show" class="alert {{ $alertClass }} mb-4">
    <div class="flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $iconPath }}"/>
        </svg>
        <div class="flex-1">
            <h4 class="font-semibold mb-1">{{ $displayTitle }}</h4>
            <p class="text-sm">{{ $slot }}</p>
        </div>
        @if($dismissible)
            <button @click="show = false" class="flex-shrink-0 text-current opacity-70 hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        @endif
    </div>
</div>