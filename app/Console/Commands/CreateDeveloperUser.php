<?php
// app/Console/Commands/CreateDeveloperUser.php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\User;
use App\Models\Role;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateDeveloperUser extends Command
{
    protected $signature = 'developer:create {email?} {password?}';
    protected $description = 'Create a developer user';

    public function handle()
    {
        $email = $this->argument('email') ?? 'developer@coresite.com';
        $password = $this->argument('password') ?? 'password';
        
        // Cari atau buat store
        $store = Store::first();
        if (!$store) {
            $store = Store::create([
                'name' => 'CoreSite Developer',
                'slug' => 'developer',
                'email' => $email,
                'is_active' => true,
                'settings' => json_encode(['currency' => 'IDR']),
            ]);
            $this->info('✅ Store created: ' . $store->name);
        }
        
        // Cek apakah user sudah ada
        $existingUser = User::where('email', $email)->first();
        if ($existingUser) {
            $this->error('❌ User with email ' . $email . ' already exists.');
            return;
        }
        
        // Buat user
        $user = User::create([
            'name' => 'Developer',
            'email' => $email,
            'password' => Hash::make($password),
            'store_id' => $store->id,
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);
        
        // Assign role developer
        $role = Role::where('slug', 'developer')->first();
        if ($role) {
            $user->roles()->attach($role);
            $this->info('✅ Developer user created successfully!');
            $this->info('📧 Email: ' . $email);
            $this->info('🔑 Password: ' . $password);
        } else {
            $this->error('❌ Role "developer" not found. Run the RolePermissionSeeder first.');
        }
    }
}