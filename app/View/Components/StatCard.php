<?php
// app/View/Components/StatCard.php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class StatCard extends Component
{
    /**
     * Card title.
     */
    public string $title;
    
    /**
     * Card value.
     */
    public string $value;
    
    /**
     * Trend percentage.
     */
    public ?string $trend;
    
    /**
     * Trend direction (up/down/flat).
     */
    public string $trendDirection;
    
    /**
     * Icon name.
     */
    public ?string $icon;
    
    /**
     * Icon color.
     */
    public string $iconColor;
    
    /**
     * Create a new component instance.
     */
    public function __construct(
        string $title,
        string $value,
        ?string $trend = null,
        string $trendDirection = 'flat',
        ?string $icon = null,
        string $iconColor = 'accent'
    ) {
        $this->title = $title;
        $this->value = $value;
        $this->trend = $trend;
        $this->trendDirection = $trendDirection;
        $this->icon = $icon;
        $this->iconColor = $iconColor;
    }
    
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.ui.stat-card');
    }
    
    /**
     * Get trend icon.
     */
    public function trendIcon(): string
    {
        return match($this->trendDirection) {
            'up' => 'trending-up',
            'down' => 'trending-down',
            default => 'trending-flat'
        };
    }
    
    /**
     * Get trend color.
     */
    public function trendColor(): string
    {
        return match($this->trendDirection) {
            'up' => 'text-success',
            'down' => 'text-error',
            default => 'text-text-secondary'
        };
    }
    
    /**
     * Get formatted trend text.
     */
    public function formattedTrend(): ?string
    {
        if (!$this->trend) {
            return null;
        }
        
        $sign = $this->trendDirection === 'up' ? '+' : ($this->trendDirection === 'down' ? '-' : '');
        return $sign . $this->trend;
    }
}