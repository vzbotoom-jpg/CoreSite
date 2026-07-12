{{-- resources/views/components/modals/alert-modal.blade.php --}}
@props([
    'id' => null,
    'title' => 'Informasi',
    'message' => '',
    'type' => 'info',
    'buttonText' => 'OK',
    'show' => false,
    'onClose' => null
])

@php
    $typeClasses = [
        'success' => 'text-success bg-success/10',
        'error' => 'text-error bg-error/10',
        'warning' => 'text-warning bg-warning/10',
        'info' => 'text-info bg-info/10'
    ];
    
    $typeIcons = [
        'success' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        'error' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
        'warning' => 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z',
        'info' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'
    ];
    
    $modalId = $id ?? 'alert-modal-' . uniqid();
@endphp

<div x-data="{ 
    open: {{ $show ? 'true' : 'false' }},
    close() {
        this.open = false;
        @if($onClose)
            {{ $onClose }}
        @endif
    }
}" 
     x-show="open" 
     x-cloak
     class="fixed inset-0 z-50 overflow-y-auto">
    
    <div class="fixed inset-0 bg-black/50"></div>
    
    <div class="flex min-h-full items-center justify-center p-4">
        <div class="relative max-w-md w-full transform transition-all"
             x-show="open"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            
            <div class="card">
                <div class="card-body text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full {{ $typeClasses[$type] }} mb-4">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $typeIcons[$type] }}"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">{{ $title }}</h3>
                    <p class="text-text-secondary mb-6">{{ $message }}</p>
                    <button @click="close" class="btn btn-primary w-full">
                        {{ $buttonText }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>