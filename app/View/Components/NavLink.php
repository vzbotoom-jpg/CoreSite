<?php
// app/View/Components/NavLink.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class NavLink extends Component
{
    /**
     * The link href.
     */
    public string $href;
    
    /**
     * Whether the link is active.
     */
    public bool $active;
    
    /**
     * The icon name.
     */
    public ?string $icon;
    
    /**
     * The badge text.
     */
    public ?string $badge;
    
    /**
     * Whether to open in new tab.
     */
    public bool $external;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $href, 
        bool $active = false, 
        ?string $icon = null,
        ?string $badge = null,
        bool $external = false
    ) {
        $this->href = $href;
        $this->active = $active;
        $this->icon = $icon;
        $this->badge = $badge;
        $this->external = $external;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.layout.nav-link');
    }
    
    /**
     * Get active classes.
     */
    public function activeClasses(): string
    {
        return $this->active
            ? 'bg-accent/10 text-accent'
            : 'text-text-secondary hover:bg-light-surface dark:hover:bg-dark-surface hover:text-text-primary dark:hover:text-text-dark-primary';
    }
    
    /**
     * Get target attribute.
     */
    public function target(): ?string
    {
        return $this->external ? '_blank' : null;
    }
    
    /**
     * Get rel attribute.
     */
    public function rel(): ?string
    {
        return $this->external ? 'noopener noreferrer' : null;
    }
}