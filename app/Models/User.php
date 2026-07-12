<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'store_id',
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'email_verified_at',
        'remember_token',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar_url',
        'display_name',
        'is_developer',
        'is_admin',
        'is_staff',
    ];

    /**
     * Get the store that owns the user.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    /**
     * Get the roles for the user.
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    /**
     * Check if user has a specific role.
     */
    public function hasRole($role): bool
    {
        if (is_string($role)) {
            return $this->roles->contains('slug', $role);
        }
        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Check if user has any of the given roles.
     */
    public function hasAnyRole($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
            return false;
        }
        return $this->hasRole($roles);
    }

    /**
     * Check if user has all of the given roles.
     */
    public function hasAllRoles($roles): bool
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (!$this->hasRole($role)) {
                    return false;
                }
            }
            return true;
        }
        return $this->hasRole($roles);
    }

    /**
     * Assign a role to the user.
     */
    public function assignRole($role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->syncWithoutDetaching([$role->id]);
        return $this;
    }

    /**
     * Remove a role from the user.
     */
    public function removeRole($role): self
    {
        if (is_string($role)) {
            $role = Role::where('slug', $role)->firstOrFail();
        }
        $this->roles()->detach($role->id);
        return $this;
    }

    /**
     * Sync user roles.
     */
    public function syncRoles($roles): self
    {
        if (is_array($roles)) {
            $roleIds = Role::whereIn('slug', $roles)->pluck('id')->toArray();
            $this->roles()->sync($roleIds);
        }
        return $this;
    }

    /**
     * Check if user has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Check if user has any of the given permissions.
     */
    public function hasAnyPermission($permissions): bool
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if ($this->hasPermission($permission)) {
                    return true;
                }
            }
            return false;
        }
        return $this->hasPermission($permissions);
    }

    /**
     * Check if user has all of the given permissions.
     */
    public function hasAllPermissions($permissions): bool
    {
        if (is_array($permissions)) {
            foreach ($permissions as $permission) {
                if (!$this->hasPermission($permission)) {
                    return false;
                }
            }
            return true;
        }
        return $this->hasPermission($permissions);
    }

    /**
     * Check if user is developer.
     */
    public function isDeveloper(): bool
    {
        return $this->hasRole('developer') || $this->email === 'developer@coresite.com';
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->hasRole('admin');
    }

    /**
     * Check if user is staff.
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff' || $this->hasRole('staff');
    }

    /**
     * Check if user is super admin.
     */
    public function isSuperAdmin(): bool
    {
        return $this->hasRole('super-admin');
    }

    /**
     * Get user's role names as string.
     */
    public function getRoleNamesAttribute(): string
    {
        return $this->roles->pluck('name')->join(', ');
    }

    /**
     * Get user's role slugs as array.
     */
    public function getRoleSlugsAttribute(): array
    {
        return $this->roles->pluck('slug')->toArray();
    }

    /**
     * Get is_developer attribute.
     */
    public function getIsDeveloperAttribute(): bool
    {
        return $this->isDeveloper();
    }

    /**
     * Get is_admin attribute.
     */
    public function getIsAdminAttribute(): bool
    {
        return $this->isAdmin();
    }

    /**
     * Get is_staff attribute.
     */
    public function getIsStaffAttribute(): bool
    {
        return $this->isStaff();
    }

    /**
     * Scope for admin users.
     */
    public function scopeAdmins($query)
    {
        return $query->where('role', 'admin');
    }

    /**
     * Scope for active users.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for users with specific role.
     */
    public function scopeWithRole($query, $role)
    {
        return $query->whereHas('roles', function ($q) use ($role) {
            $q->where('slug', $role);
        });
    }

    /**
     * Get user avatar URL.
     */
    public function getAvatarUrlAttribute(): string
    {
        return 'https://ui-avatars.com/api/?background=00D27A&color=fff&name=' . urlencode($this->name);
    }

    /**
     * Get user's full name or fallback to email.
     */
    public function getDisplayNameAttribute(): string
    {
        return $this->name ?? explode('@', $this->email)[0];
    }

    /**
     * Update last login timestamp.
     */
    public function updateLastLogin(): self
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
        return $this;
    }

    /**
     * Clear user cache.
     */
    public function clearCache(): void
    {
        Cache::forget("user_{$this->id}_roles");
        Cache::forget("user_{$this->id}_permissions");
    }

    /**
     * Get cached roles.
     */
    public function getCachedRoles()
    {
        return Cache::remember("user_{$this->id}_roles", 3600, function () {
            return $this->roles()->with('permissions')->get();
        });
    }

    /**
     * Get cached permissions.
     */
    public function getCachedPermissions()
    {
        return Cache::remember("user_{$this->id}_permissions", 3600, function () {
            $permissions = collect();
            foreach ($this->getCachedRoles() as $role) {
                $permissions = $permissions->merge($role->permissions);
            }
            return $permissions->unique('id');
        });
    }
}