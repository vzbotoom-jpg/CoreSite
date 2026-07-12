<?php
// app/View/Components/Alert.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    /**
     * Alert type (success, error, warning, info).
     */
    public string $type;
    
    /**
     * Alert message.
     */
    public string $message;
    
    /**
     * Whether alert is dismissible.
     */
    public bool $dismissible;
    
    /**
     * Alert title.
     */
    public ?string $title;
    
    /**
     * Icon name.
     */
    public ?string $icon;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $type = 'info',
        string $message = '',
        bool $dismissible = true,
        ?string $title = null,
        ?string $icon = null
    ) {
        $this->type = $type;
        $this->message = $message;
        $this->dismissible = $dismissible;
        $this->title = $title;
        $this->icon = $icon;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.ui.alert');
    }
    
    /**
     * Get alert classes.
     */
    public function alertClasses(): string
    {
        return match($this->type) {
            'success' => 'bg-success/10 border-success/20 text-success',
            'error' => 'bg-error/10 border-error/20 text-error',
            'warning' => 'bg-warning/10 border-warning/20 text-warning',
            default => 'bg-info/10 border-info/20 text-info'
        };
    }
    
    /**
     * Get default title.
     */
    public function defaultTitle(): string
    {
        return match($this->type) {
            'success' => 'Berhasil!',
            'error' => 'Error!',
            'warning' => 'Peringatan!',
            default => 'Informasi'
        };
    }
    
    /**
     * Get default icon.
     */
    public function defaultIcon(): string
    {
        return match($this->type) {
            'success' => 'check-circle',
            'error' => 'alert-circle',
            'warning' => 'alert-triangle',
            default => 'info'
        };
    }
    
    /**
     * Get icon name.
     */
    public function getIcon(): string
    {
        return $this->icon ?? $this->defaultIcon();
    }
    
    /**
     * Get title.
     */
    public function getTitle(): string
    {
        return $this->title ?? $this->defaultTitle();
    }
}