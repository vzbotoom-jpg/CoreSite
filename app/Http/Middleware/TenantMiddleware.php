<?php
// app/Http/Middleware/TenantMiddleware.php

namespace App\Http\Middleware;

use App\Models\Store;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;

class TenantMiddleware
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
        // Get slug from route parameter
        $slug = $request->route('slug');
        
        if ($slug) {
            // Try to get store from cache
            $store = Cache::remember("store_slug_{$slug}", 3600, function () use ($slug) {
                return Store::where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
            });
            
            if (!$store) {
                abort(404, 'Store not found');
            }
            
            // Share store data with all views
            View::share('tenant_store', $store);
            
            // Make store available in request
            $request->merge(['tenant_store' => $store]);
            $request->attributes->set('tenant_store', $store);
            
            // Set tenant context for logging
            config(['tenant.id' => $store->id]);
            config(['tenant.name' => $store->name]);
            config(['tenant.slug' => $store->slug]);
        }
        
        return $next($request);
    }
    
    /**
     * Clear tenant cache on store update
     */
    public static function clearCache($slug)
    {
        Cache::forget("store_slug_{$slug}");
    }
}