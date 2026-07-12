// resources/js/api/products.js
const API = {
    baseUrl: '/api/v1',
    
    headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
    },
    
    async request(endpoint, options = {}) {
        const token = localStorage.getItem('auth_token');
        if (token) {
            this.headers['Authorization'] = `Bearer ${token}`;
        }
        
        const response = await fetch(`${this.baseUrl}${endpoint}`, {
            ...options,
            headers: this.headers
        });
        
        if (response.status === 401) {
            localStorage.removeItem('auth_token');
            window.location.href = '/login';
            return null;
        }
        
        return response.json();
    },
    
    // Product API
    getProducts(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/products?${queryString}`);
    },
    
    getProduct(id) {
        return this.request(`/products/${id}`);
    },
    
    createProduct(data) {
        return this.request('/products', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },
    
    updateProduct(id, data) {
        return this.request(`/products/${id}`, {
            method: 'PUT',
            body: JSON.stringify(data)
        });
    },
    
    deleteProduct(id) {
        return this.request(`/products/${id}`, {
            method: 'DELETE'
        });
    },
    
    adjustStock(id, data) {
        return this.request(`/products/${id}/adjust-stock`, {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },
    
    // Category API
    getCategories() {
        return this.request('/categories');
    },
    
    createCategory(data) {
        return this.request('/categories', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },
    
    // Inventory Logs
    getInventoryLogs(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/inventory-logs?${queryString}`);
    }
};

export default API;