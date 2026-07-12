// resources/js/bootstrap.js
import axios from 'axios';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Add response interceptor for error handling
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response?.status === 401) {
            // Unauthorized - redirect to login
            if (!window.location.pathname.includes('/login')) {
                window.location.href = '/login';
            }
        } else if (error.response?.status === 403) {
            window.showToast('Anda tidak memiliki akses ke halaman ini', 'error');
        } else if (error.response?.status === 500) {
            window.showToast('Terjadi kesalahan server. Silakan coba lagi nanti.', 'error');
        }
        return Promise.reject(error);
    }
);

// Add request interceptor for loading state
let loadingCount = 0;

window.axios.interceptors.request.use(config => {
    loadingCount++;
    const loader = document.getElementById('global-loader');
    if (loader) loader.style.display = 'flex';
    return config;
});

window.axios.interceptors.response.use(
    response => {
        loadingCount--;
        if (loadingCount === 0) {
            const loader = document.getElementById('global-loader');
            if (loader) loader.style.display = 'none';
        }
        return response;
    },
    error => {
        loadingCount--;
        if (loadingCount === 0) {
            const loader = document.getElementById('global-loader');
            if (loader) loader.style.display = 'none';
        }
        return Promise.reject(error);
    }
);