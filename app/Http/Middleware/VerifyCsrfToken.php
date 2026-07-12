<?php
// app/Http/Middleware/VerifyCsrfToken.php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        'api/*',
        'webhook/*',
        'payment/callback/*',
        'payment/notification/*',
        'admin/transactions/*/quick-sale', // For quick sale forms
    ];
    
    /**
     * Determine if the request has a valid CSRF token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function tokensMatch($request)
    {
        // For AJAX requests, check header
        if ($request->ajax() || $request->expectsJson()) {
            $token = $request->header('X-CSRF-TOKEN');
            if ($token && $token === $request->session()->token()) {
                return true;
            }
        }
        
        return parent::tokensMatch($request);
    }
}