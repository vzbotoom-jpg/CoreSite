<?php
// app/Models/Subscriber.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Subscriber extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'email',
        'name',
        'is_verified',
        'verified_at',
        'is_active',
        'unsubscribed_at',
        'ip_address',
        'user_agent',
        'source',
        'preferences',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_verified' => 'boolean',
        'is_active' => 'boolean',
        'verified_at' => 'datetime',
        'unsubscribed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'preferences' => 'array',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'ip_address',
        'user_agent',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'status',
        'is_subscribed',
        'verified_status',
        'subscribed_since',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($subscriber) {
            if (empty($subscriber->verification_token)) {
                $subscriber->verification_token = Str::random(64);
            }
        });
    }

    // ==================== RELATIONSHIPS ====================

    /**
     * Get the store that owns the subscriber.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the user associated with the subscriber.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // ==================== SCOPES ====================

    /**
     * Scope for active subscribers.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for verified subscribers.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified', true);
    }

    /**
     * Scope for unverified subscribers.
     */
    public function scopeUnverified($query)
    {
        return $query->where('is_verified', false);
    }

    /**
     * Scope for subscribers by store.
     */
    public function scopeForStore($query, $storeId)
    {
        return $query->where('store_id', $storeId);
    }

    /**
     * Scope for subscribers created today.
     */
    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    /**
     * Scope for subscribers created this week.
     */
    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    /**
     * Scope for subscribers created this month.
     */
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year);
    }

    /**
     * Scope for search.
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('email', 'like', "%{$search}%")
            ->orWhere('name', 'like', "%{$search}%");
    }

    /**
     * Scope for subscribers by source.
     */
    public function scopeFromSource($query, $source)
    {
        return $query->where('source', $source);
    }

    // ==================== ATTRIBUTES ====================

    /**
     * Get subscriber status.
     */
    public function getStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'unsubscribed';
        }

        if (!$this->is_verified) {
            return 'pending';
        }

        return 'active';
    }

    /**
     * Get is_subscribed attribute.
     */
    public function getIsSubscribedAttribute(): bool
    {
        return $this->is_active && $this->is_verified;
    }

    /**
     * Get verified status label.
     */
    public function getVerifiedStatusAttribute(): string
    {
        if ($this->is_verified && $this->verified_at) {
            return 'Verified';
        }

        if ($this->is_verified && !$this->verified_at) {
            return 'Pending Verification';
        }

        return 'Unverified';
    }

    /**
     * Get subscribed since.
     */
    public function getSubscribedSinceAttribute(): string
    {
        return $this->created_at->format('d M Y');
    }

    /**
     * Get verification link.
     */
    public function getVerificationLinkAttribute(): string
    {
        return route('blog.verify-subscriber', $this->verification_token);
    }

    /**
     * Get unsubscribe link.
     */
    public function getUnsubscribeLinkAttribute(): string
    {
        return route('blog.unsubscribe', ['token' => $this->verification_token, 'email' => $this->email]);
    }

    // ==================== METHODS ====================

    /**
     * Verify the subscriber.
     */
    public function verify(): bool
    {
        $this->is_verified = true;
        $this->verified_at = now();
        $this->is_active = true;
        
        return $this->save();
    }

    /**
     * Unsubscribe the subscriber.
     */
    public function unsubscribe(): bool
    {
        $this->is_active = false;
        $this->unsubscribed_at = now();
        
        return $this->save();
    }

    /**
     * Resubscribe the subscriber.
     */
    public function resubscribe(): bool
    {
        $this->is_active = true;
        $this->unsubscribed_at = null;
        
        return $this->save();
    }

    /**
     * Generate new verification token.
     */
    public function regenerateToken(): string
    {
        $this->verification_token = Str::random(64);
        $this->save();
        
        return $this->verification_token;
    }

    /**
     * Check if subscriber can receive emails.
     */
    public function canReceiveEmails(): bool
    {
        return $this->is_active && $this->is_verified;
    }

    /**
     * Update preferences.
     */
    public function updatePreferences(array $preferences): bool
    {
        $this->preferences = array_merge($this->preferences ?? [], $preferences);
        
        return $this->save();
    }

    /**
     * Get subscriber for API response.
     */
    public function toApiResponse(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'name' => $this->name,
            'status' => $this->status,
            'is_verified' => $this->is_verified,
            'is_active' => $this->is_active,
            'subscribed_since' => $this->subscribed_since,
            'preferences' => $this->preferences,
            'source' => $this->source,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * Get subscriber statistics.
     */
    public static function getStats($storeId = null): array
    {
        $query = self::query();
        
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        
        return [
            'total' => $query->count(),
            'active' => $query->active()->count(),
            'verified' => $query->verified()->count(),
            'unverified' => $query->unverified()->count(),
            'today' => $query->today()->count(),
            'this_week' => $query->thisWeek()->count(),
            'this_month' => $query->thisMonth()->count(),
        ];
    }

    /**
     * Create a new subscriber with validation.
     */
    public static function createSubscriber(array $data): self
    {
        // Check if already exists
        $existing = self::where('email', $data['email'])->first();
        
        if ($existing) {
            // If unsubscribed, resubscribe
            if (!$existing->is_active) {
                $existing->resubscribe();
                return $existing;
            }
            
            // If already active, return existing
            return $existing;
        }
        
        // Create new subscriber
        return self::create($data);
    }

    /**
     * Get subscribers by status.
     */
    public static function getByStatus($status, $limit = 10)
    {
        $query = self::query();
        
        switch ($status) {
            case 'active':
                $query->active()->verified();
                break;
            case 'pending':
                $query->active()->unverified();
                break;
            case 'unsubscribed':
                $query->where('is_active', false);
                break;
            default:
                $query->active();
        }
        
        return $query->orderBy('created_at', 'desc')->limit($limit)->get();
    }

    /**
     * Get subscriber growth data for chart.
     */
    public static function getGrowthData($days = 30, $storeId = null): array
    {
        $query = self::query();
        
        if ($storeId) {
            $query->where('store_id', $storeId);
        }
        
        $data = [];
        $startDate = now()->subDays($days);
        
        for ($i = 0; $i <= $days; $i++) {
            $date = $startDate->copy()->addDays($i);
            $count = $query->whereDate('created_at', $date->toDateString())->count();
            
            $data[] = [
                'date' => $date->format('Y-m-d'),
                'label' => $date->format('d M'),
                'count' => $count,
                'cumulative' => self::whereDate('created_at', '<=', $date->toDateString())
                    ->when($storeId, function ($q) use ($storeId) {
                        return $q->where('store_id', $storeId);
                    })
                    ->count(),
            ];
        }
        
        return $data;
    }

    /**
     * Send verification email.
     */
    public function sendVerificationEmail(): bool
    {
        // Implement with Mail facade
        // Mail::to($this->email)->send(new VerifySubscriberMail($this));
        return true;
    }

    /**
     * Send welcome email.
     */
    public function sendWelcomeEmail(): bool
    {
        // Implement with Mail facade
        // Mail::to($this->email)->send(new WelcomeSubscriberMail($this));
        return true;
    }

    /**
     * Send newsletter.
     */
    public function sendNewsletter($subject, $content): bool
    {
        // Implement with Mail facade
        // Mail::to($this->email)->send(new NewsletterMail($this, $subject, $content));
        return true;
    }
}