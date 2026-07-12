<?php
// app/Http/Middleware/StoreOwnerMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreOwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        
        // Check if user is authenticated
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                    'error_code' => 'UNAUTHENTICATED'
                ], 401);
            }
            return redirect()->route('login');
        }
        
        // Check if user is admin or store owner
        if ($user->role !== 'admin' && $user->role !== 'staff') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized. Admin access required.',
                    'error_code' => 'FORBIDDEN'
                ], 403);
            }
            abort(403, 'Unauthorized access. Admin only.');
        }
        
        // Check if user account is active
        if (!$user->is_active) {
            Auth::logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your account has been deactivated.',
                    'error_code' => 'ACCOUNT_DEACTIVATED'
                ], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Akun Anda telah dinonaktifkan. Silakan hubungi administrator.');
        }
        
        // Check if store is active
        if (!$user->store->is_active) {
            Auth::logout();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your store has been deactivated.',
                    'error_code' => 'STORE_DEACTIVATED'
                ], 403);
            }
            
            return redirect()->route('login')
                ->with('error', 'Toko Anda telah dinonaktifkan. Silakan hubungi administrator.');
        }
        
        // Store user's store_id in config for easy access
        config(['user.store_id' => $user->store_id]);
        
        return $next($request);
    }
}