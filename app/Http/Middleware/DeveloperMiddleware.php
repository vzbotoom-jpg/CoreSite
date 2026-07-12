<?php
// app/Http/Middleware/DeveloperMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeveloperMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();
        
        if (!$user) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated'
                ], 401);
            }
            return redirect()->route('login');
        }
        
        if (!$user->isDeveloper()) {
            abort(403, 'Access denied. Developer only.');
        }
        
        return $next($request);
    }
}