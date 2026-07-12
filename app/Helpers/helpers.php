<?php
// app/Helpers/helpers.php

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

if (!function_exists('format_rupiah')) {
    /**
     * Format number to Indonesian Rupiah currency.
     */
    function format_rupiah($number, $withSymbol = true): string
    {
        $formatted = number_format($number, 0, ',', '.');
        return $withSymbol ? 'Rp ' . $formatted : $formatted;
    }
}

if (!function_exists('format_date_indonesia')) {
    /**
     * Format date to Indonesian format.
     */
    function format_date_indonesia($date, $format = 'd F Y'): string
    {
        if (!$date) return '-';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        
        $months = [
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];
        
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];
        
        $formatted = $carbon->format($format);
        $formatted = str_replace(array_keys($months), $months, $formatted);
        $formatted = str_replace(array_keys($days), $days, $formatted);
        
        return $formatted;
    }
}

if (!function_exists('format_datetime_indonesia')) {
    /**
     * Format datetime to Indonesian format.
     */
    function format_datetime_indonesia($date): string
    {
        if (!$date) return '-';
        
        $carbon = $date instanceof Carbon ? $date : Carbon::parse($date);
        return $carbon->format('d/m/Y H:i');
    }
}

if (!function_exists('generate_unique_slug')) {
    /**
     * Generate unique slug for a model.
     */
    function generate_unique_slug($model, $name, $field = 'slug'): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;
        
        while ($model::where($field, $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        
        return $slug;
    }
}

if (!function_exists('get_stock_badge_class')) {
    /**
     * Get stock status badge class.
     */
    function get_stock_badge_class($stock, $minStockAlert): string
    {
        if ($stock <= 0) {
            return 'badge-error';
        }
        
        if ($stock <= $minStockAlert) {
            return 'badge-warning';
        }
        
        return 'badge-success';
    }
}

if (!function_exists('get_stock_status_text')) {
    /**
     * Get stock status text.
     */
    function get_stock_status_text($stock, $minStockAlert): string
    {
        if ($stock <= 0) {
            return 'Stok Habis';
        }
        
        if ($stock <= $minStockAlert) {
            return 'Stok Menipis';
        }
        
        return 'Stok Aman';
    }
}

if (!function_exists('get_payment_method_label')) {
    /**
     * Get payment method label.
     */
    function get_payment_method_label($method): string
    {
        return match($method) {
            'cash' => 'Tunai',
            'transfer' => 'Transfer Bank',
            'qris' => 'QRIS',
            default => ucfirst($method)
        };
    }
}

if (!function_exists('get_transaction_status_label')) {
    /**
     * Get transaction status label.
     */
    function get_transaction_status_label($status): string
    {
        return match($status) {
            'completed' => 'Selesai',
            'pending' => 'Pending',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($status)
        };
    }
}

if (!function_exists('get_transaction_status_badge')) {
    /**
     * Get transaction status badge class.
     */
    function get_transaction_status_badge($status): string
    {
        return match($status) {
            'completed' => 'badge-success',
            'pending' => 'badge-warning',
            'cancelled' => 'badge-error',
            default => 'badge-secondary'
        };
    }
}

if (!function_exists('truncate_text')) {
    /**
     * Truncate text to specified length.
     */
    function truncate_text($text, $length = 100, $ending = '...'): string
    {
        if (strlen($text) <= $length) {
            return $text;
        }
        
        return substr($text, 0, $length) . $ending;
    }
}

if (!function_exists('get_gravatar_url')) {
    /**
     * Get Gravatar URL for email.
     */
    function get_gravatar_url($email, $size = 80): string
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/{$hash}?s={$size}&d=mp";
    }
}

if (!function_exists('calculate_percentage_change')) {
    /**
     * Calculate percentage change between two values.
     */
    function calculate_percentage_change($current, $previous): float
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }
        
        return (($current - $previous) / $previous) * 100;
    }
}

if (!function_exists('format_percentage')) {
    /**
     * Format percentage with + or - sign.
     */
    function format_percentage($percentage, $decimals = 1): string
    {
        $sign = $percentage >= 0 ? '+' : '';
        return $sign . number_format($percentage, $decimals) . '%';
    }
}

if (!function_exists('get_trend_icon')) {
    /**
     * Get trend icon based on percentage.
     */
    function get_trend_icon($percentage): string
    {
        if ($percentage > 0) {
            return 'trending-up';
        }
        
        if ($percentage < 0) {
            return 'trending-down';
        }
        
        return 'trending-flat';
    }
}

if (!function_exists('get_trend_color')) {
    /**
     * Get trend color based on percentage.
     */
    function get_trend_color($percentage): string
    {
        if ($percentage > 0) {
            return 'text-success';
        }
        
        if ($percentage < 0) {
            return 'text-error';
        }
        
        return 'text-text-secondary';
    }
}

if (!function_exists('array_to_select_options')) {
    /**
     * Convert array to select options HTML.
     */
    function array_to_select_options($array, $selected = null, $emptyOption = false): string
    {
        $html = '';
        
        if ($emptyOption) {
            $html .= '<option value="">Pilih...</option>';
        }
        
        foreach ($array as $value => $label) {
            $isSelected = ($selected == $value) ? 'selected' : '';
            $html .= "<option value=\"{$value}\" {$isSelected}>{$label}</option>";
        }
        
        return $html;
    }
}

if (!function_exists('generate_random_color')) {
    /**
     * Generate random hex color.
     */
    function generate_random_color(): string
    {
        return sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
}

if (!function_exists('get_file_size_human')) {
    /**
     * Convert bytes to human readable format.
     */
    function get_file_size_human($bytes, $decimals = 2): string
    {
        $size = ['B', 'KB', 'MB', 'GB', 'TB'];
        $factor = floor((strlen($bytes) - 1) / 3);
        
        return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . ' ' . $size[$factor];
    }
}

if (!function_exists('is_current_route')) {
    /**
     * Check if current route matches given name.
     */
    function is_current_route($routeName, $exact = false): bool
    {
        $current = request()->route()->getName();
        
        if ($exact) {
            return $current === $routeName;
        }
        
        return Str::startsWith($current, $routeName);
    }
}

if (!function_exists('get_active_nav_class')) {
    /**
     * Get active class for navigation item.
     */
    function get_active_nav_class($routeName, $activeClass = 'active', $defaultClass = ''): string
    {
        return is_current_route($routeName) ? $activeClass : $defaultClass;
    }
}

if (!function_exists('safe_json_encode')) {
    /**
     * Safely encode data to JSON.
     */
    function safe_json_encode($data, $options = JSON_PRETTY_PRINT): string
    {
        try {
            return json_encode($data, $options | JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return json_encode(['error' => 'Failed to encode data']);
        }
    }
}

if (!function_exists('safe_json_decode')) {
    /**
     * Safely decode JSON string.
     */
    function safe_json_decode($json, $assoc = true)
    {
        try {
            return json_decode($json, $assoc, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
            return null;
        }
    }
}