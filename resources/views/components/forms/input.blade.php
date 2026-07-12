{{-- resources/views/components/forms/input.blade.php --}}
@props([
    'type' => 'text',
    'name' => '',
    'id' => null,
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'disabled' => false,
    'readonly' => false,
    'error' => null,
    'helper' => null,
    'icon' => null,
    'iconPosition' => 'left'
])

@php
    $inputId = $id ?? $name;
    $hasError = $error || $errors->has($name);
    $errorMessage = $error ?: ($errors->first($name) ?? null);
@endphp

<div class="mb-4">
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium mb-2">
            {{ $label }}
            @if($required)
                <span class="text-error">*</span>
            @endif
        </label>
    @endif
    
    <div class="relative">
        @if($icon && $iconPosition === 'left')
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
                </svg>
            </div>
        @endif
        
        <input type="{{ $type }}" 
               name="{{ $name }}" 
               id="{{ $inputId }}"
               value="{{ old($name, $value) }}"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $readonly ? 'readonly' : '' }}
               {{ $attributes->merge(['class' => 'input ' . ($hasError ? 'input-error' : '') . ($icon && $iconPosition === 'left' ? ' pl-10' : '') . ($icon && $iconPosition === 'right' ? ' pr-10' : '')]) }}>
        
        @if($icon && $iconPosition === 'right')
            <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/>
                </svg>
            </div>
        @endif
    </div>
    
    @if($helper && !$hasError)
        <p class="text-xs text-text-secondary mt-1">{{ $helper }}</p>
    @endif
    
    @if($hasError && $errorMessage)
        <p class="text-error text-sm mt-1">{{ $errorMessage }}</p>
    @endif
</div>