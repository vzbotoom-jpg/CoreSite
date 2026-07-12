<?php
// app/View/Components/Button.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    /**
     * Button type (primary, secondary, danger, warning, success).
     */
    public string $type;
    
    /**
     * Button size (sm, md, lg).
     */
    public string $size;
    
    /**
     * Whether button is full width.
     */
    public bool $block;
    
    /**
     * Whether button is disabled.
     */
    public bool $disabled;
    
    /**
     * Button type attribute (submit, button, reset).
     */
    public string $buttonType;
    
    /**
     * Icon name.
     */
    public ?string $icon;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'primary',
        string $size = 'md',
        bool $block = false,
        bool $disabled = false,
        string $buttonType = 'button',
        ?string $icon = null
    ) {
        $this->type = $type;
        $this->size = $size;
        $this->block = $block;
        $this->disabled = $disabled;
        $this->buttonType = $buttonType;
        $this->icon = $icon;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.forms.button');
    }
    
    /**
     * Get button classes.
     */
    public function buttonClasses(): string
    {
        $baseClasses = 'inline-flex items-center justify-center font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2';
        
        $typeClasses = match($this->type) {
            'primary' => 'bg-accent text-white hover:bg-accent-hover focus:ring-accent',
            'secondary' => 'bg-transparent border border-accent text-accent hover:bg-accent/10 focus:ring-accent',
            'danger' => 'bg-error text-white hover:bg-error/80 focus:ring-error',
            'warning' => 'bg-warning text-white hover:bg-warning/80 focus:ring-warning',
            'success' => 'bg-success text-white hover:bg-success/80 focus:ring-success',
            default => 'bg-gray-500 text-white hover:bg-gray-600 focus:ring-gray-500'
        };
        
        $sizeClasses = match($this->size) {
            'sm' => 'px-3 py-1.5 text-sm gap-1.5',
            'lg' => 'px-6 py-3 text-base gap-2',
            default => 'px-4 py-2 text-sm gap-2'
        };
        
        $blockClasses = $this->block ? 'w-full' : '';
        $disabledClasses = $this->disabled ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer';
        
        return implode(' ', [
            $baseClasses,
            $typeClasses,
            $sizeClasses,
            $blockClasses,
            $disabledClasses
        ]);
    }
}