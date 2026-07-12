<?php
// app/Models/Role.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Role extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'slug', 'description', 'is_default'
    ];
    
    protected $casts = [
        'is_default' => 'boolean',
    ];
    
    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($role) {
            if (empty($role->slug)) {
                $role->slug = Str::slug($role->name);
            }
        });
    }
    
    /**
     * Get the users for the role.
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
    
    /**
     * Get the permissions for the role.
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }
    
    /**
     * Check if role has a specific permission.
     */
    public function hasPermission($permission): bool
    {
        if (is_string($permission)) {
            return $this->permissions->contains('slug', $permission);
        }
        return !!$permission->intersect($this->permissions)->count();
    }
    
    /**
     * Check if role has any of the given permissions.
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
     * Check if role has all of the given permissions.
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
     * Assign a permission to the role.
     */
    public function assignPermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }
        $this->permissions()->syncWithoutDetaching([$permission->id]);
        return $this;
    }
    
    /**
     * Remove a permission from the role.
     */
    public function removePermission($permission): self
    {
        if (is_string($permission)) {
            $permission = Permission::where('slug', $permission)->firstOrFail();
        }
        $this->permissions()->detach($permission->id);
        return $this;
    }
    
    /**
     * Sync permissions for the role.
     */
    public function syncPermissions($permissions): self
    {
        if (is_array($permissions)) {
            $permissionIds = Permission::whereIn('slug', $permissions)->pluck('id')->toArray();
            $this->permissions()->sync($permissionIds);
        }
        return $this;
    }
    
    /**
     * Get all permissions as array of slugs.
     */
    public function getPermissionSlugsAttribute(): array
    {
        return $this->permissions->pluck('slug')->toArray();
    }
    
    /**
     * Get user count for the role.
     */
    public function getUserCountAttribute(): int
    {
        return $this->users()->count();
    }
    
    /**
     * Check if role is protected (cannot be deleted).
     */
    public function isProtected(): bool
    {
        return in_array($this->slug, ['developer', 'super-admin', 'store-owner', 'staff']);
    }
    
    /**
     * Scope for default roles.
     */
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }
    
    /**
     * Scope for protected roles.
     */
    public function scopeProtected($query)
    {
        return $query->whereIn('slug', ['developer', 'super-admin', 'store-owner', 'staff']);
    }
}