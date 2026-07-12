<?php
// app/Console/Commands/CreateStore.php

namespace App\Console\Commands;

use App\Models\Store;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class CreateStore extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:create 
                            {name : Store name}
                            {email : Admin email}
                            {password? : Admin password (auto-generate if not provided)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new store with admin user';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password') ?? Str::random(12);

        try {
            DB::beginTransaction();

            // Generate unique slug
            $slug = $this->generateUniqueSlug($name);

            // Create store
            $store = Store::create([
                'name' => $name,
                'slug' => $slug,
                'email' => $email,
                'is_active' => true,
                'settings' => json_encode([
                    'currency' => 'IDR',
                    'timezone' => 'Asia/Jakarta',
                    'date_format' => 'd-m-Y',
                    'notification_email' => $email
                ])
            ]);

            // Create admin user
            $user = User::create([
                'store_id' => $store->id,
                'name' => $name . ' Admin',
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'email_verified_at' => now()
            ]);

            DB::commit();

            $this->info('✓ Store created successfully!');
            $this->info('Store ID: ' . $store->id);
            $this->info('Store Name: ' . $store->name);
            $this->info('Store Slug: ' . $store->slug);
            $this->info('Store URL: ' . config('app.url') . '/' . $store->slug);
            $this->info('Admin Email: ' . $user->email);
            $this->info('Admin Password: ' . $password);
            $this->warn('Please change the password on first login!');

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('Failed to create store: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Store::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}