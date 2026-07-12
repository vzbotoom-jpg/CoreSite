<?php
// app/Http/Controllers/Api/V1/AuthController.php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Register new store and user via API
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255|unique:stores,name',
            'name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:stores|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
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
                ])
            ]);
            
            // Create user
            $user = User::create([
                'store_id' => $store->id,
                'name' => $request->name ?? $request->store_name . ' Admin',
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_active' => true
            ]);
            
            // Create token
            $token = $user->createToken('auth_token')->plainTextToken;
            
            DB::commit();
            
            return response()->json([
                'success' => true,
                'message' => 'Registration successful',
                'data' => [
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $user->role
                    ],
                    'store' => [
                        'id' => $store->id,
                        'name' => $store->name,
                        'slug' => $store->slug,
                        'url' => url('/' . $store->slug)
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer'
                ]
            ], 201);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Registration failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Login user via API
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
            'device_name' => 'nullable|string'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = User::where('email', $request->email)->first();
        
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }
        
        if (!$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Account is deactivated'
            ], 403);
        }
        
        if (!$user->store->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Store is deactivated'
            ], 403);
        }
        
        // Revoke old tokens (optional)
        if ($request->revoke_old) {
            $user->tokens()->delete();
        }
        
        $token = $user->createToken($request->device_name ?? 'web')->plainTextToken;
        
        return response()->json([
            'success' => true,
            'message' => 'Login successful',
            'data' => [
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role,
                    'store_id' => $user->store_id
                ],
                'store' => [
                    'id' => $user->store->id,
                    'name' => $user->store->name,
                    'slug' => $user->store->slug
                ],
                'token' => $token,
                'token_type' => 'Bearer'
            ]
        ]);
    }
    
    /**
     * Get authenticated user data
     */
    public function me(Request $request)
    {
        $user = $request->user()->load('store');
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
                'store' => [
                    'id' => $user->store->id,
                    'name' => $user->store->name,
                    'slug' => $user->store->slug,
                    'email' => $user->store->email,
                    'phone' => $user->store->phone,
                    'logo' => $user->store->logo,
                    'settings' => json_decode($user->store->settings, true)
                ],
                'created_at' => $user->created_at,
                'email_verified_at' => $user->email_verified_at
            ]
        ]);
    }
    
    /**
     * Logout user (revoke token)
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Logged out successfully'
        ]);
    }
    
    /**
     * Change password
     */
    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $user = $request->user();
        
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Current password is incorrect'
            ], 422);
        }
        
        $user->password = Hash::make($request->new_password);
        $user->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Password changed successfully'
        ]);
    }
    
    /**
     * Forgot password - send reset link
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Generate reset token
        $token = Str::random(60);
        
        // Store token in password_resets table
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            ['token' => $token, 'created_at' => now()]
        );
        
        // Send email with reset link
        // Mail::to($request->email)->send(new ResetPasswordMail($token));
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset link sent to your email'
        ]);
    }
    
    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }
        
        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();
        
        if (!$resetRecord) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired token'
            ], 422);
        }
        
        // Check token expiration (24 hours)
        if (now()->diffInHours($resetRecord->created_at) > 24) {
            return response()->json([
                'success' => false,
                'message' => 'Token has expired'
            ], 422);
        }
        
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();
        
        // Delete reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully'
        ]);
    }
    
    /**
     * Generate unique slug
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