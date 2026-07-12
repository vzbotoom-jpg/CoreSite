<?php
// app/View/Components/Modal.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Modal extends Component
{
    /**
     * Modal ID.
     */
    public string $id;
    
    /**
     * Modal title.
     */
    public ?string $title;
    
    /**
     * Modal size (sm, md, lg, xl).
     */
    public string $size;
    
    /**
     * Whether modal can be closed by clicking outside.
     */
    public bool $closeOnOutsideClick;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $id,
        ?string $title = null,
        string $size = 'md',
        bool $closeOnOutsideClick = true
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->closeOnOutsideClick = $closeOnOutsideClick;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.modals.modal');
    }
    
    /**
     * Get modal size classes.
     */
    public function sizeClasses(): string
    {
        return match($this->size) {
            'sm' => 'max-w-md',
            'lg' => 'max-w-2xl',
            'xl' => 'max-w-4xl',
            'full' => 'max-w-[90vw]',
            default => 'max-w-lg'
        };
    }
}