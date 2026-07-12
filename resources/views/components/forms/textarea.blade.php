{{-- resources/views/components/forms/textarea.blade.php --}}
@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'value' => '',
    'placeholder' => '',
    'rows' => 4,
    'required' => false,
    'disabled' => false,
    'readonly' => false,
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
    
    <textarea name="{{ $name }}" 
              id="{{ $inputId }}"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              {{ $required ? 'required' : '' }}
              {{ $disabled ? 'disabled' : '' }}
              {{ $readonly ? 'readonly' : '' }}
              {{ $attributes->merge(['class' => 'input ' . ($hasError ? 'input-error' : '')]) }}>{{ old($name, $value) }}</textarea>
    
    @if($helper && !$hasError)
        <p class="text-xs text-text-secondary mt-1">{{ $helper }}</p>
    @endif
    
    @if($hasError && $errorMessage)
        <p class="text-error text-sm mt-1">{{ $errorMessage }}</p>
    @endif
</div>