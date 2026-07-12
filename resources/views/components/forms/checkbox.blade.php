{{-- resources/views/components/forms/checkbox.blade.php --}}
@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'checked' => false,
    'value' => '1',
    'required' => false,
    'disabled' => false,
    'error' => null
])

@php
    $inputId = $id ?? $name;
    $isChecked = old($name) ? old($name) == $value : $checked;
@endphp

<div class="mb-4">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="checkbox" 
               name="{{ $name }}" 
               id="{{ $inputId }}"
               value="{{ $value }}"
               {{ $isChecked ? 'checked' : '' }}
               {{ $required ? 'required' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $attributes->merge(['class' => 'w-4 h-4 rounded border-gray-300 text-accent focus:ring-accent']) }}>
        
        @if($label)
            <span class="text-sm">{{ $label }}</span>
        @endif
        
        {{ $slot }}
    </label>
    
    @if($error)
        <p class="text-error text-sm mt-1">{{ $error }}</p>
    @endif
</div>