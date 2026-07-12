<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    /**
     * Show settings page (redirect to profile)
     */
    public function index()
    {
        return redirect()->route('admin.settings.profile');
    }
    
    /**
     * Show profile settings page
     */
    public function profile()
    {
        $store = auth()->user()->store;
        return view('admin.settings.profile', compact('store'));
    }
    
    /**
     * Show users management page
     */
    public function users()
    {
        $users = User::where('store_id', auth()->user()->store_id)->get();
        return view('admin.settings.users', compact('users'));
    }
    
    /**
     * Show payment settings page
     */
    public function payment()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $paymentSettings = [
            'payment_methods' => [
                'cash' => $settings['payment_methods']['cash'] ?? true,
                'transfer' => $settings['payment_methods']['transfer'] ?? true,
                'qris' => $settings['payment_methods']['qris'] ?? true,
                'ewallet' => $settings['payment_methods']['ewallet'] ?? false,
            ],
            'bank_accounts' => $settings['bank_accounts'] ?? [],
            'qris_image' => $settings['qris_image'] ?? null,
            'ewallet' => [
                'ovo' => $settings['ewallet']['ovo'] ?? false,
                'ovo_number' => $settings['ewallet']['ovo_number'] ?? '',
                'gopay' => $settings['ewallet']['gopay'] ?? false,
                'gopay_number' => $settings['ewallet']['gopay_number'] ?? '',
                'dana' => $settings['ewallet']['dana'] ?? false,
                'dana_number' => $settings['ewallet']['dana_number'] ?? '',
                'linkaja' => $settings['ewallet']['linkaja'] ?? false,
                'linkaja_number' => $settings['ewallet']['linkaja_number'] ?? '',
            ]
        ];
        
        return view('admin.settings.payment', compact('paymentSettings'));
    }
    
    /**
     * Show notification settings page
     */
    public function notification()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $notificationSettings = [
            'low_stock_alert' => $settings['low_stock_alert'] ?? true,
            'monthly_report' => $settings['monthly_report'] ?? true,
            'daily_sales' => $settings['daily_sales'] ?? false,
            'new_order' => $settings['new_order'] ?? true,
            'product_review' => $settings['product_review'] ?? false,
            'notification_email' => $settings['notification_email'] ?? auth()->user()->email,
            'in_app_notifications' => $settings['in_app_notifications'] ?? true,
            'in_app_sound' => $settings['in_app_sound'] ?? true,
        ];
        
        return view('admin.settings.notification', compact('notificationSettings'));
    }
    
    /**
     * Show preferences page
     */
    public function preferences()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $preferences = [
            'currency' => $settings['currency'] ?? 'IDR',
            'timezone' => $settings['timezone'] ?? 'Asia/Jakarta',
            'date_format' => $settings['date_format'] ?? 'd-m-Y',
            'invoice_prefix' => $settings['invoice_prefix'] ?? 'INV',
            'low_stock_alert' => $settings['low_stock_alert'] ?? true,
            'monthly_report' => $settings['monthly_report'] ?? true,
            'theme' => $settings['theme'] ?? 'light',
        ];
        
        return view('admin.settings.preferences', compact('preferences'));
    }
    
    /**
     * Update store information
     */
    public function updateStore(Request $request)
    {
        $store = auth()->user()->store;
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:stores,email,' . $store->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);
        
        $store->update($validated);
        
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Store updated successfully',
                'data' => $store
            ]);
        }
        
        return redirect()->route('admin.settings.profile')
            ->with('success', 'Profil toko berhasil diperbarui');
    }
    
    /**
     * Upload store logo
     */
    public function uploadLogo(Request $request)
    {
        $request->validate([
            'logo' => 'required|image|max:2048'
        ]);
        
        $store = auth()->user()->store;
        
        // Delete old logo if exists
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
        }
        
        $path = $request->file('logo')->store("stores/{$store->id}", 'public');
        $store->logo = $path;
        $store->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Logo uploaded successfully',
            'data' => ['logo_url' => Storage::url($path)]
        ]);
    }
    
    /**
     * Delete store logo
     */
    public function deleteLogo(Request $request)
    {
        $store = auth()->user()->store;
        
        if ($store->logo) {
            Storage::disk('public')->delete($store->logo);
            $store->logo = null;
            $store->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Logo deleted successfully'
        ]);
    }
    
    /**
     * Get users list (AJAX)
     */
    public function getUsers()
    {
        $users = User::where('store_id', auth()->user()->store_id)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json([
            'success' => true,
            'data' => $users
        ]);
    }
    
    /**
     * Create new user
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staff',
            'is_active' => 'boolean'
        ]);
        
        $user = User::create([
            'store_id' => auth()->user()->store_id,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'is_active' => $validated['is_active'] ?? true,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }
    
    /**
     * Update user
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::where('store_id', auth()->user()->store_id)
            ->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:admin,staff',
            'is_active' => 'boolean'
        ]);
        
        $user->update($validated);
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
            $user->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'data' => $user
        ]);
    }
    
    /**
     * Toggle user status
     */
    public function toggleUserStatus($id)
    {
        $user = User::where('store_id', auth()->user()->store_id)
            ->findOrFail($id);
        
        $user->is_active = !$user->is_active;
        $user->save();
        
        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        
        return response()->json([
            'success' => true,
            'message' => "User berhasil {$status}",
            'data' => $user
        ]);
    }
    
    /**
     * Delete user
     */
    public function deleteUser($id)
    {
        $user = User::where('store_id', auth()->user()->store_id)
            ->findOrFail($id);
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete your own account'
            ], 422);
        }
        
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }
    
    /**
     * Get payment settings (AJAX)
     */
    public function getPaymentSettings()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $paymentSettings = [
            'payment_methods' => [
                'cash' => $settings['payment_methods']['cash'] ?? true,
                'transfer' => $settings['payment_methods']['transfer'] ?? true,
                'qris' => $settings['payment_methods']['qris'] ?? true,
                'ewallet' => $settings['payment_methods']['ewallet'] ?? false,
            ],
            'bank_accounts' => $settings['bank_accounts'] ?? [],
            'qris_image' => $settings['qris_image'] ?? null,
            'ewallet' => [
                'ovo' => $settings['ewallet']['ovo'] ?? false,
                'ovo_number' => $settings['ewallet']['ovo_number'] ?? '',
                'gopay' => $settings['ewallet']['gopay'] ?? false,
                'gopay_number' => $settings['ewallet']['gopay_number'] ?? '',
                'dana' => $settings['ewallet']['dana'] ?? false,
                'dana_number' => $settings['ewallet']['dana_number'] ?? '',
                'linkaja' => $settings['ewallet']['linkaja'] ?? false,
                'linkaja_number' => $settings['ewallet']['linkaja_number'] ?? '',
            ]
        ];
        
        return response()->json([
            'success' => true,
            'data' => $paymentSettings
        ]);
    }
    
    /**
     * Update payment settings
     */
    public function updatePaymentSettings(Request $request)
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $settings['payment_methods'] = $request->payment_methods ?? [];
        $settings['bank_accounts'] = $request->bank_accounts ?? [];
        $settings['ewallet'] = $request->ewallet ?? [];
        
        $store->settings = $settings;
        $store->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Payment settings updated successfully'
        ]);
    }
    
    /**
     * Upload QRIS image
     */
    public function uploadQris(Request $request)
    {
        $request->validate([
            'qris' => 'required|image|max:2048'
        ]);
        
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        // Delete old QRIS if exists
        if (isset($settings['qris_image'])) {
            $oldPath = str_replace('/storage/', '', $settings['qris_image']);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
        }
        
        $path = $request->file('qris')->store("stores/{$store->id}/qris", 'public');
        $settings['qris_image'] = Storage::url($path);
        $store->settings = $settings;
        $store->save();
        
        return response()->json([
            'success' => true,
            'message' => 'QRIS uploaded successfully',
            'data' => ['url' => Storage::url($path)]
        ]);
    }
    
    /**
     * Delete QRIS image
     */
    public function deleteQris(Request $request)
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        if (isset($settings['qris_image'])) {
            $oldPath = str_replace('/storage/', '', $settings['qris_image']);
            if (Storage::disk('public')->exists($oldPath)) {
                Storage::disk('public')->delete($oldPath);
            }
            unset($settings['qris_image']);
            $store->settings = $settings;
            $store->save();
        }
        
        return response()->json([
            'success' => true,
            'message' => 'QRIS deleted successfully'
        ]);
    }
    
    /**
     * Get notification settings (AJAX)
     */
    public function getNotificationSettings()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $notificationSettings = [
            'low_stock_alert' => $settings['low_stock_alert'] ?? true,
            'monthly_report' => $settings['monthly_report'] ?? true,
            'daily_sales' => $settings['daily_sales'] ?? false,
            'new_order' => $settings['new_order'] ?? true,
            'product_review' => $settings['product_review'] ?? false,
            'notification_email' => $settings['notification_email'] ?? auth()->user()->email,
            'in_app_notifications' => $settings['in_app_notifications'] ?? true,
            'in_app_sound' => $settings['in_app_sound'] ?? true,
        ];
        
        return response()->json([
            'success' => true,
            'data' => $notificationSettings
        ]);
    }
    
    /**
     * Update notification settings
     */
    public function updateNotificationSettings(Request $request)
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $settings['low_stock_alert'] = $request->low_stock_alert ?? false;
        $settings['monthly_report'] = $request->monthly_report ?? false;
        $settings['daily_sales'] = $request->daily_sales ?? false;
        $settings['new_order'] = $request->new_order ?? false;
        $settings['product_review'] = $request->product_review ?? false;
        $settings['notification_email'] = $request->notification_email ?? auth()->user()->email;
        $settings['in_app_notifications'] = $request->in_app_notifications ?? false;
        $settings['in_app_sound'] = $request->in_app_sound ?? false;
        
        $store->settings = $settings;
        $store->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Notification settings updated successfully'
        ]);
    }
    
    /**
     * Get preferences (AJAX)
     */
    public function getPreferences()
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $preferences = [
            'currency' => $settings['currency'] ?? 'IDR',
            'timezone' => $settings['timezone'] ?? 'Asia/Jakarta',
            'date_format' => $settings['date_format'] ?? 'd-m-Y',
            'invoice_prefix' => $settings['invoice_prefix'] ?? 'INV',
            'low_stock_alert' => $settings['low_stock_alert'] ?? true,
            'monthly_report' => $settings['monthly_report'] ?? true,
            'theme' => $settings['theme'] ?? 'light',
        ];
        
        return response()->json([
            'success' => true,
            'data' => $preferences
        ]);
    }
    
    /**
     * Update preferences
     */
    public function updatePreferences(Request $request)
    {
        $store = auth()->user()->store;
        $settings = $store->settings ?? [];
        
        $settings['currency'] = $request->currency ?? 'IDR';
        $settings['timezone'] = $request->timezone ?? 'Asia/Jakarta';
        $settings['date_format'] = $request->date_format ?? 'd-m-Y';
        $settings['invoice_prefix'] = $request->invoice_prefix ?? 'INV';
        $settings['low_stock_alert'] = $request->low_stock_alert ?? false;
        $settings['monthly_report'] = $request->monthly_report ?? false;
        $settings['theme'] = $request->theme ?? 'light';
        
        $store->settings = $settings;
        $store->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Preferences updated successfully'
        ]);
    }
}