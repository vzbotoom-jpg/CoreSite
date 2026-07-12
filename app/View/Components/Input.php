<?php
// app/View/Components/Input.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Input extends Component
{
    /**
     * Input type.
     */
    public string $type;
    
    /**
     * Input name.
     */
    public string $name;
    
    /**
     * Input id.
     */
    public ?string $id;
    
    /**
     * Input label.
     */
    public ?string $label;
    
    /**
     * Input value.
     */
    public ?string $value;
    
    /**
     * Input placeholder.
     */
    public ?string $placeholder;
    
    /**
     * Whether input is required.
     */
    public bool $required;
    
    /**
     * Whether input is disabled.
     */
    public bool $disabled;
    
    /**
     * Error message.
     */
    public ?string $error;
    
    /**
     * Helper text.
     */
    public ?string $helper;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'text',
        string $name = '',
        ?string $id = null,
        ?string $label = null,
        ?string $value = null,
        ?string $placeholder = null,
        bool $required = false,
        bool $disabled = false,
        ?string $error = null,
        ?string $helper = null
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id ?? $name;
        $this->label = $label;
        $this->value = $value;
        $this->placeholder = $placeholder;
        $this->required = $required;
        $this->disabled = $disabled;
        $this->error = $error;
        $this->helper = $helper;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.forms.input');
    }
    
    /**
     * Get input classes.
     */
    public function inputClasses(): string
    {
        $baseClasses = 'w-full rounded-lg border bg-white dark:bg-dark-bg px-4 py-2 text-text-primary dark:text-text-dark-primary focus:outline-none focus:ring-2 focus:ring-accent transition-all duration-200';
        
        $errorClasses = $this->hasError() 
            ? 'border-error focus:border-error focus:ring-error/20' 
            : 'border-light-border dark:border-dark-border focus:border-accent';
        
        $disabledClasses = $this->disabled ? 'bg-light-surface dark:bg-dark-surface cursor-not-allowed opacity-50' : '';
        
        return implode(' ', [$baseClasses, $errorClasses, $disabledClasses]);
    }
    
    /**
     * Check if has error.
     */
    public function hasError(): bool
    {
        return !empty($this->error);
    }
    
    /**
     * Get old value from session.
     */
    public function oldValue()
    {
        if ($this->value) {
            return $this->value;
        }
        
        return old($this->name);
    }
}