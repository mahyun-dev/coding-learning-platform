/**
 * Main JavaScript for Coding Learning Platform
 */

// Global app object
const App = {
    apiBaseUrl: '/api',
    
    /**
     * Initialize the application
     */
    init() {
        this.checkAuth();
        this.setupEventListeners();
    },
    
    /**
     * Check authentication status
     */
    async checkAuth() {
        try {
            const response = await fetch(`${this.apiBaseUrl}/auth.php?action=check`);
            const data = await response.json();
            
            if (data.success && data.data.logged_in) {
                console.log('User authenticated:', data.data.username);
            }
        } catch (error) {
            console.error('Auth check failed:', error);
        }
    },
    
    /**
     * Setup global event listeners
     */
    setupEventListeners() {
        // Add any global event listeners here
    },
    
    /**
     * Show alert message
     */
    showAlert(message, type = 'info') {
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
        alertDiv.role = 'alert';
        alertDiv.innerHTML = `
            ${this.escapeHtml(message)}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        const container = document.querySelector('main .container');
        if (container) {
            container.insertBefore(alertDiv, container.firstChild);
            
            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                alertDiv.classList.remove('show');
                setTimeout(() => alertDiv.remove(), 150);
            }, 5000);
        }
    },
    
    /**
     * Show loading spinner
     */
    showLoading(element) {
        const spinner = document.createElement('div');
        spinner.className = 'text-center my-4 loading-spinner';
        spinner.innerHTML = '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>';
        element.innerHTML = '';
        element.appendChild(spinner);
    },
    
    /**
     * Hide loading spinner
     */
    hideLoading(element) {
        const spinner = element.querySelector('.loading-spinner');
        if (spinner) {
            spinner.remove();
        }
    },
    
    /**
     * Escape HTML to prevent XSS
     */
    escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    },
    
    /**
     * Format date
     */
    formatDate(dateString) {
        const date = new Date(dateString);
        return date.toLocaleDateString('ko-KR', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit'
        });
    },
    
    /**
     * Get difficulty badge HTML
     */
    getDifficultyBadge(difficulty) {
        const badges = {
            'easy': 'badge-easy',
            'medium': 'badge-medium',
            'hard': 'badge-hard'
        };
        
        return `<span class="badge ${badges[difficulty] || 'bg-secondary'}">${difficulty}</span>`;
    }
};

/**
 * Authentication functions
 */
const Auth = {
    /**
     * Login user
     */
    async login(username, password) {
        try {
            const formData = new FormData();
            formData.append('action', 'login');
            formData.append('username', username);
            formData.append('password', password);
            
            const response = await fetch(`${App.apiBaseUrl}/auth.php`, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                App.showAlert('Login successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard.php';
                }, 1500);
            } else {
                App.showAlert(data.message, 'danger');
            }
            
            return data;
        } catch (error) {
            console.error('Login error:', error);
            App.showAlert('Login failed. Please try again.', 'danger');
            return { success: false };
        }
    },
    
    /**
     * Register new user
     */
    async register(username, email, password, confirmPassword) {
        try {
            const formData = new FormData();
            formData.append('action', 'register');
            formData.append('username', username);
            formData.append('email', email);
            formData.append('password', password);
            formData.append('confirm_password', confirmPassword);
            
            const response = await fetch(`${App.apiBaseUrl}/auth.php`, {
                method: 'POST',
                body: formData
            });
            
            const data = await response.json();
            
            if (data.success) {
                App.showAlert('Registration successful! Redirecting...', 'success');
                setTimeout(() => {
                    window.location.href = '/dashboard.php';
                }, 1500);
            } else {
                App.showAlert(data.message, 'danger');
            }
            
            return data;
        } catch (error) {
            console.error('Registration error:', error);
            App.showAlert('Registration failed. Please try again.', 'danger');
            return { success: false };
        }
    },
    
    /**
     * Logout user
     */
    async logout() {
        try {
            const response = await fetch(`${App.apiBaseUrl}/auth.php?action=logout`);
            const data = await response.json();
            
            if (data.success) {
                window.location.href = '/index.php';
            }
        } catch (error) {
            console.error('Logout error:', error);
        }
    }
};

/**
 * Problems functions
 */
const Problems = {
    /**
     * Get list of problems
     */
    async getList(filters = {}) {
        try {
            const queryParams = new URLSearchParams(filters);
            const response = await fetch(`${App.apiBaseUrl}/problems.php?action=list&${queryParams}`);
            const data = await response.json();
            
            if (data.success) {
                return data.data;
            } else {
                App.showAlert(data.message, 'danger');
                return null;
            }
        } catch (error) {
            console.error('Get problems error:', error);
            App.showAlert('Failed to load problems', 'danger');
            return null;
        }
    },
    
    /**
     * Get single problem
     */
    async get(problemId) {
        try {
            const response = await fetch(`${App.apiBaseUrl}/problems.php?action=get&id=${problemId}`);
            const data = await response.json();
            
            if (data.success) {
                return data.data.problem;
            } else {
                App.showAlert(data.message, 'danger');
                return null;
            }
        } catch (error) {
            console.error('Get problem error:', error);
            App.showAlert('Failed to load problem', 'danger');
            return null;
        }
    }
};

/**
 * Logout function (global)
 */
function logout() {
    if (confirm('Are you sure you want to logout?')) {
        Auth.logout();
    }
}

// Initialize app when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    App.init();
});
