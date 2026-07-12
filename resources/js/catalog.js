// resources/js/catalog.js
class Catalog {
    constructor() {
        this.currentPage = 1;
        this.filters = {
            search: '',
            category: '',
            min_price: '',
            max_price: '',
            sort: 'name'
        };
        this.init();
    }
    
    init() {
        this.bindEvents();
        this.loadProducts();
    }
    
    bindEvents() {
        // Search input
        const searchInput = document.getElementById('searchProduct');
        if (searchInput) {
            searchInput.addEventListener('input', this.debounce(() => {
                this.filters.search = searchInput.value;
                this.currentPage = 1;
                this.loadProducts();
            }, 500));
        }
        
        // Category filter
        const categorySelect = document.getElementById('categoryFilter');
        if (categorySelect) {
            categorySelect.addEventListener('change', (e) => {
                this.filters.category = e.target.value;
                this.currentPage = 1;
                this.loadProducts();
            });
        }
        
        // Price filters
        const minPrice = document.getElementById('minPrice');
        const maxPrice = document.getElementById('maxPrice');
        if (minPrice && maxPrice) {
            minPrice.addEventListener('change', () => {
                this.filters.min_price = minPrice.value;
                this.loadProducts();
            });
            maxPrice.addEventListener('change', () => {
                this.filters.max_price = maxPrice.value;
                this.loadProducts();
            });
        }
        
        // Sort filter
        const sortSelect = document.getElementById('sortBy');
        if (sortSelect) {
            sortSelect.addEventListener('change', (e) => {
                this.filters.sort = e.target.value;
                this.loadProducts();
            });
        }
    }
    
    async loadProducts() {
        const params = new URLSearchParams({
            page: this.currentPage,
            ...this.filters
        });
        
        try {
            const response = await axios.get(`/api/catalog/products?${params}`);
            if (response.data.success) {
                this.renderProducts(response.data.data);
                this.renderPagination(response.data.data);
            }
        } catch (error) {
            console.error('Failed to load products:', error);
            window.showToast('Gagal memuat produk', 'error');
        }
    }
    
    renderProducts(data) {
        const container = document.getElementById('productsContainer');
        if (!container) return;
        
        if (!data.data || data.data.length === 0) {
            container.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <p class="text-text-secondary">Tidak ada produk yang ditemukan</p>
                </div>
            `;
            return;
        }
        
        container.innerHTML = data.data.map(product => `
            <div class="card product-card">
                <div class="aspect-square bg-light-surface dark:bg-dark-surface rounded-lg m-4 flex items-center justify-center">
                    ${product.image_url 
                        ? `<img src="${product.image_url}" alt="${product.name}" class="w-full h-full object-cover rounded-lg">`
                        : `<svg class="w-16 h-16 text-text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>`
                    }
                </div>
                <div class="p-4">
                    <h3 class="font-semibold mb-2">${this.escapeHtml(product.name)}</h3>
                    <p class="text-text-secondary text-sm mb-2 line-clamp-2">${this.escapeHtml(product.description || 'Tidak ada deskripsi')}</p>
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-xl font-bold text-accent">${window.formatRupiah(product.price)}</span>
                        <span class="text-sm text-text-secondary">Stok: ${product.stock}</span>
                    </div>
                    <button onclick="catalog.addToCart(${product.id})" class="btn-primary w-full">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1.5 6M17 13l1.5 6M9 21h6"/>
                        </svg>
                        Tambah ke Keranjang
                    </button>
                </div>
            </div>
        `).join('');
    }
    
    renderPagination(data) {
        const container = document.getElementById('paginationContainer');
        if (!container) return;
        
        if (data.last_page <= 1) {
            container.innerHTML = '';
            return;
        }
        
        let html = '<div class="flex justify-center items-center gap-2">';
        
        // Previous button
        if (data.current_page > 1) {
            html += `<button onclick="catalog.goToPage(${data.current_page - 1})" class="px-3 py-1 border rounded hover:bg-light-surface">
                        Sebelumnya
                    </button>`;
        }
        
        // Page numbers
        const startPage = Math.max(1, data.current_page - 2);
        const endPage = Math.min(data.last_page, data.current_page + 2);
        
        for (let i = startPage; i <= endPage; i++) {
            html += `<button onclick="catalog.goToPage(${i})" 
                           class="px-3 py-1 border rounded ${i === data.current_page ? 'bg-accent text-white' : 'hover:bg-light-surface'}">
                        ${i}
                    </button>`;
        }
        
        // Next button
        if (data.current_page < data.last_page) {
            html += `<button onclick="catalog.goToPage(${data.current_page + 1})" class="px-3 py-1 border rounded hover:bg-light-surface">
                        Selanjutnya
                    </button>`;
        }
        
        html += '</div>';
        container.innerHTML = html;
    }
    
    goToPage(page) {
        this.currentPage = page;
        this.loadProducts();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
    
    async addToCart(productId) {
        try {
            const response = await axios.post('/api/cart/add', { product_id: productId, quantity: 1 });
            if (response.data.success) {
                window.showToast('Produk ditambahkan ke keranjang', 'success');
                this.updateCartCount();
            }
        } catch (error) {
            if (error.response?.status === 401) {
                window.showToast('Silakan login terlebih dahulu', 'warning');
                setTimeout(() => {
                    window.location.href = '/login';
                }, 1500);
            } else {
                window.showToast(error.response?.data?.message || 'Gagal menambahkan ke keranjang', 'error');
            }
        }
    }
    
    async updateCartCount() {
        try {
            const response = await axios.get('/api/cart/count');
            if (response.data.success) {
                const badge = document.getElementById('cartCount');
                if (badge) {
                    const count = response.data.data.count;
                    if (count > 0) {
                        badge.textContent = count;
                        badge.classList.remove('hidden');
                    } else {
                        badge.classList.add('hidden');
                    }
                }
            }
        } catch (error) {
            console.error('Failed to update cart count:', error);
        }
    }
    
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
    
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
}

// Initialize catalog
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('catalog-app')) {
        window.catalog = new Catalog();
    }
});