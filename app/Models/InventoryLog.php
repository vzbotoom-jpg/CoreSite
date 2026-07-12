<?php
// app/Models/InventoryLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventoryLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'product_id',
        'transaction_id',
        'type',
        'quantity',
        'old_stock',
        'new_stock',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'old_stock' => 'integer',
        'new_stock' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'type_label',
        'type_icon',
        'type_color'
    ];

    /**
     * Get the store that owns the log.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the product that owns the log.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the transaction that owns the log.
     */
    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    /**
     * Get type label.
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'sale' => 'Penjualan',
            'restock' => 'Restok',
            'adjustment' => 'Penyesuaian',
            'return' => 'Pengembalian',
            default => ucfirst($this->type)
        };
    }

    /**
     * Get type icon.
     */
    public function getTypeIconAttribute(): string
    {
        return match($this->type) {
            'sale' => 'shopping-cart',
            'restock' => 'package-add',
            'adjustment' => 'edit',
            'return' => 'reply',
            default => 'info'
        };
    }

    /**
     * Get type color.
     */
    public function getTypeColorAttribute(): string
    {
        return match($this->type) {
            'sale' => 'accent',
            'restock' => 'success',
            'adjustment' => 'warning',
            'return' => 'info',
            default => 'secondary'
        };
    }

    /**
     * Scope for sales logs.
     */
    public function scopeSales($query)
    {
        return $query->where('type', 'sale');
    }

    /**
     * Scope for restock logs.
     */
    public function scopeRestocks($query)
    {
        return $query->where('type', 'restock');
    }

    /**
     * Scope for today's logs.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Get stock difference.
     */
    public function getDifferenceAttribute(): int
    {
        return $this->new_stock - $this->old_stock;
    }

    /**
     * Get direction (positive or negative).
     */
    public function getDirectionAttribute(): string
    {
        return $this->difference > 0 ? 'increase' : ($this->difference < 0 ? 'decrease' : 'unchanged');
    }
}