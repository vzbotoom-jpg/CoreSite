<?php
// app/Models/Store.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'logo',
        'is_active',
        'settings',
        'deactivated_at',
        'deactivation_reason'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'deactivated_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'logo_url',
        'settings_array'
    ];

    /**
     * Get the store's logo URL.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        
        // Generate placeholder using ui-avatars
        return 'https://ui-avatars.com/api/?background=00D27A&color=fff&name=' . urlencode($this->name);
    }

    /**
     * Get settings as array.
     */
    public function getSettingsArrayAttribute(): array
    {
        return $this->settings ?? [
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'date_format' => 'd-m-Y',
            'notification_email' => $this->email,
            'low_stock_alert_enabled' => true,
            'send_monthly_report' => true,
            'theme' => 'light',
        ];
    }

    /**
     * Get the users for the store.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the products for the store.
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the categories for the store.
     */
    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Get the transactions for the store.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the inventory logs for the store.
     */
    public function inventoryLogs(): HasMany
    {
        return $this->hasMany(InventoryLog::class);
    }

    /**
     * Get the settings for the store.
     */
    public function settings(): HasMany
    {
        return $this->hasMany(Setting::class);
    }

    /**
     * Get a specific setting value.
     */
    public function getSetting(string $key, $default = null)
    {
        $settings = $this->settings_array;
        return $settings[$key] ?? $default;
    }

    /**
     * Set a specific setting value.
     */
    public function setSetting(string $key, $value): self
    {
        $settings = $this->settings_array;
        $settings[$key] = $value;
        $this->settings = $settings;
        return $this;
    }

    /**
     * Scope for active stores.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get store URL.
     */
    public function getUrlAttribute(): string
    {
        return url('/' . $this->slug);
    }

    /**
     * Get admin dashboard URL.
     */
    public function getAdminUrlAttribute(): string
    {
        return route('admin.dashboard');
    }
}