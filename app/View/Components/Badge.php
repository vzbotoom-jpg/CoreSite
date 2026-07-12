<?php
// app/View/Components/Badge.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Badge extends Component
{
    /**
     * Badge type (success, error, warning, info, primary, secondary).
     */
    public string $type;
    
    /**
     * Badge size (sm, md).
     */
    public string $size;
    
    /**
     * Whether badge is rounded full.
     */
    public bool $pill;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'secondary',
        string $size = 'md',
        bool $pill = false
    ) {
        $this->type = $type;
        $this->size = $size;
        $this->pill = $pill;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.ui.badge');
    }
    
    /**
     * Get badge classes.
     */
    public function badgeClasses(): string
    {
        $baseClasses = 'inline-flex items-center font-medium';
        
        $typeClasses = match($this->type) {
            'success' => 'bg-success/10 text-success',
            'error' => 'bg-error/10 text-error',
            'warning' => 'bg-warning/10 text-warning',
            'info' => 'bg-info/10 text-info',
            'primary' => 'bg-accent/10 text-accent',
            default => 'bg-light-surface dark:bg-dark-surface text-text-secondary'
        };
        
        $sizeClasses = match($this->size) {
            'sm' => 'px-2 py-0.5 text-xs',
            default => 'px-2.5 py-1 text-sm'
        };
        
        $roundedClasses = $this->pill ? 'rounded-full' : 'rounded';
        
        return implode(' ', [$baseClasses, $typeClasses, $sizeClasses, $roundedClasses]);
    }
}