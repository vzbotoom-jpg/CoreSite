// resources/js/api/reports.js
const ReportAPI = {
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
    
    getMonthlyReport(month) {
        const query = month ? `?month=${month}` : '';
        return this.request(`/reports/monthly${query}`);
    },
    
    getInventoryReport() {
        return this.request('/reports/inventory');
    },
    
    getSalesReport(params = {}) {
        const queryString = new URLSearchParams(params).toString();
        return this.request(`/reports/sales?${queryString}`);
    },
    
    getDashboardStats() {
        return this.request('/dashboard-stats');
    }
};

export default ReportAPI;