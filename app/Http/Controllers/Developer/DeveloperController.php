<?php
// app/Http/Controllers/Developer/DeveloperController.php

namespace App\Http\Controllers\Developer;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Store;
use App\Models\ActivityLog;
use App\Models\ScheduledJob;
use App\Models\JobLog;
use App\Models\Transaction;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DeveloperController extends Controller
{
    /**
     * Developer Dashboard
     */
    public function index()
    {
        $stats = $this->getRealStats();
        return view('developer.dashboard', compact('stats'));
    }

    /**
     * Get dashboard statistics for API
     */
    public function getDashboardStats()
    {
        $stats = $this->getRealStats();
        $stats['charts'] = $this->getChartStats();

        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }

    /**
     * Helper to get real, dynamic server and growth stats
     */
    private function getRealStats()
    {
        // Growth calculators
        $thisMonthUsers = User::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $lastMonthUsers = User::whereYear('created_at', now()->subMonth()->year)->whereMonth('created_at', now()->subMonth()->month)->count();
        $userGrowth = $lastMonthUsers > 0 ? round((($thisMonthUsers - $lastMonthUsers) / $lastMonthUsers) * 100, 1) : ($thisMonthUsers > 0 ? 100 : 0);

        $thisMonthStores = Store::whereYear('created_at', now()->year)->whereMonth('created_at', now()->month)->count();
        $lastMonthStores = Store::whereYear('created_at', now()->subMonth()->year)->whereMonth('created_at', now()->subMonth()->month)->count();
        $storeGrowth = $lastMonthStores > 0 ? round((($thisMonthStores - $lastMonthStores) / $lastMonthStores) * 100, 1) : ($thisMonthStores > 0 ? 100 : 0);

        // System resources - real measurements (no hardcoded/fake fallbacks)
        $cpuUsage = null;
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            if (is_array($load) && isset($load[0])) {
                $cores = $this->getCpuCores();
                $cpuUsage = min(100, round(($load[0] / $cores) * 100, 1));
            }
        }
        if ($cpuUsage === null && PHP_OS_FAMILY === 'Windows') {
            $wmicLoad = @shell_exec('wmic cpu get LoadPercentage');
            if ($wmicLoad) {
                preg_match_all('/\d+/', $wmicLoad, $matches);
                if (!empty($matches[0])) {
                    $cpuUsage = (float)$matches[0][0];
                }
            }
        }

$memUsage = null;
        if (PHP_OS_FAMILY === 'Linux') {
            // Prefer reading /proc/meminfo (no shell execution required)
            $meminfo = @file_get_contents('/proc/meminfo');
            if ($meminfo !== false) {
                $lines = explode("\n", $meminfo);
                $memTotal = 0;
                $memAvailable = 0;
                foreach ($lines as $line) {
                    if (preg_match('/^MemTotal:\s+(\d+)/', $line, $matches)) {
                        $memTotal = (int)$matches[1];
                    }
                    if (preg_match('/^MemAvailable:\s+(\d+)/', $line, $matches)) {
                        $memAvailable = (int)$matches[1];
                    }
                }
                if ($memTotal > 0 && $memAvailable > 0) {
                    $memUsage = round((($memTotal - $memAvailable) / $memTotal) * 100, 1);
                }
            }
            if ($memUsage === null) {
                $free = @shell_exec('free');
                if ($free) {
                    $free = (string)trim($free);
                    $free_arr = explode("\n", $free);
                    if (isset($free_arr[1])) {
                        $mem = preg_split("/\s+/", $free_arr[1]);
                        if (isset($mem[1]) && isset($mem[2]) && $mem[1] > 0) {
                            $memUsage = round(($mem[2] / $mem[1]) * 100, 1);
                        }
                    }
                }
            }
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            $vmStat = @shell_exec('vm_stat');
            if ($vmStat) {
                preg_match('/page size of (\d+) bytes/', $vmStat, $sizeMatches);
                $pageSize = isset($sizeMatches[1]) ? (int)$sizeMatches[1] : 4096;
                preg_match('/Pages free:\s+(\d+)/', $vmStat, $freeMatches);
                preg_match('/Pages active:\s+(\d+)/', $vmStat, $activeMatches);
                preg_match('/Pages inactive:\s+(\d+)/', $vmStat, $inactiveMatches);
                preg_match('/Pages wired down:\s+(\d+)/', $vmStat, $wiredMatches);

                if (isset($freeMatches[1], $activeMatches[1], $inactiveMatches[1], $wiredMatches[1])) {
                    $free = (int)$freeMatches[1];
                    $active = (int)$activeMatches[1];
                    $inactive = (int)$inactiveMatches[1];
                    $wired = (int)$wiredMatches[1];

                    $total = $free + $active + $inactive + $wired;
                    $used = $active + $wired;
                    if ($total > 0) {
                        $memUsage = round(($used / $total) * 100, 1);
                    }
                }
            }
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $wmicMem = @shell_exec('wmic OS get FreePhysicalMemory,TotalVisibleMemorySize');
            if ($wmicMem) {
                preg_match_all('/\d+/', $wmicMem, $matches);
                if (isset($matches[0][0]) && isset($matches[0][1])) {
                    $free = (float)$matches[0][0]; // in KB
                    $total = (float)$matches[0][1]; // in KB
                    if ($total > 0) {
                        $memUsage = round((($total - $free) / $total) * 100, 1);
                    }
                }
            }
        }

        $storageUsage = null;
        try {
            $path = base_path();
            $totalSpace = @disk_total_space($path);
            $freeSpace = @disk_free_space($path);
            if ($totalSpace > 0) {
                $storageUsage = round((($totalSpace - $freeSpace) / $totalSpace) * 100, 1);
            }
        } catch (\Exception $e) {}

        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'total_stores' => Store::count(),
            'active_stores' => Store::where('is_active', true)->count(),
            'inactive_stores' => Store::where('is_active', false)->count(),
            'total_roles' => Role::count(),
            'system_roles' => Role::whereIn('slug', ['developer', 'super-admin', 'store-owner', 'staff'])->count(),
            'custom_roles' => Role::whereNotIn('slug', ['developer', 'super-admin', 'store-owner', 'staff'])->count(),
            'total_permissions' => Permission::count(),
            'assigned_permissions' => Permission::has('roles')->count(),
            'unassigned_permissions' => Permission::doesntHave('roles')->count(),
            'today_activity' => ActivityLog::whereDate('created_at', today())->count(),
            'unique_activity_users' => ActivityLog::distinct('user_id')->count(),
            'user_growth' => $userGrowth,
            'store_growth' => $storeGrowth,
            'cpu_usage' => $cpuUsage,
            'memory_usage' => $memUsage,
            'storage_usage' => $storageUsage,
            'health' => $this->getSystemHealthStatus(),
            'version' => $this->getAppVersion(),
        ];
    }

    /**
     * Run real, dynamic health checks for Database, Cache, and Storage
     */
    private function getSystemHealthStatus(): array
    {
        $dbConnected = false;
        try {
            DB::connection()->getPdo();
            $dbConnected = true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Database health check failed: ' . $e->getMessage());
        }

        $cacheConnected = false;
        try {
            \Illuminate\Support\Facades\Cache::put('health_check', true, 10);
            $cacheConnected = \Illuminate\Support\Facades\Cache::get('health_check') === true;
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Cache health check failed: ' . $e->getMessage());
        }

        $storageWritable = false;
        try {
            $storageWritable = \Illuminate\Support\Facades\Storage::put('health_check.txt', 'ok');
            if ($storageWritable) {
                \Illuminate\Support\Facades\Storage::delete('health_check.txt');
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Storage health check failed: ' . $e->getMessage());
        }

        // Determine if system is completely online
        $systemOnline = $dbConnected && $storageWritable;

        return [
            'db_connected' => $dbConnected,
            'cache_connected' => $cacheConnected,
            'storage_writable' => $storageWritable,
            'system_online' => $systemOnline,
        ];
    }

    /**
     * Get real application version dynamically
     */
    private function getAppVersion(): string
    {
        $version = config('app.version');
        if ($version) {
            return $version;
        }

        if (PHP_OS_FAMILY !== 'Windows' && function_exists('shell_exec')) {
            $gitVersion = @shell_exec('git describe --tags --always 2>/dev/null');
            if ($gitVersion) {
                return trim($gitVersion);
            }
            $gitCommit = @shell_exec('git rev-parse --short HEAD 2>/dev/null');
            if ($gitCommit) {
                return 'git-' . trim($gitCommit);
            }
        }

        $composerPath = base_path('composer.json');
        if (File::exists($composerPath)) {
            $composer = json_decode(File::get($composerPath), true);
            if (isset($composer['version'])) {
                return $composer['version'];
            }
        }

        return '1.0.0';
    }

    /**
     * Get actual number of CPU cores
     */
    private function getCpuCores(): int
    {
        if (PHP_OS_FAMILY === 'Linux') {
            $cpuinfo = @file_get_contents('/proc/cpuinfo');
            if ($cpuinfo !== false) {
                preg_match_all('/^processor/m', $cpuinfo, $matches);
                if (!empty($matches[0])) {
                    return max(1, count($matches[0]));
                }
            }
            $nproc = @shell_exec('nproc');
            if ($nproc && is_numeric(trim($nproc))) {
                return max(1, (int)trim($nproc));
            }
        } elseif (PHP_OS_FAMILY === 'Darwin') {
            $cores = @shell_exec('sysctl -n hw.ncpu');
            if ($cores && is_numeric(trim($cores))) {
                return max(1, (int)trim($cores));
            }
        } elseif (PHP_OS_FAMILY === 'Windows') {
            $cores = @shell_exec('wmic cpu get NumberOfCores');
            if ($cores) {
                preg_match_all('/\d+/', $cores, $matches);
                if (!empty($matches[0])) {
                    return max(1, (int)$matches[0][0]);
                }
            }
        }
        return 1;
    }

    /**
     * Helper to get real chart stats
     */
    private function getChartStats()
    {
        // 1. Week (Last 7 Days)
        $weekLabels = [];
        $weekUserValues = [];
        $weekRevenueValues = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $weekLabels[] = $date->format('D');

            $weekUserValues[] = User::whereDate('created_at', $date->toDateString())->count();

            $weekRevenueValues[] = (float)Transaction::where('status', 'completed')
                ->whereDate('transaction_date', $date->toDateString())
                ->sum('total_amount');
        }

        // 2. Month (Last 4 Weeks)
        $monthLabels = ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        $monthUserValues = [];
        $monthRevenueValues = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();

            $monthUserValues[] = User::whereBetween('created_at', [$start, $end])->count();

            $monthRevenueValues[] = (float)Transaction::where('status', 'completed')
                ->whereBetween('transaction_date', [$start, $end])
                ->sum('total_amount');
        }

        // 3. Year (Last 12 Months)
        $yearLabels = [];
        $yearUserValues = [];
        $yearRevenueValues = [];
        for ($i = 11; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $yearLabels[] = $month->format('M');

            $yearUserValues[] = User::whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->count();

            $yearRevenueValues[] = (float)Transaction::where('status', 'completed')
                ->whereYear('transaction_date', $month->year)
                ->whereMonth('transaction_date', $month->month)
                ->sum('total_amount');
        }

        return [
            'user' => [
                'week' => ['labels' => $weekLabels, 'values' => $weekUserValues],
                'month' => ['labels' => $monthLabels, 'values' => $monthUserValues],
                'year' => ['labels' => $yearLabels, 'values' => $yearUserValues],
            ],
            'revenue' => [
                'week' => ['labels' => $weekLabels, 'values' => $weekRevenueValues],
                'month' => ['labels' => $monthLabels, 'values' => $monthRevenueValues],
                'year' => ['labels' => $yearLabels, 'values' => $yearRevenueValues],
            ]
        ];
    }
    
    // ==================== USER MANAGEMENT ====================
    
    /**
     * User Management
     */
    public function users()
    {
        $users = User::with('store', 'roles')->paginate(20);
        $roles = Role::all();
        $stores = Store::all();
        
        return view('developer.users.index', compact('users', 'roles', 'stores'));
    }
    
    /**
     * Get users data for API
     */
    public function getUsersData(Request $request)
    {
        $query = User::with('store', 'roles');
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        if ($request->filled('role')) {
            $query->whereHas('roles', function($q) use ($request) {
                $q->where('slug', $request->role);
            });
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        if ($request->filled('store')) {
            $query->where('store_id', $request->store);
        }
        
        $users = $query->paginate(20);
        
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admins' => User::where('role', 'admin')->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $users,
            'stats' => $stats
        ]);
    }
    
    /**
     * Show form to create new user
     */
    public function createUser()
    {
        $roles = Role::all();
        $stores = Store::all();
        return view('developer.users.create', compact('roles', 'stores'));
    }
    
    /**
     * Create User
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'store_id' => 'required|exists:stores,id',
            'roles' => 'array',
        ]);
        
        DB::beginTransaction();
        
        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'store_id' => $validated['store_id'],
                'is_active' => true,
                'email_verified_at' => now(),
            ]);
            
            if (!empty($validated['roles'])) {
                $user->roles()->sync($validated['roles']);
            }
            
            // Log activity
            ActivityLog::log('create', 'User created: ' . $user->name, ['user' => $user]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil ditambahkan',
                    'data' => $user
                ]);
            }
            
            return redirect()->route('developer.users.index')
                ->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan user: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menambahkan user: ' . $e->getMessage());
        }
    }
    
    /**
     * Show user detail
     */
    public function showUser($id)
    {
        $user = User::with(['store', 'roles'])->findOrFail($id);
        return view('developer.users.show', compact('user'));
    }
    
    /**
     * Show form to edit user
     */
    public function editUser($id)
    {
        $user = User::with('roles')->findOrFail($id);
        $roles = Role::all();
        $stores = Store::all();
        return view('developer.users.edit', compact('user', 'roles', 'stores'));
    }
    
    /**
     * Update User
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'store_id' => 'required|exists:stores,id',
            'is_active' => 'boolean',
            'roles' => 'array',
        ]);
        
        DB::beginTransaction();
        
        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'store_id' => $validated['store_id'],
                'is_active' => $validated['is_active'] ?? $user->is_active,
            ]);
            
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
                $user->save();
            }
            
            $user->roles()->sync($validated['roles'] ?? []);
            
            // Log activity
            ActivityLog::log('update', 'User updated: ' . $user->name, ['user' => $user]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil diupdate',
                    'data' => $user
                ]);
            }
            
            return redirect()->route('developer.users.index')
                ->with('success', 'User berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengupdate user: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal mengupdate user: ' . $e->getMessage());
        }
    }
    
    /**
     * Toggle User Status
     */
    public function toggleUserStatus($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = !$user->is_active;
        $user->save();
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        // Log activity
        ActivityLog::log('status_change', 'User ' . $status . ': ' . $user->name, ['user' => $user]);
        
        return response()->json([
            'success' => true,
            'message' => "User berhasil {$status}"
        ]);
    }
    
    /**
     * Reset user password
     */
    public function resetUserPassword($id)
    {
        $user = User::findOrFail($id);
        $newPassword = Str::random(10);
        
        $user->password = Hash::make($newPassword);
        $user->save();
        
        // Log activity
        ActivityLog::log('update', 'Password reset for user: ' . $user->name, ['user' => $user]);
        
        return response()->json([
            'success' => true,
            'message' => 'Password reset berhasil',
            'password' => $newPassword
        ]);
    }
    
    /**
     * Send verification email
     */
    public function sendUserVerification($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'message' => 'User already verified'
            ]);
        }
        
        $user->sendEmailVerificationNotification();
        
        return response()->json([
            'success' => true,
            'message' => 'Verification email sent'
        ]);
    }
    
    /**
     * Delete User
     */
    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->isDeveloper()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus user developer'
            ], 403);
        }
        
        // Log activity
        ActivityLog::log('delete', 'User deleted: ' . $user->name, ['user' => $user]);
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User berhasil dihapus'
        ]);
    }
    
    /**
     * Assign roles to user
     */
    public function assignUserRoles(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $roles = $request->input('roles', []);
        
        $user->roles()->sync($roles);
        
        // Log activity
        ActivityLog::log('role_change', 'Roles assigned to user: ' . $user->name, ['roles' => $roles]);
        
        return response()->json([
            'success' => true,
            'message' => 'Roles assigned successfully'
        ]);
    }
    
    // ==================== ROLE MANAGEMENT ====================
    
    /**
     * Role Management
     */
    public function roles()
    {
        $roles = Role::with('permissions', 'users')->get();
        $permissions = Permission::all()->groupBy('group');
        $allPermissions = Permission::all();
        
        return view('developer.roles.index', compact('roles', 'permissions', 'allPermissions'));
    }
    
    /**
     * Get roles data for API
     */
    public function getRolesData(Request $request)
    {
        $query = Role::with('permissions', 'users')->withCount('users');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%');
            });
        }
        
        if ($request->filled('type')) {
            if ($request->type === 'system') {
                $query->whereIn('slug', ['developer', 'super-admin', 'store-owner', 'staff']);
            } else {
                $query->whereNotIn('slug', ['developer', 'super-admin', 'store-owner', 'staff']);
            }
        }
        
        if ($request->filled('permission')) {
            $query->whereHas('permissions', function($q) use ($request) {
                $q->where('id', $request->permission);
            });
        }
        
        $roles = $query->get();
        
        $stats = [
            'total' => Role::count(),
            'system' => Role::whereIn('slug', ['developer', 'super-admin', 'store-owner', 'staff'])->count(),
            'custom' => Role::whereNotIn('slug', ['developer', 'super-admin', 'store-owner', 'staff'])->count(),
            'permissions' => Permission::count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $roles,
            'stats' => $stats
        ]);
    }
    
    /**
     * Show form to create new role
     */
    public function createRole()
    {
        $permissions = Permission::all();
        return view('developer.roles.create', compact('permissions'));
    }
    
    /**
     * Create Role
     */
    public function storeRole(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:roles,slug',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'is_default' => 'boolean',
        ]);
        
        DB::beginTransaction();
        
        try {
            $role = Role::create([
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'description' => $validated['description'] ?? null,
                'is_default' => $validated['is_default'] ?? false,
            ]);
            
            if (!empty($validated['permissions'])) {
                $role->permissions()->sync($validated['permissions']);
            }
            
            // Log activity
            ActivityLog::log('create', 'Role created: ' . $role->name, ['role' => $role]);
            
            DB::commit();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Role berhasil ditambahkan',
                    'data' => $role
                ]);
            }
            
            return redirect()->route('developer.roles.index')
                ->with('success', 'Role berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan role: ' . $e->getMessage()
                ], 500);
            }
            
            return back()->with('error', 'Gagal menambahkan role: ' . $e->getMessage());
        }
    }
    
    /**
     * Show role detail
     */
    public function showRole($id)
    {
        $role = Role::with(['permissions', 'users' => function($q) {
            $q->select('users.id', 'users.name', 'users.email', 'users.is_active');
        }])->withCount('users')->findOrFail($id);

        if (request()->expectsJson() || request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'success' => true,
                'data' => $role
            ]);
        }
        return view('developer.roles.show', compact('role', 'id'));
    }
    
    /**
     * Show form to edit role
     */
    public function editRole($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        $permissions = Permission::all();
        return view('developer.roles.edit', compact('role', 'permissions'));
    }
    
    /**
     * Update Role
     */
    public function updateRole(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'permissions' => 'array',
            'is_default' => 'boolean',
        ]);
        
        $role->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'is_default' => $validated['is_default'] ?? false,
        ]);
        
        $role->permissions()->sync($validated['permissions'] ?? []);
        
        // Log activity
        ActivityLog::log('update', 'Role updated: ' . $role->name, ['role' => $role]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Role berhasil diupdate',
                'data' => $role
            ]);
        }
        
        return redirect()->route('developer.roles.index')
            ->with('success', 'Role berhasil diupdate');
    }
    
    /**
     * Sync Role Permissions
     */
    public function syncRolePermissions(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $permissions = $request->input('permissions', []);
        
        $role->permissions()->sync($permissions);
        
        // Log activity
        ActivityLog::log('permission_change', 'Permissions synced for role: ' . $role->name, ['permissions' => $permissions]);
        
        return response()->json([
            'success' => true,
            'message' => 'Permissions synced successfully'
        ]);
    }
    
    /**
     * Delete Role
     */
    public function deleteRole($id)
    {
        $role = Role::findOrFail($id);
        
        if ($role->slug === 'developer') {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus system role developer'
            ], 403);
        }

        if ($role->users()->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak dapat menghapus role yang sedang digunakan oleh pengguna aktif'
            ], 403);
        }
        
        // Log activity
        ActivityLog::log('delete', 'Role deleted: ' . $role->name, ['role' => $role]);
        
        $role->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Role berhasil dihapus'
        ]);
    }
    
    /**
     * Assign users to role
     */
    public function assignRoleUsers(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $users = $request->input('users', []);
        
        $role->users()->sync($users);
        
        // Log activity
        ActivityLog::log('role_change', 'Users assigned to role: ' . $role->name, ['users' => $users]);
        
        return response()->json([
            'success' => true,
            'message' => 'Users assigned successfully'
        ]);
    }
    
    // ==================== PERMISSION MANAGEMENT ====================
    
    /**
     * Permission Management
     */
    public function permissions()
    {
        $permissions = Permission::with('roles')->paginate(20);
        $groups = Permission::select('group')->distinct()->get();
        $allPermissions = Permission::all();
        
        return view('developer.permissions.index', compact('permissions', 'groups', 'allPermissions'));
    }
    
    /**
     * Get permissions data for API
     */
    public function getPermissionsData(Request $request)
    {
        $query = Permission::with('roles');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('slug', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('group')) {
            $query->where('group', $request->group);
        }
        
        if ($request->filled('status')) {
            if ($request->status === 'assigned') {
                $query->has('roles');
            } else {
                $query->doesntHave('roles');
            }
        }
        
        $permissions = $query->get();
        $groups = Permission::select('group')->distinct()->pluck('group')->filter()->values();
        
        $stats = [
            'total' => Permission::count(),
            'groups' => $groups->count(),
            'assigned' => Permission::has('roles')->count(),
            'unassigned' => Permission::doesntHave('roles')->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $permissions,
            'all' => Permission::all(),
            'groups' => $groups,
            'stats' => $stats
        ]);
    }
    
    /**
     * Show form to create new permission
     */
    public function createPermission()
    {
        return view('developer.permissions.create');
    }
    
    /**
     * Create Permission
     */
    public function storePermission(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:permissions,slug',
            'group' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        $permission = Permission::create($validated);
        
        // Log activity
        ActivityLog::log('create', 'Permission created: ' . $permission->name, ['permission' => $permission]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission berhasil ditambahkan',
                'data' => $permission
            ]);
        }
        
        return redirect()->route('developer.permissions.index')
            ->with('success', 'Permission berhasil ditambahkan');
    }
    
    /**
     * Show permission detail
     */
    public function showPermission($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);
        return view('developer.permissions.show', compact('permission'));
    }
    
    /**
     * Show form to edit permission
     */
    public function editPermission($id)
    {
        $permission = Permission::with('roles')->findOrFail($id);
        return view('developer.permissions.edit', compact('permission'));
    }
    
    /**
     * Update Permission
     */
    public function updatePermission(Request $request, $id)
    {
        $permission = Permission::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'group' => 'nullable|string',
            'description' => 'nullable|string',
        ]);
        
        $permission->update($validated);
        
        // Log activity
        ActivityLog::log('update', 'Permission updated: ' . $permission->name, ['permission' => $permission]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Permission berhasil diupdate',
                'data' => $permission
            ]);
        }
        
        return redirect()->route('developer.permissions.index')
            ->with('success', 'Permission berhasil diupdate');
    }
    
    /**
     * Delete Permission
     */
    public function deletePermission($id)
    {
        $permission = Permission::findOrFail($id);
        
        // Log activity
        ActivityLog::log('delete', 'Permission deleted: ' . $permission->name, ['permission' => $permission]);
        
        $permission->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Permission berhasil dihapus'
        ]);
    }
    
    /**
     * Create Permission Group
     */
    public function createPermissionGroup(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);
        
        foreach ($validated['permissions'] as $permissionId) {
            $permission = Permission::find($permissionId);
            if ($permission) {
                $permission->group = $validated['name'];
                $permission->save();
            }
        }
        
        // Log activity
        ActivityLog::log('update', 'Permission group created: ' . $validated['name'], ['group' => $validated]);
        
        return response()->json([
            'success' => true,
            'message' => 'Permission group berhasil dibuat'
        ]);
    }
    
    /**
     * Get permission groups
     */
    public function getPermissionGroups()
    {
        $groups = Permission::select('group')->distinct()->pluck('group')->filter()->values();
        
        return response()->json([
            'success' => true,
            'data' => $groups
        ]);
    }
    
    // ==================== STORE MANAGEMENT ====================
    
    /**
     * Store Management
     */
    public function stores()
    {
        $stores = Store::with('users')->paginate(20);
        return view('developer.stores.index', compact('stores'));
    }
    
    /**
     * Get stores data for API
     */
    public function getStoresData(Request $request)
    {
        $query = Store::withCount(['users', 'products']);
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'oldest':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'name':
                    $query->orderBy('name', 'asc');
                    break;
                case 'users':
                    $query->orderBy('users_count', 'desc');
                    break;
                default:
                    $query->orderBy('created_at', 'desc');
            }
        }
        
        $stores = $query->paginate(20);
        
        $stats = [
            'total' => Store::count(),
            'active' => Store::where('is_active', true)->count(),
            'inactive' => Store::where('is_active', false)->count(),
            'users' => User::count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stores,
            'stats' => $stats
        ]);
    }
    
    /**
     * Show form to create new store
     */
    public function createStore()
    {
        return view('developer.stores.create');
    }
    
    /**
     * Create Store
     */
    public function storeStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|unique:stores,slug',
            'email' => 'required|email|unique:stores,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $store = Store::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'is_active' => $validated['is_active'] ?? true,
        ]);
        
        // Log activity
        ActivityLog::log('create', 'Store created: ' . $store->name, ['store' => $store]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Store berhasil ditambahkan',
                'data' => $store
            ]);
        }
        
        return redirect()->route('developer.stores.index')
            ->with('success', 'Store berhasil ditambahkan');
    }
    
    /**
     * Show store detail
     */
    public function showStore($id)
    {
        $store = Store::with(['users', 'products'])->findOrFail($id);
        return view('developer.stores.show', compact('store'));
    }
    
    /**
     * Show form to edit store
     */
    public function editStore($id)
    {
        $store = Store::with(['users', 'products'])->findOrFail($id);
        return view('developer.stores.edit', compact('store'));
    }
    
    /**
     * Update Store
     */
    public function updateStore(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stores,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'is_active' => 'boolean',
        ]);
        
        $store->update($validated);
        
        // Log activity
        ActivityLog::log('update', 'Store updated: ' . $store->name, ['store' => $store]);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Store berhasil diupdate',
                'data' => $store
            ]);
        }
        
        return redirect()->route('developer.stores.index')
            ->with('success', 'Store berhasil diupdate');
    }
    
    /**
     * Toggle Store Status
     */
    public function toggleStoreStatus($id)
    {
        $store = Store::findOrFail($id);
        $store->is_active = !$store->is_active;
        $store->save();
        
        $status = $store->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        // Log activity
        ActivityLog::log('status_change', 'Store ' . $status . ': ' . $store->name, ['store' => $store]);
        
        return response()->json([
            'success' => true,
            'message' => "Store berhasil {$status}"
        ]);
    }
    
    /**
     * Delete Store
     */
    public function deleteStore($id)
    {
        $store = Store::findOrFail($id);
        
        // Log activity
        ActivityLog::log('delete', 'Store deleted: ' . $store->name, ['store' => $store]);
        
        $store->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Store berhasil dihapus'
        ]);
    }
    
    /**
     * Assign owner to store
     */
    public function assignStoreOwner(Request $request, $id)
    {
        $store = Store::findOrFail($id);
        $userId = $request->input('user_id');
        
        $user = User::find($userId);
        if ($user) {
            $user->store_id = $store->id;
            $user->role = 'admin';
            $user->save();
        }
        
        // Log activity
        ActivityLog::log('update', 'Store owner assigned: ' . $store->name, ['store' => $store, 'user' => $user]);
        
        return response()->json([
            'success' => true,
            'message' => 'Store owner assigned successfully'
        ]);
    }
    
    // ==================== SYSTEM MANAGEMENT ====================
    
    /**
     * System Settings
     */
    public function system()
    {
        $phpVersion = phpversion();
        $laravelVersion = app()->version();
        $environment = app()->environment();
        $debug = config('app.debug') ? 'Enabled' : 'Disabled';
        
        return view('developer.system.index', compact('phpVersion', 'laravelVersion', 'environment', 'debug'));
    }
    
    /**
     * System Information
     */
    public function systemInfo()
    {
        $phpVersion = phpversion();
        $laravelVersion = app()->version();
        $environment = app()->environment();
        $debug = config('app.debug') ? 'Enabled' : 'Disabled';
        
        // Get installed packages
        $composerFile = base_path('composer.json');
        $packages = [];
        
        if (File::exists($composerFile)) {
            $composer = json_decode(File::get($composerFile), true);
            $packages = $composer['require'] ?? [];
        }
        
        return view('developer.system.info', compact('phpVersion', 'laravelVersion', 'environment', 'debug', 'packages'));
    }
    
    /**
     * Cache Management View
     */
    public function cacheManagement()
    {
        return view('developer.system.cache');
    }
    
    /**
     * Database Management View
     */
    public function databaseManagement()
    {
        return view('developer.system.database');
    }
    
    /**
     * System Health Check
     */
    public function systemHealth()
    {
        return response()->json([
            'success' => true,
            'data' => [
                'php_version' => phpversion(),
                'laravel_version' => app()->version(),
                'environment' => app()->environment(),
                'debug' => config('app.debug'),
                'db_connected' => true,
                'db_name' => config('database.connections.mysql.database'),
                'cache_driver' => config('cache.default'),
                'session_driver' => config('session.driver'),
                'queue_driver' => config('queue.default'),
            ]
        ]);
    }
    
    /**
     * Clear Cache
     */
    public function clearCache(Request $request)
    {
        $type = $request->get('type', 'all');
        $output = '';
        
        switch ($type) {
            case 'config':
                Artisan::call('config:clear');
                $output = Artisan::output();
                $message = 'Config cache cleared';
                break;
            case 'cache':
                Artisan::call('cache:clear');
                $output = Artisan::output();
                $message = 'Application cache cleared';
                break;
            case 'view':
                Artisan::call('view:clear');
                $output = Artisan::output();
                $message = 'View cache cleared';
                break;
            case 'route':
                Artisan::call('route:clear');
                $output = Artisan::output();
                $message = 'Route cache cleared';
                break;
            default:
                Artisan::call('optimize:clear');
                $output = Artisan::output();
                $message = 'All caches cleared';
        }
        
        // Log activity
        ActivityLog::log('system', 'Cache cleared: ' . $type);
        
        return response()->json([
            'success' => true,
            'message' => $message,
            'output' => $output
        ]);
    }
    
    /**
     * Clear specific cache type
     */
    public function clearCacheType($type)
    {
        return $this->clearCache(new Request(['type' => $type]));
    }
    
    /**
     * Warmup cache
     */
    public function warmupCache()
    {
        try {
            // Run warmup commands
            Artisan::call('config:cache');
            Artisan::call('route:cache');
            Artisan::call('view:cache');
            
            return response()->json([
                'success' => true,
                'message' => 'Cache warmed up successfully',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to warmup cache: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Cache statistics
     */
    public function cacheStats()
    {
        $cachePath = storage_path('framework/cache');
        $size = 0;
        $items = 0;
        
        if (File::exists($cachePath)) {
            $files = File::allFiles($cachePath);
            $size = array_sum(array_map('filesize', $files));
            $items = count($files);
        }
        
        return response()->json([
            'success' => true,
            'data' => [
                'driver' => config('cache.default'),
                'size' => $this->formatSize($size),
                'items' => $items,
                'hits' => 0,
            ]
        ]);
    }
    
    /**
     * Database statistics
     */
    public function databaseStats()
    {
        $tables = [];
        $totalSize = 0;
        $totalRows = 0;
        
        try {
            $dbName = config('database.connections.mysql.database');
            $results = DB::select("SHOW TABLE STATUS FROM `{$dbName}`");
            
            foreach ($results as $table) {
                $size = ($table->Data_length + $table->Index_length);
                $totalSize += $size;
                $totalRows += $table->Rows;
                
                $tables[] = [
                    'name' => $table->Name,
                    'rows' => $table->Rows,
                    'size' => $this->formatSize($size),
                    'type' => $table->Engine,
                ];
            }
        } catch (\Exception $e) {
            // Fallback for systems without SHOW TABLE STATUS
            $tables = [];
        }
        
        $migrations = DB::table('migrations')->count();
        
        return response()->json([
            'success' => true,
            'stats' => [
                'db_name' => config('database.connections.mysql.database'),
                'total_size' => $this->formatSize($totalSize),
                'total_tables' => count($tables),
                'total_records' => $totalRows,
                'migrations' => $migrations,
            ],
            'tables' => $tables
        ]);
    }
    
    /**
     * Get database tables
     */
    public function databaseTables()
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $results = DB::select("SHOW TABLE STATUS FROM `{$dbName}`");
            
            $tables = [];
            foreach ($results as $table) {
                $tables[] = [
                    'name' => $table->Name,
                    'rows' => $table->Rows,
                    'size' => $this->formatSize($table->Data_length + $table->Index_length),
                    'engine' => $table->Engine,
                    'collation' => $table->Collation,
                    'created_at' => $table->Create_time ?? null,
                ];
            }
            
            return response()->json([
                'success' => true,
                'data' => $tables
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to load tables: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Run Migration
     */
    public function runMigration()
    {
        try {
            Artisan::call('migrate', ['--force' => true]);
            $output = Artisan::output();
            
            // Log activity
            ActivityLog::log('system', 'Migration executed');
            
            return response()->json([
                'success' => true,
                'message' => 'Migration berhasil dijalankan',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Migration gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Rollback Migration
     */
    public function rollbackMigration()
    {
        try {
            Artisan::call('migrate:rollback', ['--force' => true]);
            $output = Artisan::output();
            
            // Log activity
            ActivityLog::log('system', 'Migration rollback executed');
            
            return response()->json([
                'success' => true,
                'message' => 'Rollback berhasil dijalankan',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Rollback gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Run Seeder
     */
    public function runSeeder(Request $request)
    {
        $seeder = $request->get('seeder', 'DatabaseSeeder');
        
        try {
            Artisan::call('db:seed', [
                '--class' => $seeder,
                '--force' => true
            ]);
            $output = Artisan::output();
            
            // Log activity
            ActivityLog::log('system', 'Seeder executed: ' . $seeder);
            
            return response()->json([
                'success' => true,
                'message' => "Seeder {$seeder} berhasil dijalankan",
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Seeder gagal: " . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Reset Database
     */
    public function resetDatabase()
    {
        try {
            Artisan::call('migrate:refresh', ['--force' => true]);
            $output = Artisan::output();
            
            // Log activity
            ActivityLog::log('system', 'Database reset executed');
            
            return response()->json([
                'success' => true,
                'message' => 'Database berhasil di-reset',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Reset database gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Refresh Database
     */
    public function refreshDatabase()
    {
        try {
            Artisan::call('migrate:refresh', ['--force' => true]);
            Artisan::call('db:seed', ['--force' => true]);
            $output = Artisan::output();
            
            // Log activity
            ActivityLog::log('system', 'Database refresh executed');
            
            return response()->json([
                'success' => true,
                'message' => 'Database berhasil di-refresh',
                'output' => $output
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Refresh database gagal: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Run database query
     */
    public function runDatabaseQuery(Request $request)
    {
        $query = $request->input('query');
        
        if (empty($query)) {
            return response()->json([
                'success' => false,
                'message' => 'Query cannot be empty'
            ], 422);
        }
        
        // Check for dangerous queries
        $dangerous = ['DROP', 'TRUNCATE', 'ALTER', 'CREATE', 'INSERT', 'UPDATE', 'DELETE'];
        $upperQuery = strtoupper($query);
        foreach ($dangerous as $word) {
            if (strpos($upperQuery, $word) !== false) {
                return response()->json([
                    'success' => false,
                    'message' => "Query contains dangerous operation: {$word}. Only SELECT queries are allowed."
                ], 403);
            }
        }
        
        try {
            $startTime = microtime(true);
            $results = DB::select($query);
            $endTime = microtime(true);
            
            return response()->json([
                'success' => true,
                'data' => $results,
                'count' => count($results),
                'execution_time' => round(($endTime - $startTime) * 1000, 2)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Query error: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Optimize Application
     */
    public function optimizeApp()
    {
        try {
            Artisan::call('optimize');
            
            // Log activity
            ActivityLog::log('system', 'Application optimized');
            
            return response()->json([
                'success' => true,
                'message' => 'Application optimized successfully',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Optimization failed: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Clear optimized files
     */
    public function clearOptimized()
    {
        try {
            Artisan::call('optimize:clear');
            
            return response()->json([
                'success' => true,
                'message' => 'Optimized files cleared',
                'output' => Artisan::output()
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear optimized files: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Clear application
     */
    public function clearApplication()
    {
        try {
            Artisan::call('optimize:clear');
            $this->clearLogs();
            
            return response()->json([
                'success' => true,
                'message' => 'Application cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to clear application: ' . $e->getMessage()
            ], 500);
        }
    }
    
    // ==================== LOGS ====================
    
    /**
     * View Logs
     */
    public function logs()
    {
        return view('developer.logs.index');
    }
    
    /**
     * Get logs data for API
     */
    public function getLogsData(Request $request)
    {
        $logFiles = File::files(storage_path('logs'));
        $logs = [];
        $totalSize = 0;
        $largestFile = 0;
        $lastModified = 0;
        
        foreach ($logFiles as $file) {
            $size = $file->getSize();
            $modified = $file->getMTime();
            $totalSize += $size;
            $largestFile = max($largestFile, $size);
            $lastModified = max($lastModified, $modified);
            
            $logs[] = [
                'name' => $file->getFilename(),
                'size' => $size,
                'modified' => $modified,
            ];
        }
        
        // Sort by modified time desc
        usort($logs, function($a, $b) {
            return $b['modified'] - $a['modified'];
        });
        
        $stats = [
            'total_files' => count($logs),
            'total_size' => $this->formatSize($totalSize),
            'largest_file' => $this->formatSize($largestFile),
            'last_modified' => $lastModified ? date('d/m/Y H:i', $lastModified) : '-',
        ];
        
        return response()->json([
            'success' => true,
            'data' => $logs,
            'stats' => $stats
        ]);
    }
    
    /**
     * View Log File
     */
    public function viewLog($file)
    {
        $path = storage_path('logs/' . $file);
        
        if (!File::exists($path)) {
            abort(404, 'Log file not found');
        }
        
        return view('developer.logs.show', ['file' => $file]);
    }
    
    /**
     * Download Log File
     */
    public function downloadLog($file)
    {
        $path = storage_path('logs/' . $file);
        
        if (!File::exists($path)) {
            abort(404, 'Log file not found');
        }
        
        return response()->download($path, $file);
    }
    
    /**
     * Delete Log File
     */
    public function deleteLog($file)
    {
        $path = storage_path('logs/' . $file);
        
        if (!File::exists($path)) {
            return response()->json([
                'success' => false,
                'message' => 'Log file not found'
            ], 404);
        }
        
        File::delete($path);
        
        // Log activity
        ActivityLog::log('delete', 'Log file deleted: ' . $file);
        
        return response()->json([
            'success' => true,
            'message' => 'Log file deleted successfully'
        ]);
    }
    
    /**
     * Clear Logs
     */
    public function clearLogs()
    {
        $files = File::files(storage_path('logs'));
        
        foreach ($files as $file) {
            File::put($file->getPathname(), '');
        }
        
        // Log activity
        ActivityLog::log('system', 'All logs cleared');
        
        return response()->json([
            'success' => true,
            'message' => 'Logs cleared successfully'
        ]);
    }
    
    // ==================== ACTIVITY LOGS ====================
    
    /**
     * Activity Logs
     */
    public function activityLogs()
    {
        $users = User::select('id', 'name')->get();
        return view('developer.activity.index', compact('users'));
    }
    
    /**
     * Get activity data for API
     */
    public function getActivityData(Request $request)
    {
        $query = ActivityLog::with('user');
        
        if ($request->filled('search')) {
            $query->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('ip_address', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->filled('user')) {
            $query->where('user_id', $request->user);
        }
        
        if ($request->filled('date')) {
            switch ($request->date) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
                case 'yesterday':
                    $query->whereDate('created_at', now()->subDay()->toDateString());
                    break;
                case 'week':
                    $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
            }
        }
        
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $query->whereBetween('created_at', [
                $request->date_from . ' 00:00:00',
                $request->date_to . ' 23:59:59'
            ]);
        }
        
        $sort = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');
        $query->orderBy($sort, $direction);
        
        $activities = $query->paginate(20);
        
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', now()->toDateString())->count(),
            'week' => ActivityLog::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'users' => ActivityLog::distinct('user_id')->count(),
        ];
        
        return response()->json([
            'success' => true,
            'data' => $activities,
            'stats' => $stats
        ]);
    }
    
    /**
     * Get recent activity
     */
    public function getRecentActivity()
    {
        $activities = ActivityLog::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $activities
        ]);
    }
    
    /**
     * Show activity detail
     */
    public function showActivity($id)
    {
        $activity = ActivityLog::with('user')->findOrFail($id);
        $related = ActivityLog::where('id', '!=', $id)
            ->where(function ($query) use ($activity) {
                $query->where('user_id', $activity->user_id)
                      ->orWhere('type', $activity->type)
                      ->orWhere('ip_address', $activity->ip_address);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        return view('developer.activity.show', compact('activity', 'related'));
    }
    
    /**
     * Delete activity
     */
    public function deleteActivity($id)
    {
        $activity = ActivityLog::findOrFail($id);
        $activity->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Activity deleted successfully'
        ]);
    }
    
    /**
     * Clear all activity logs
     */
    public function clearActivityLogs()
    {
        ActivityLog::truncate();
        
        return response()->json([
            'success' => true,
            'message' => 'All activity logs cleared'
        ]);
    }
    
    // ==================== STATISTICS ====================
    
    /**
     * Statistics Dashboard
     */
    public function statistics()
    {
        return view('developer.stats.index');
    }
    
    /**
     * Get overview statistics
     */
    public function getOverviewStats(Request $request)
    {
        $period = $request->get('period', 'month');
        $now = now();
        
        // Get period dates
        switch ($period) {
            case 'week':
                $startDate = $now->clone()->startOfWeek();
                $endDate = $now->clone()->endOfWeek();
                $prevStartDate = $now->clone()->subWeek()->startOfWeek();
                $prevEndDate = $now->clone()->subWeek()->endOfWeek();
                break;
            case 'year':
                $startDate = $now->clone()->startOfYear();
                $endDate = $now->clone()->endOfYear();
                $prevStartDate = $now->clone()->subYear()->startOfYear();
                $prevEndDate = $now->clone()->subYear()->endOfYear();
                break;
            case 'month':
            default:
                $startDate = $now->clone()->startOfMonth();
                $endDate = $now->clone()->endOfMonth();
                $prevStartDate = $now->clone()->subMonth()->startOfMonth();
                $prevEndDate = $now->clone()->subMonth()->endOfMonth();
        }
        
        // Current period data
        $totalUsers = User::count();
        $totalStores = Store::count();
        $totalTransactions = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalRevenue = Transaction::whereBetween('created_at', [$startDate, $endDate])
            ->sum(DB::raw('total_amount'));
        
        // Previous period data for growth calculation
        $prevTransactions = Transaction::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $prevRevenue = Transaction::whereBetween('created_at', [$prevStartDate, $prevEndDate])
            ->sum(DB::raw('total_amount'));
        
        // Calculate growth percentages
        $currentPeriodUsers = User::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevPeriodUsers = User::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $userGrowth = $prevPeriodUsers > 0
            ? round((($currentPeriodUsers - $prevPeriodUsers) / $prevPeriodUsers) * 100, 1)
            : ($currentPeriodUsers > 0 ? 100 : 0);

        $currentPeriodStores = Store::whereBetween('created_at', [$startDate, $endDate])->count();
        $prevPeriodStores = Store::whereBetween('created_at', [$prevStartDate, $prevEndDate])->count();
        $storeGrowth = $prevPeriodStores > 0
            ? round((($currentPeriodStores - $prevPeriodStores) / $prevPeriodStores) * 100, 1)
            : ($currentPeriodStores > 0 ? 100 : 0);

        $transactionGrowth = $prevTransactions > 0 
            ? round((($totalTransactions - $prevTransactions) / $prevTransactions) * 100, 1)
            : 0;
        $revenueGrowth = $prevRevenue > 0
            ? round((($totalRevenue - $prevRevenue) / $prevRevenue) * 100, 1)
            : 0;
        
        $activeUsers = User::where('is_active', true)->count();
        $activeStores = Store::where('is_active', true)->count();
        
        $stats = [
            'total_users' => $totalUsers,
            'total_stores' => $totalStores,
            'total_transactions' => $totalTransactions,
            'total_revenue' => $totalRevenue ?? 0,
            'user_growth' => $userGrowth,
            'store_growth' => $storeGrowth,
            'transaction_growth' => $transactionGrowth,
            'revenue_growth' => $revenueGrowth,
            'active_users' => $activeUsers,
            'active_stores' => $activeStores,
            'active_users_percentage' => $totalUsers > 0 ? round(($activeUsers / $totalUsers) * 100, 1) : 0,
            'active_stores_percentage' => $totalStores > 0 ? round(($activeStores / $totalStores) * 100, 1) : 0,
            'avg_order_value' => $totalTransactions > 0 ? round(($totalRevenue ?? 0) / $totalTransactions, 2) : 0,
            'conversion_rate' => $totalUsers > 0 && $totalTransactions > 0 
                ? round(($totalTransactions / $totalUsers) * 100, 2)
                : 0,
        ];
        
        return response()->json([
            'success' => true,
            'data' => $stats
        ]);
    }
    
    /**
     * User Statistics
     */
    public function userStatistics()
    {
        return view('developer.stats.users');
    }
    
    /**
     * Store Statistics
     */
    public function storeStatistics()
    {
        return view('developer.stats.stores');
    }
    
    /**
     * Transaction Statistics
     */
    public function transactionStatistics()
    {
        return view('developer.stats.transactions');
    }
    
    /**
     * System Statistics
     */
    public function systemStatistics()
    {
        return view('developer.stats.system');
    }
    
    // ==================== MAINTENANCE MODE ====================
    
    /**
     * Maintenance index
     */
    public function maintenanceIndex()
    {
        return view('developer.maintenance.index');
    }
    
    /**
     * Get maintenance status
     */
    public function maintenanceStatus()
    {
        $maintenanceMode = app()->isDownForMaintenance();
        $maintenanceSettings = Setting::where('key', 'maintenance_settings')->first();
        $settings = $maintenanceSettings ? json_decode($maintenanceSettings->value, true) : [];
        
        return response()->json([
            'success' => true,
            'data' => [
                'enabled' => $maintenanceMode,
                'message' => $maintenanceMode ? 'Site is under maintenance' : 'Site is operational',
                'queue_worker' => true,
                'scheduler' => true,
                'cache' => true,
                'last_maintenance' => $maintenanceSettings ? $maintenanceSettings->updated_at : null
            ],
            'settings' => array_merge([
                'message' => 'We are currently performing maintenance. Please check back later.',
                'allowed_ips' => '127.0.0.1',
                'bypass_for_developers' => true,
                'retry_after' => false,
                'retry_seconds' => 60
            ], $settings)
        ]);
    }
    
    /**
     * Get maintenance schedules
     */
    public function getMaintenanceSchedules()
    {
        $schedulesData = Setting::where('key', 'maintenance_schedules')->first();
        $schedules = $schedulesData ? json_decode($schedulesData->value, true) ?? [] : [];
        
        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }
    
    /**
     * Enable maintenance
     */
    public function enableMaintenance()
    {
        try {
            Artisan::call('down');
            
            // Log activity
            ActivityLog::log('system', 'Maintenance mode enabled');
            
            return response()->json([
                'success' => true,
                'message' => 'Maintenance mode enabled'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to enable maintenance: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Disable maintenance
     */
    public function disableMaintenance()
    {
        try {
            Artisan::call('up');
            
            // Log activity
            ActivityLog::log('system', 'Maintenance mode disabled');
            
            return response()->json([
                'success' => true,
                'message' => 'Maintenance mode disabled'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to disable maintenance: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update maintenance settings
     */
    public function updateMaintenanceSettings(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'allowed_ips' => 'nullable|string',
            'bypass_for_developers' => 'boolean',
            'retry_after' => 'boolean',
            'retry_seconds' => 'integer|min:1',
        ]);
        
        $maintenanceSettings = Setting::firstOrCreate(
            ['key' => 'maintenance_settings'],
            ['value' => json_encode($validated)]
        );
        
        $maintenanceSettings->update(['value' => json_encode($validated)]);
        
        ActivityLog::log('system', 'Maintenance settings updated');
        
        return response()->json([
            'success' => true,
            'message' => 'Maintenance settings updated successfully',
            'data' => $validated
        ]);
    }
    
    /**
     * Schedule maintenance
     */
    public function scheduleMaintenance(Request $request)
    {
        $validated = $request->validate([
            'scheduled_at' => 'required|date|after:now',
            'duration_minutes' => 'required|integer|min:15',
            'message' => 'nullable|string',
        ]);
        
        // Store scheduled maintenance in settings
        $schedules = [];
        $existingSchedules = Setting::where('key', 'maintenance_schedules')->first();
        if ($existingSchedules) {
            $schedules = json_decode($existingSchedules->value, true) ?? [];
        }
        
        $schedules[] = array_merge($validated, ['id' => uniqid()]);
        
        Setting::updateOrCreate(
            ['key' => 'maintenance_schedules'],
            ['value' => json_encode($schedules)]
        );
        
        ActivityLog::log('system', 'Maintenance scheduled for ' . $validated['scheduled_at']);
        
        return response()->json([
            'success' => true,
            'message' => 'Maintenance scheduled successfully',
            'data' => end($schedules)
        ]);
    }
    
    /**
     * Cancel maintenance schedule
     */
    public function cancelMaintenanceSchedule($id)
    {
        $existingSchedules = Setting::where('key', 'maintenance_schedules')->first();
        
        if (!$existingSchedules) {
            return response()->json([
                'success' => false,
                'message' => 'Schedule not found'
            ], 404);
        }
        
        $schedules = json_decode($existingSchedules->value, true) ?? [];
        $schedules = array_filter($schedules, function ($schedule) use ($id) {
            return $schedule['id'] !== $id;
        });
        
        Setting::where('key', 'maintenance_schedules')
            ->update(['value' => json_encode(array_values($schedules))]);
        
        ActivityLog::log('system', 'Maintenance schedule cancelled: ' . $id);
        
        return response()->json([
            'success' => true,
            'message' => 'Schedule cancelled successfully'
        ]);
    }
    
    // ==================== BACKUP ====================
    
    /**
     * Backup index
     */
    public function backups()
    {
        return view('developer.backup.index');
    }
    
    /**
     * Create backup view
     */
    public function createBackupView()
    {
        return view('developer.backup.create');
    }
    
    /**
     * Get backup list
     */
    public function getBackupList()
    {
        $backupPath = storage_path('app/backups');
        $backups = [];
        $totalSize = 0;
        $latest = null;
        $storageUsed = 0;
        
        if (File::exists($backupPath)) {
            $files = File::files($backupPath);
            $storageUsed = $this->getDirectorySize($backupPath);
            
            foreach ($files as $file) {
                $size = $file->getSize();
                $totalSize += $size;
                $backups[] = [
                    'name' => $file->getFilename(),
                    'size' => $size,
                    'type' => $this->getBackupType($file->getFilename()),
                    'created_at' => $file->getMTime(),
                ];
            }
            
            // Sort by created_at desc
            usort($backups, function($a, $b) {
                return $b['created_at'] - $a['created_at'];
            });
            
            if (!empty($backups)) {
                $latest = date('d/m/Y H:i', $backups[0]['created_at']);
            }
        }
        
        $stats = [
            'total' => count($backups),
            'total_size' => $this->formatSize($totalSize),
            'latest' => $latest,
            'storage_used' => $storageUsed > 0 ? round(($totalSize / $storageUsed) * 100) . '%' : '0%',
        ];
        
        return response()->json([
            'success' => true,
            'data' => $backups,
            'stats' => $stats
        ]);
    }
    
    /**
     * Get backup settings
     */
    public function getBackupSettings()
    {
        $backupSettings = Setting::where('key', 'backup_settings')->first();
        
        $defaultSettings = [
            'auto_backup' => 'daily',
            'keep_backups' => 10,
            'backup_database' => true,
            'backup_files' => false,
            'backup_media' => false,
            'storage' => 'local'
        ];
        
        $settings = $backupSettings ? json_decode($backupSettings->value, true) : $defaultSettings;
        
        return response()->json([
            'success' => true,
            'data' => array_merge($defaultSettings, $settings)
        ]);
    }
    
    /**
     * Store backup
     */
    public function storeBackup(Request $request)
    {
        return $this->createBackup($request);
    }
    
    /**
     * Create backup
     */
    public function createBackup(Request $request)
    {
        try {
            $backupPath = storage_path('app/backups');
            
            if (!File::exists($backupPath)) {
                File::makeDirectory($backupPath, 0755, true);
            }
            
            $name = $request->input('name') ?: 'backup_' . date('Y-m-d_H-i-s');
            $includeDatabase = $request->input('include_database', true);
            
            $filename = $name . '.sql';
            $filePath = $backupPath . '/' . $filename;
            
            // Create database backup
            if ($includeDatabase) {
                $database = config('database.connections.mysql.database');
                $username = config('database.connections.mysql.username');
                $password = config('database.connections.mysql.password');
                $host = config('database.connections.mysql.host');
                
                $command = sprintf(
                    'mysqldump --host=%s --user=%s --password=%s %s > %s',
                    escapeshellarg($host),
                    escapeshellarg($username),
                    escapeshellarg($password),
                    escapeshellarg($database),
                    escapeshellarg($filePath)
                );
                
                exec($command, $output, $returnCode);
                
                if ($returnCode !== 0) {
                    throw new \Exception('Database backup failed');
                }
            }
            
            // Log activity
            ActivityLog::log('create', 'Backup created: ' . $filename);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup created successfully',
                'data' => [
                    'name' => $filename,
                    'size' => File::exists($filePath) ? File::size($filePath) : 0,
                    'created_at' => now()->timestamp
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create backup: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Update backup settings
     */
    public function updateBackupSettings(Request $request)
    {
        $validated = $request->validate([
            'auto_backup' => 'required|in:daily,weekly,monthly,disabled',
            'keep_backups' => 'required|integer|min:1',
            'backup_database' => 'boolean',
            'backup_files' => 'boolean',
            'backup_media' => 'boolean',
            'storage' => 'required|in:local,s3,google,dropbox',
        ]);
        
        $backupSettings = Setting::firstOrCreate(
            ['key' => 'backup_settings'],
            ['value' => json_encode($validated)]
        );
        
        $backupSettings->update(['value' => json_encode($validated)]);
        
        // Log activity
        ActivityLog::log('system', 'Backup settings updated');
        
        return response()->json([
            'success' => true,
            'message' => 'Settings updated successfully',
            'data' => $validated
        ]);
    }
    
    /**
     * Restore backup
     */
    public function restoreBackup($file)
    {
        try {
            $backupPath = storage_path('app/backups/' . $file);
            
            if (!File::exists($backupPath)) {
                throw new \Exception('Backup file not found');
            }
            
            // Restore database from backup file
            $database = config('database.connections.mysql.database');
            $username = config('database.connections.mysql.username');
            $password = config('database.connections.mysql.password');
            $host = config('database.connections.mysql.host');
            
            $command = sprintf(
                'mysql --host=%s --user=%s --password=%s %s < %s',
                escapeshellarg($host),
                escapeshellarg($username),
                escapeshellarg($password),
                escapeshellarg($database),
                escapeshellarg($backupPath)
            );
            
            exec($command, $output, $returnCode);
            
            if ($returnCode !== 0) {
                throw new \Exception('Database restore failed');
            }
            
            // Log activity
            ActivityLog::log('system', 'Backup restored: ' . $file);
            
            return response()->json([
                'success' => true,
                'message' => 'Backup restored successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to restore backup: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Download backup
     */
    public function downloadBackup($file)
    {
        $backupPath = storage_path('app/backups/' . $file);
        
        if (!File::exists($backupPath)) {
            abort(404, 'Backup file not found');
        }
        
        return response()->download($backupPath, $file);
    }
    
    /**
     * Delete backup
     */
    public function deleteBackup($file)
    {
        $backupPath = storage_path('app/backups/' . $file);
        
        if (!File::exists($backupPath)) {
            return response()->json([
                'success' => false,
                'message' => 'Backup file not found'
            ], 404);
        }
        
        File::delete($backupPath);
        
        // Log activity
        ActivityLog::log('delete', 'Backup deleted: ' . $file);
        
        return response()->json([
            'success' => true,
            'message' => 'Backup deleted successfully'
        ]);
    }
    
    // ==================== SCHEDULED JOBS ====================
    
    /**
     * Scheduled Jobs
     */
    public function scheduledJobs()
    {
        return view('developer.jobs.index');
    }
    
    /**
     * Get jobs data for API
     */
    public function getJobsData(Request $request)
    {
        $query = ScheduledJob::with('logs');
        
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }
        
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }
        
        $jobs = $query->get();
        
        $stats = [
            'total' => $jobs->count(),
            'active' => $jobs->where('is_active', true)->count(),
            'inactive' => $jobs->where('is_active', false)->count(),
            'failed' => $jobs->where('last_run_status', 'failed')->count(),
        ];
        
        // Transform jobs to include calculated fields
        $jobsData = $jobs->map(function ($job) {
            return [
                'id' => $job->id,
                'name' => $job->name,
                'description' => $job->description,
                'command' => $job->command,
                'expression' => $job->expression,
                'is_active' => $job->is_active,
                'last_run_at' => $job->last_run_at,
                'last_run_status' => $job->last_run_status,
                'runs_count' => $job->runs_count,
                'fails_count' => $job->fails_count,
                'success_rate' => $job->success_rate,
                'last_run_time' => $job->last_run_time,
            ];
        });
        
        return response()->json([
            'success' => true,
            'data' => $jobsData,
            'stats' => $stats
        ]);
    }
    
    /**
     * Get sample jobs
     */
    /**
     * Run scheduled job
     */
    public function runScheduledJob($job)
    {
        try {
            // Find job by name or id
            $jobData = ScheduledJob::where('name', $job)
                ->orWhere('id', $job)
                ->first();
            
            if (!$jobData) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found'
                ], 404);
            }
            
            $startTime = microtime(true);
            $output = '';
            $status = 'success';
            $errorMessage = null;
            
            try {
                // Execute the job command
                Artisan::call(str_replace('artisan ', '', $jobData->command));
                $output = Artisan::output();
            } catch (\Exception $e) {
                $status = 'failed';
                $errorMessage = $e->getMessage();
                $output = 'Error: ' . $e->getMessage();
            }
            
            $endTime = microtime(true);
            $duration = round(($endTime - $startTime) * 1000); // in milliseconds
            
            // Create job log
            JobLog::create([
                'scheduled_job_id' => $jobData->id,
                'status' => $status,
                'output' => $output,
                'error_message' => $errorMessage,
                'duration' => $duration,
                'started_at' => now()->subMilliseconds($duration),
                'finished_at' => now(),
            ]);
            
            // Update job statistics
            $newRunsCount = $jobData->runs_count + 1;
            $newFailsCount = $jobData->fails_count + ($status === 'failed' ? 1 : 0);
            
            $jobData->update([
                'last_run_at' => now(),
                'last_run_status' => $status,
                'runs_count' => $newRunsCount,
                'fails_count' => $newFailsCount,
            ]);
            
            // Log activity
            ActivityLog::log('system', 'Job executed: ' . $jobData->name . ' - Status: ' . $status);
            
            return response()->json([
                'success' => true,
                'message' => 'Job executed ' . $status,
                'status' => $status,
                'output' => $output,
                'duration' => $duration
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to run job: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Run all jobs
     */
    public function runAllJobs()
    {
        try {
            $jobs = ScheduledJob::where('is_active', true)->get();
            $results = [];
            
            foreach ($jobs as $job) {
                $startTime = microtime(true);
                $status = 'success';
                $output = '';
                $errorMessage = null;
                
                try {
                    // Execute the job command
                    Artisan::call(str_replace('artisan ', '', $job->command));
                    $output = Artisan::output();
                } catch (\Exception $e) {
                    $status = 'failed';
                    $errorMessage = $e->getMessage();
                    $output = 'Error: ' . $e->getMessage();
                }
                
                $endTime = microtime(true);
                $duration = round(($endTime - $startTime) * 1000);
                
                // Create job log
                JobLog::create([
                    'scheduled_job_id' => $job->id,
                    'status' => $status,
                    'output' => $output,
                    'error_message' => $errorMessage,
                    'duration' => $duration,
                    'started_at' => now()->subMilliseconds($duration),
                    'finished_at' => now(),
                ]);
                
                // Update job statistics
                $job->increment('runs_count');
                if ($status === 'failed') {
                    $job->increment('fails_count');
                }
                $job->update([
                    'last_run_at' => now(),
                    'last_run_status' => $status,
                ]);
                
                $results[] = [
                    'id' => $job->id,
                    'name' => $job->name,
                    'status' => $status,
                    'duration' => $duration
                ];
            }
            
            // Log activity
            ActivityLog::log('system', 'All jobs executed (' . count($results) . ' jobs)');
            
            return response()->json([
                'success' => true,
                'message' => 'All jobs executed',
                'data' => $results,
                'total' => count($results)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to run all jobs: ' . $e->getMessage()
            ], 500);
        }
    }
    
    /**
     * Enable job
     */
    public function enableScheduledJob(Request $request, $job)
    {
        $jobData = ScheduledJob::where('name', $job)->orWhere('id', $job)->first();
        
        if (!$jobData) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ], 404);
        }
        
        $jobData->update(['is_active' => true]);
        
        // Log activity
        ActivityLog::log('system', 'Job enabled: ' . $jobData->name);
        
        return response()->json([
            'success' => true,
            'message' => 'Job enabled successfully',
            'data' => $jobData
        ]);
    }
    
    /**
     * Disable job
     */
    public function disableScheduledJob(Request $request, $job)
    {
        $jobData = ScheduledJob::where('name', $job)->orWhere('id', $job)->first();
        
        if (!$jobData) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found'
            ], 404);
        }
        
        $jobData->update(['is_active' => false]);
        
        // Log activity
        ActivityLog::log('system', 'Job disabled: ' . $jobData->name);
        
        return response()->json([
            'success' => true,
            'message' => 'Job disabled successfully',
            'data' => $jobData
        ]);
    }
    
    /**
     * Get job logs
     */
    public function getJobLogs(Request $request, $job)
    {
        $jobData = ScheduledJob::where('name', $job)->orWhere('id', $job)->first();
        
        if ($jobData) {
            $logs = JobLog::where('scheduled_job_id', $jobData->id)
                ->orderBy('created_at', 'desc')
                ->limit(50)
                ->get();
        } else {
            $logs = collect();
        }
        
        return response()->json([
            'success' => true,
            'data' => $logs
        ]);
    }
    
    /**
     * Schedule new job
     */
    public function scheduleNewJob(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'command' => 'required|string',
            'frequency' => 'required|string',
            'cron' => 'nullable|string',
            'group' => 'nullable|string',
            'description' => 'nullable|string'
        ]);
        
        $job = ScheduledJob::create($validated);
        
        // Log activity
        ActivityLog::log('create', 'New job scheduled: ' . $job->name);
        
        return response()->json([
            'success' => true,
            'data' => $job,
            'message' => 'Job scheduled successfully'
        ]);
    }
    
    /**
     * Delete job
     */
    public function deleteScheduledJob(Request $request, $job)
    {
        $jobData = ScheduledJob::where('name', $job)->orWhere('id', $job)->first();
        
        if ($jobData) {
            $jobData->delete();
        }
        
        // Log activity
        ActivityLog::log('delete', 'Job deleted: ' . $job);
        
        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully'
        ]);
    }
    
    // ==================== PHP INFO ====================
    
    /**
     * PHP Info
     */
    public function phpInfo()
    {
        phpinfo();
        exit;
    }
    
    // ==================== HELPER METHODS ====================
    
    /**
     * Format size
     */
    private function formatSize($bytes)
    {
        if ($bytes === 0) return '0 B';
        $k = 1024;
        $sizes = ['B', 'KB', 'MB', 'GB', 'TB'];
        $i = floor(log($bytes) / log($k));
        return round($bytes / pow($k, $i), 2) . ' ' . $sizes[$i];
    }
    
    /**
     * Get directory size
     */
    private function getDirectorySize($path)
    {
        $total = 0;
        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $total += $file->getSize();
            }
        }
        return $total;
    }
    
    /**
     * Get backup type
     */
    private function getBackupType($filename)
    {
        if (str_contains($filename, '.sql')) return 'Database';
        if (str_contains($filename, '.zip')) return 'Full';
        if (str_contains($filename, '.tar')) return 'Archive';
        return 'Unknown';
    }
    
    /**
     * Get period dates
     */
    private function getPeriodDates($period)
    {
        $now = now();
        switch ($period) {
            case 'today':
                return [$now->copy()->startOfDay(), $now->copy()->endOfDay()];
            case 'week':
                return [$now->copy()->startOfWeek(), $now->copy()->endOfWeek()];
            case 'month':
                return [$now->copy()->startOfMonth(), $now->copy()->endOfMonth()];
            case 'year':
                return [$now->copy()->startOfYear(), $now->copy()->endOfYear()];
            default:
                return [$now->copy()->subYear(), $now];
        }
    }
}