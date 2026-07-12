<?php
// app/Http/Middleware/Authenticate.php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
            // Check if it's admin route
            if ($request->is('admin/*')) {
                return route('login');
            }
            return route('login');
        }
        
        return null;
    }
    
    /**
     * Custom authentication handling for API requests
     */
    protected function unauthenticated($request, array $guards)
    {
        if ($request->expectsJson()) {
            abort(response()->json([
                'success' => false,
                'message' => 'Unauthenticated. Please login first.',
                'error_code' => 'UNAUTHENTICATED'
            ], 401));
        }
        
        parent::unauthenticated($request, $guards);
    }
}