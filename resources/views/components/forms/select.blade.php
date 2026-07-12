{{-- resources/views/components/forms/select.blade.php --}}
@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'options' => [],
    'selected' => null,
    'placeholder' => 'Pilih...',
    'required' => false,
    'disabled' => false,
    'error' => null,
    'helper' => null
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
    
    <select name="{{ $name }}" 
            id="{{ $inputId }}"
            {{ $required ? 'required' : '' }}
            {{ $disabled ? 'disabled' : '' }}
            {{ $attributes->merge(['class' => 'input ' . ($hasError ? 'input-error' : '')]) }}>
        
        @if($placeholder)
            <option value="">{{ $placeholder }}</option>
        @endif
        
        @foreach($options as $value => $label)
            <option value="{{ $value }}" {{ (old($name, $selected) == $value) ? 'selected' : '' }}>
                {{ $label }}
            </option>
        @endforeach
    </select>
    
    @if($helper && !$hasError)
        <p class="text-xs text-text-secondary mt-1">{{ $helper }}</p>
    @endif
    
    @if($hasError && $errorMessage)
        <p class="text-error text-sm mt-1">{{ $errorMessage }}</p>
    @endif
</div>