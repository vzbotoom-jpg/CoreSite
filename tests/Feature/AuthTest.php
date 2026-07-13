<?php
// tests/Feature/AuthTest.php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }
    
    /** @test */
    public function test_user_can_register_new_store()
    {
        $response = $this->post('/register', [
            'store_name' => 'Toko Test',
            'name' => 'Admin Test',
            'email' => 'admin@test.com',
            'phone' => '08123456789',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        $response->assertRedirect();
        
        $this->assertDatabaseHas('stores', [
            'name' => 'Toko Test',
            'email' => 'admin@test.com',
        ]);
        
        $this->assertDatabaseHas('users', [
            'email' => 'admin@test.com',
            'role' => 'admin',
        ]);
    }
    
    /** @test */
    public function test_registration_fails_with_duplicate_email()
    {
        // Create existing store
        Store::factory()->create(['email' => 'existing@test.com']);
        User::factory()->create(['email' => 'existing@test.com']);
        
        $response = $this->post('/register', [
            'store_name' => 'Toko Test',
            'name' => 'Admin Test',
            'email' => 'existing@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        
        $response->assertSessionHasErrors('email');
    }
    
    /** @test */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);
        
        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticated();
    }
    
    /** @test */
    public function test_user_cannot_login_with_wrong_password()
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'wrongpassword',
        ]);
        
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    
    /** @test */
    public function test_user_cannot_login_when_account_inactive()
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
            'is_active' => false,
        ]);
        
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);
        
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    
    /** @test */
    public function test_user_cannot_login_when_store_inactive()
    {
        $store = Store::factory()->create(['is_active' => false]);
        $user = User::factory()->admin()->create([
            'store_id' => $store->id,
            'email' => 'admin@test.com',
            'password' => Hash::make('password123'),
        ]);
        
        $response = $this->post('/login', [
            'email' => 'admin@test.com',
            'password' => 'password123',
        ]);
        
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }
    
    /** @test */
    public function test_user_can_logout()
    {
        $user = User::factory()->admin()->create();
        
        $response = $this->actingAs($user)->post('/logout');
        
        $response->assertRedirect('/');
        $this->assertGuest();
    }
    
    /** @test */
    public function test_user_can_request_password_reset()
    {
        $user = User::factory()->admin()->create([
            'email' => 'admin@test.com',
        ]);
        
        $response = $this->post('/forgot-password', [
            'email' => 'admin@test.com',
        ]);
        
        $response->assertSessionHas('status');
    }
}