// resources/js/theme.js

class ThemeManager {
    constructor() {
        this.html = document.documentElement;
        this.storageKey = 'theme-preference';
        this.theme = this.getInitialTheme();
        this.applyTheme(this.theme);
        this.listenForChanges();
    }
    
    /**
     * Get initial theme from localStorage or system preference
     */
    getInitialTheme() {
        // Check localStorage first
        const stored = localStorage.getItem(this.storageKey);
        if (stored === 'dark' || stored === 'light') {
            return stored;
        }
        
        // Check system preference
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            return 'dark';
        }
        
        return 'light';
    }
    
    /**
     * Apply theme to html element
     */
    applyTheme(theme) {
        if (theme === 'dark') {
            this.html.classList.add('dark');
        } else {
            this.html.classList.remove('dark');
        }
        
        this.theme = theme;
        localStorage.setItem(this.storageKey, theme);
        
        // Dispatch custom event for components
        document.dispatchEvent(new CustomEvent('themeChanged', { 
            detail: { theme: theme } 
        }));
    }
    
    /**
     * Toggle between light and dark
     */
    toggle() {
        const newTheme = this.theme === 'light' ? 'dark' : 'light';
        this.applyTheme(newTheme);
    }
    
    /**
     * Listen for system preference changes
     */
    listenForChanges() {
        // Listen for system preference changes
        if (window.matchMedia) {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', (e) => {
                // Only apply if user hasn't manually set a preference
                if (!localStorage.getItem(this.storageKey)) {
                    this.applyTheme(e.matches ? 'dark' : 'light');
                }
            });
        }
        
        // Listen for storage changes from other tabs
        window.addEventListener('storage', (e) => {
            if (e.key === this.storageKey) {
                const newTheme = e.newValue;
                if (newTheme === 'dark' || newTheme === 'light') {
                    this.applyTheme(newTheme);
                }
            }
        });
    }
}

// Initialize theme manager
document.addEventListener('DOMContentLoaded', () => {
    window.themeManager = new ThemeManager();
});

// Expose toggle function globally
window.toggleTheme = function() {
    if (window.themeManager) {
        window.themeManager.toggle();
    }
};