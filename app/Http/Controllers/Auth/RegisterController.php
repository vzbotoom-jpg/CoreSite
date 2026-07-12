<?php
// app/Http/Controllers/Auth/RegisterController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the registration form
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Handle registration request
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        try {
            DB::beginTransaction();

            // Generate unique slug
            $slug = $this->generateUniqueSlug($request->store_name);

            // Create store
            $store = Store::create([
                'name' => $request->store_name,
                'slug' => $slug,
                'email' => $request->email,
                'phone' => $request->phone,
                'is_active' => true,
                'settings' => json_encode([
                    'currency' => 'IDR',
                    'timezone' => 'Asia/Jakarta',
                    'date_format' => 'd-m-Y',
                    'notification_email' => $request->email,
                    'low_stock_alert_enabled' => true,
                    'send_monthly_report' => true
                ])
            ]);

            // Create admin user
            $user = User::create([
                'store_id' => $store->id,
                'name' => $request->name ?? $request->store_name . ' Admin',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true
            ]);

            DB::commit();

            // Login the user
            auth()->login($user);

            // Redirect to dashboard with success message
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat! Toko ' . $store->name . ' berhasil dibuat. 
                        URL Toko Anda: ' . url('/' . $store->slug));

        } catch (\Exception $e) {
            DB::rollBack();
            throw ValidationException::withMessages([
                'error' => ['Registrasi gagal: ' . $e->getMessage()]
            ]);
        }
    }

    /**
     * Validate registration input
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'store_name' => ['required', 'string', 'max:255', 'unique:stores,name'],
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:stores', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Generate unique slug for store
     */
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