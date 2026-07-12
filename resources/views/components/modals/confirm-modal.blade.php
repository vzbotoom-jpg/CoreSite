{{-- resources/views/components/modals/confirm-modal.blade.php --}}
@props([
    'id' => null,
    'title' => 'Konfirmasi',
    'message' => 'Apakah Anda yakin?',
    'confirmText' => 'Ya, Lanjutkan',
    'cancelText' => 'Batal',
    'confirmVariant' => 'primary',
    'show' => false,
    'onConfirm' => null,
    'onCancel' => null
])

@php
    $modalId = $id ?? 'confirm-modal-' . uniqid();
@endphp

<div x-data="{ 
    open: {{ $show ? 'true' : 'false' }},
    confirm() {
        @if($onConfirm)
            {{ $onConfirm }}
        @endif
        this.open = false;
    },
    cancel() {
        @if($onCancel)
            {{ $onCancel }}
        @endif
        this.open = false;
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
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-warning/10 mb-4">
                        <svg class="h-6 w-6 text-warning" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold mb-2">{{ $title }}</h3>
                    <p class="text-text-secondary mb-6">{{ $message }}</p>
                    <div class="flex gap-3 justify-center">
                        <button @click="cancel" class="btn btn-secondary">
                            {{ $cancelText }}
                        </button>
                        <button @click="confirm" class="btn btn-{{ $confirmVariant }}">
                            {{ $confirmText }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>