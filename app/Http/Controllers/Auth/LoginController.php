<?php
// app/Http/Controllers/Auth/LoginController.php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    /**
     * Show login form
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Attempt to login
        if (Auth::attempt($this->credentials($request), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Check if user account is active
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                throw ValidationException::withMessages([
                    'email' => ['Akun Anda telah dinonaktifkan. Silakan hubungi administrator.'],
                ]);
            }

            // Check if user's store is active
            if (!$user->store || !$user->store->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                throw ValidationException::withMessages([
                    'email' => ['Toko Anda telah dinonaktifkan. Silakan hubungi administrator.'],
                ]);
            }

            // Update last login information
            $this->updateLastLogin($user, $request);

            // Log successful login
            Log::info('User logged in', [
                'user_id' => $user->id,
                'email' => $user->email,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Redirect based on role
            return $this->redirectToDashboard($user);
        }

        // Log failed login attempt
        Log::warning('Failed login attempt', [
            'email' => $request->email,
            'ip' => $request->ip(),
        ]);

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Validate login request
     */
    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember' => 'boolean'
        ]);
    }

    /**
     * Get credentials for login attempt
     */
    protected function credentials(Request $request)
    {
        return $request->only('email', 'password');
    }

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        
        if ($user) {
            Log::info('User logged out', [
                'user_id' => $user->id,
                'email' => $user->email,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    /**
     * Update last login information for user
     */
    protected function updateLastLogin($user, Request $request)
    {
        try {
            $user->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);
        } catch (\Exception $e) {
            // Log error but don't prevent login
            Log::error('Failed to update last login', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Redirect user to appropriate dashboard based on role
     */
    protected function redirectToDashboard($user)
    {
        // Check for developer role first
        if ($user->isDeveloper()) {
            return redirect()->intended(route('developer.dashboard'));
        }

        // Check for admin or staff roles
        if ($user->isAdmin() || $user->isStaff()) {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Default fallback
        return redirect()->intended(route('admin.dashboard'));
    }

    /**
     * Show developer login form (optional)
     */
    public function showDeveloperLoginForm()
    {
        return view('auth.login', ['developer' => true]);
    }

    /**
     * Handle developer login (optional)
     */
    public function developerLogin(Request $request)
    {
        $this->validateLogin($request);

        if (Auth::attempt($this->credentials($request), $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (!$user->isDeveloper()) {
                Auth::logout();
                $request->session()->invalidate();
                throw ValidationException::withMessages([
                    'email' => ['Anda tidak memiliki akses ke dashboard developer.'],
                ]);
            }

            // Update last login
            $this->updateLastLogin($user, $request);

            return redirect()->intended(route('developer.dashboard'));
        }

        throw ValidationException::withMessages([
            'email' => [trans('auth.failed')],
        ]);
    }

    /**
     * Redirect users after login (called by Laravel's built-in auth)
     */
    protected function authenticated(Request $request, $user)
    {
        // Update last login
        $this->updateLastLogin($user, $request);

        // Log successful login
        Log::info('User authenticated via Laravel auth', [
            'user_id' => $user->id,
            'email' => $user->email,
        ]);

        // Redirect based on role
        return $this->redirectToDashboard($user);
    }

    /**
     * Get the post login redirect path.
     */
    protected function redirectTo()
    {
        $user = Auth::user();

        if ($user->isDeveloper()) {
            return route('developer.dashboard');
        }

        if ($user->isAdmin() || $user->isStaff()) {
            return route('admin.dashboard');
        }

        return route('admin.dashboard');
    }

    /**
     * Send the response after the user was authenticated (Laravel 8+)
     */
    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }

        return $request->wantsJson()
                    ? new JsonResponse([], 204)
                    : redirect()->intended($this->redirectPath());
    }

    /**
     * Get the path that users should be redirected to after logout.
     */
    public function logoutRedirectTo()
    {
        return route('landing');
    }
}