<?php
// app/View/Components/Card.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Card extends Component
{
    /**
     * Card title.
     */
    public ?string $title;
    
    /**
     * Card subtitle.
     */
    public ?string $subtitle;
    
    /**
     * Whether to show hover effect.
     */
    public bool $hoverable;
    
    /**
     * Whether to remove padding.
     */
    public bool $noPadding;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        ?string $title = null,
        ?string $subtitle = null,
        bool $hoverable = false,
        bool $noPadding = false
    ) {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->hoverable = $hoverable;
        $this->noPadding = $noPadding;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.ui.card');
    }
    
    /**
     * Get card classes.
     */
    public function cardClasses(): string
    {
        $baseClasses = 'bg-light-bg dark:bg-dark-bg border border-light-border dark:border-dark-border rounded-xl overflow-hidden';
        
        $hoverClasses = $this->hoverable 
            ? 'transition-all duration-200 hover:shadow-lg hover:border-accent/20' 
            : '';
        
        return implode(' ', [$baseClasses, $hoverClasses]);
    }
    
    /**
     * Get body classes.
     */
    public function bodyClasses(): string
    {
        return $this->noPadding ? '' : 'p-6';
    }
}