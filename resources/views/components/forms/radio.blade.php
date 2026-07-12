{{-- resources/views/components/forms/radio.blade.php --}}
@props([
    'name' => '',
    'id' => null,
    'label' => null,
    'value' => '',
    'checked' => false,
    'required' => false,
    'disabled' => false,
    'group' => null
])

@php
    $inputId = $id ?? $name . '_' . $value;
    $isChecked = old($name) == $value || $checked;
@endphp

<div class="mb-2">
    <label class="flex items-center gap-2 cursor-pointer">
        <input type="radio" 
               name="{{ $name }}" 
               id="{{ $inputId }}"
               value="{{ $value }}"
               {{ $isChecked ? 'checked' : '' }}
               {{ $required ? 'required' : '' }}
               {{ $disabled ? 'disabled' : '' }}
               {{ $attributes->merge(['class' => 'w-4 h-4 border-gray-300 text-accent focus:ring-accent']) }}>
        
        @if($label)
            <span class="text-sm">{{ $label }}</span>
        @endif
        
        {{ $slot }}
    </label>
</div>