// resources/js/api/transactions.js
const TransactionAPI = {
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
    
    // Transaction API
    getTransactions(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/transactions?${queryString}`);
    },
    
    getTransaction(id) {
        return this.request(`/transactions/${id}`);
    },
    
    createTransaction(data) {
        return this.request('/transactions', {
            method: 'POST',
            body: JSON.stringify(data)
        });
    },
    
    cancelTransaction(id) {
        return this.request(`/transactions/${id}/cancel`, {
            method: 'POST'
        });
    },
    
    getTransactionSummary(period = 'today') {
        return this.request(`/transactions-summary?period=${period}`);
    },
    
    getInvoice(id) {
        return this.request(`/transactions/${id}/invoice`);
    }
};

export default TransactionAPI;