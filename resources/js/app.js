// resources/js/app.js
import './bootstrap';
import Alpine from 'alpinejs';
import Chart from 'chart.js/auto';

// ============================================
// THEME MANAGEMENT - 100% AUTO FOLLOW CHROME
// ============================================

class ThemeManager {
    constructor() {
        this.html = document.documentElement;
        this.mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        
        // Apply initial theme
        this.applyTheme(this.mediaQuery.matches);
        
        // Listen for Chrome theme changes
        this.listenForChanges();
    }
    
    /**
     * Apply theme based on system preference
     */
    applyTheme(isDark) {
        if (isDark) {
            this.html.classList.add('dark');
        } else {
            this.html.classList.remove('dark');
        }
        
        // Update meta theme-color for browser UI
        this.updateMetaThemeColor(isDark);
        
        // Dispatch custom event for Alpine.js components
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: isDark ? 'dark' : 'light' } 
        }));
    }
    
    /**
     * Update meta theme-color tag for browser UI
     */
    updateMetaThemeColor(isDark) {
        let meta = document.querySelector('meta[name="theme-color"]');
        if (!meta) {
            meta = document.createElement('meta');
            meta.name = 'theme-color';
            document.head.appendChild(meta);
        }
        meta.content = isDark ? '#0A0B0E' : '#FFFFFF';
    }
    
    /**
     * Listen for system preference changes (Chrome Customize)
     */
    listenForChanges() {
        // Modern way - using addEventListener
        if (this.mediaQuery.addEventListener) {
            this.mediaQuery.addEventListener('change', (e) => {
                this.applyTheme(e.matches);
            });
        } 
        // Fallback for older browsers
        else if (this.mediaQuery.addListener) {
            this.mediaQuery.addListener((e) => {
                this.applyTheme(e.matches);
            });
        }
    }
    
    /**
     * Get current theme (for Alpine store)
     */
    getCurrentTheme() {
        return this.mediaQuery.matches ? 'dark' : 'light';
    }
}

// ============================================
// GLOBAL HELPERS
// ============================================

/**
 * Format number to Indonesian Rupiah
 */
window.formatRupiah = (number) => {
    if (!number && number !== 0) return 'Rp 0';
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0,
        maximumFractionDigits: 0
    }).format(number);
};

/**
 * Format number with thousand separator
 */
window.formatNumber = (number) => {
    if (!number && number !== 0) return '0';
    return new Intl.NumberFormat('id-ID').format(number);
};

/**
 * Format date with time
 */
window.formatDate = (date) => {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

/**
 * Format date only (no time)
 */
window.formatDateOnly = (date) => {
    if (!date) return '-';
    const d = new Date(date);
    return d.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
};

/**
 * Show toast notification
 */
window.showToast = (message, type = 'success', duration = 3000) => {
    const existingToast = document.querySelector('.toast-notification');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-notification';
    
    const typeClasses = {
        success: 'bg-success text-white',
        error: 'bg-error text-white',
        warning: 'bg-warning text-black',
        info: 'bg-info text-white'
    };
    
    const icons = {
        success: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>`,
        error: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>`,
        warning: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                 </svg>`,
        info: `<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                 </svg>`
    };
    
    toast.innerHTML = `
        <div class="flex items-center gap-3 p-4 rounded-lg shadow-lg ${typeClasses[type] || typeClasses.info} max-w-sm">
            ${icons[type] || icons.info}
            <span class="flex-1 text-sm font-medium">${message}</span>
            <button onclick="this.closest('.toast-notification').remove()" class="flex-shrink-0 opacity-70 hover:opacity-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    `;
    
    toast.style.cssText = `
        position: fixed;
        bottom: 1.5rem;
        right: 1.5rem;
        z-index: 9999;
        animation: slideUp 0.3s ease-out;
        max-width: 24rem;
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        if (toast.parentNode) {
            toast.style.opacity = '0';
            toast.style.transition = 'opacity 0.3s ease';
            setTimeout(() => {
                if (toast.parentNode) toast.remove();
            }, 300);
        }
    }, duration);
};

/**
 * Debounce function for search inputs
 */
window.debounce = (func, wait) => {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

/**
 * Escape HTML to prevent XSS
 */
window.escapeHtml = (text) => {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
};

// ============================================
// THEME INITIALIZATION
// ============================================

// Initialize ThemeManager when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    // Initialize theme manager (auto-follow Chrome)
    window.themeManager = new ThemeManager();
    
    // Handle CSRF token
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    if (token) {
        window.axios = window.axios || {};
        window.axios.defaults = window.axios.defaults || {};
        window.axios.defaults.headers = window.axios.defaults.headers || {};
        window.axios.defaults.headers.common = window.axios.defaults.headers.common || {};
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token;
    }
});

// ============================================
// EXPOSE FOR ALPINE.JS
// ============================================

// Make theme available in Alpine components (auto-sync)
document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        current: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light',
        
        init() {
            // Listen for theme changes from Chrome
            document.addEventListener('themeChanged', (e) => {
                this.current = e.detail.theme;
            });
            
            // Also listen directly to media query (backup)
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                this.current = e.matches ? 'dark' : 'light';
            });
        },
        
        isDark() {
            return this.current === 'dark';
        },
        
        isLight() {
            return this.current === 'light';
        }
    });
});

// ============================================
// START ALPINE
// ============================================

Alpine.start();

// ============================================
// EXPOSE HELPER FUNCTIONS
// ============================================

// Expose for global use
window.getCurrentTheme = () => {
    return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

// Export for module usage
export default {
    ThemeManager,
    getCurrentTheme: window.getCurrentTheme
};