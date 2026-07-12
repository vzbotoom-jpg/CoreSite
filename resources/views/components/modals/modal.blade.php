{{-- resources/views/components/modals/modal.blade.php --}}
@props([
    'id' => null,
    'title' => null,
    'size' => 'md',
    'showClose' => true,
    'closeOnOverlay' => true,
    'show' => false
])

@php
    $sizeClasses = [
        'sm' => 'max-w-md',
        'md' => 'max-w-lg',
        'lg' => 'max-w-2xl',
        'xl' => 'max-w-4xl',
        'full' => 'max-w-[90vw]'
    ];
    
    $modalId = $id ?? 'modal-' . uniqid();
@endphp

<div x-data="{ open: {{ $show ? 'true' : 'false' }} }" 
     x-show="open" 
     x-cloak
     @keydown.escape.window="open = false"
     class="fixed inset-0 z-50 overflow-y-auto">
    
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/50 transition-opacity" 
         @click="{{ $closeOnOverlay ? 'open = false' : '' }}"></div>
    
    <!-- Modal Container -->
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative {{ $sizeClasses[$size] }} w-full transform transition-all"
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="card">
                <!-- Header -->
                @if($title || $showClose)
                    <div class="card-header flex justify-between items-center">
                        @if($title)
                            <h3 class="text-lg font-semibold">{{ $title }}</h3>
                        @else
                            <div></div>
                        @endif
                        
                        @if($showClose)
                            <button @click="open = false" class="text-text-secondary hover:text-text-primary">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        @endif
                    </div>
                @endif
                
                <!-- Body -->
                <div class="card-body">
                    {{ $slot }}
                </div>
                
                <!-- Footer (if any) -->
                @if(isset($footer))
                    <div class="card-footer">
                        {{ $footer }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>