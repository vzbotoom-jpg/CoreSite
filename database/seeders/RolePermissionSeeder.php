<?php
// database/seeders/RolePermissionSeeder.php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Create Permissions
        $permissions = [
            // User Management
            ['name' => 'View Users', 'slug' => 'view-users', 'group' => 'users'],
            ['name' => 'Create Users', 'slug' => 'create-users', 'group' => 'users'],
            ['name' => 'Edit Users', 'slug' => 'edit-users', 'group' => 'users'],
            ['name' => 'Delete Users', 'slug' => 'delete-users', 'group' => 'users'],
            
            // Role Management
            ['name' => 'View Roles', 'slug' => 'view-roles', 'group' => 'roles'],
            ['name' => 'Create Roles', 'slug' => 'create-roles', 'group' => 'roles'],
            ['name' => 'Edit Roles', 'slug' => 'edit-roles', 'group' => 'roles'],
            ['name' => 'Delete Roles', 'slug' => 'delete-roles', 'group' => 'roles'],
            
            // Store Management
            ['name' => 'View Stores', 'slug' => 'view-stores', 'group' => 'stores'],
            ['name' => 'Create Stores', 'slug' => 'create-stores', 'group' => 'stores'],
            ['name' => 'Edit Stores', 'slug' => 'edit-stores', 'group' => 'stores'],
            ['name' => 'Delete Stores', 'slug' => 'delete-stores', 'group' => 'stores'],
            
            // Product Management
            ['name' => 'View Products', 'slug' => 'view-products', 'group' => 'products'],
            ['name' => 'Create Products', 'slug' => 'create-products', 'group' => 'products'],
            ['name' => 'Edit Products', 'slug' => 'edit-products', 'group' => 'products'],
            ['name' => 'Delete Products', 'slug' => 'delete-products', 'group' => 'products'],
            
            // Transaction Management
            ['name' => 'View Transactions', 'slug' => 'view-transactions', 'group' => 'transactions'],
            ['name' => 'Create Transactions', 'slug' => 'create-transactions', 'group' => 'transactions'],
            ['name' => 'Cancel Transactions', 'slug' => 'cancel-transactions', 'group' => 'transactions'],
            
            // Report Management
            ['name' => 'View Reports', 'slug' => 'view-reports', 'group' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'export-reports', 'group' => 'reports'],
            
            // Settings
            ['name' => 'View Settings', 'slug' => 'view-settings', 'group' => 'settings'],
            ['name' => 'Edit Settings', 'slug' => 'edit-settings', 'group' => 'settings'],
            
            // System (Developer only)
            ['name' => 'View System', 'slug' => 'view-system', 'group' => 'system'],
            ['name' => 'Manage System', 'slug' => 'manage-system', 'group' => 'system'],
            ['name' => 'View Developer', 'slug' => 'view-developer', 'group' => 'developer'],
            ['name' => 'Manage Developer', 'slug' => 'manage-developer', 'group' => 'developer'],
        ];
        
        foreach ($permissions as $permission) {
            Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                $permission
            );
        }
        
        // Create Roles
        $roles = [
            [
                'name' => 'Developer',
                'slug' => 'developer',
                'description' => 'Super admin with full system access',
                'is_default' => false,
                'permissions' => Permission::all()->pluck('id')->toArray()
            ],
            [
                'name' => 'Super Admin',
                'slug' => 'super-admin',
                'description' => 'Full access to all features',
                'is_default' => false,
                'permissions' => Permission::all()->pluck('id')->toArray()
            ],
            [
                'name' => 'Store Owner',
                'slug' => 'store-owner',
                'description' => 'Can manage their own store',
                'is_default' => true,
                'permissions' => Permission::whereIn('slug', [
                    'view-products', 'create-products', 'edit-products', 'delete-products',
                    'view-transactions', 'create-transactions', 'cancel-transactions',
                    'view-reports', 'export-reports',
                    'view-settings', 'edit-settings'
                ])->pluck('id')->toArray()
            ],
            [
                'name' => 'Staff',
                'slug' => 'staff',
                'description' => 'Limited access',
                'is_default' => true,
                'permissions' => Permission::whereIn('slug', [
                    'view-products', 'view-transactions', 'create-transactions'
                ])->pluck('id')->toArray()
            ],
        ];
        
        foreach ($roles as $roleData) {
            $permissions = $roleData['permissions'];
            unset($roleData['permissions']);
            
            $role = Role::updateOrCreate(
                ['slug' => $roleData['slug']],
                $roleData
            );
            
            $role->permissions()->sync($permissions);
        }
        
        // Assign developer role to specific user (if exists)
        $developer = User::where('email', 'developer@coresite.com')->first();
        if ($developer) {
            $developerRole = Role::where('slug', 'developer')->first();
            if ($developerRole) {
                $developer->roles()->syncWithoutDetaching([$developerRole->id]);
            }
        }
        
        // Assign super admin role to admin user (if exists)
        $admin = User::where('email', 'admin@coresite.com')->first();
        if ($admin) {
            $adminRole = Role::where('slug', 'super-admin')->first();
            if ($adminRole) {
                $admin->roles()->syncWithoutDetaching([$adminRole->id]);
            }
        }
    }
}