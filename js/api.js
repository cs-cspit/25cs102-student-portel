/**
 * StudentHub - Reusable AJAX Fetch API Client (Practical 13)
 * Provides asynchronous wrapper methods for RESTful JSON API operations.
 */

const StudentHubAPI = {
    /**
     * GET Request
     */
    async get(endpoint, params = {}) {
        const url = new URL(endpoint, window.location.origin + window.location.pathname.replace(/\/[^\/]*$/, '/'));
        Object.keys(params).forEach(key => {
            if (params[key] !== undefined && params[key] !== null) {
                url.searchParams.append(key, params[key]);
            }
        });

        try {
            const response = await fetch(url.toString(), {
                method: 'GET',
                headers: { 'Accept': 'application/json' }
            });
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        } catch (error) {
            console.error('API GET Exception:', error);
            return { ok: false, status: 500, error: error.message };
        }
    },

    /**
     * POST Request (Create)
     */
    async post(endpoint, payload) {
        try {
            const response = await fetch(endpoint, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        } catch (error) {
            console.error('API POST Exception:', error);
            return { ok: false, status: 500, error: error.message };
        }
    },

    /**
     * PUT Request (Update)
     */
    async put(endpoint, payload) {
        try {
            const response = await fetch(endpoint, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        } catch (error) {
            console.error('API PUT Exception:', error);
            return { ok: false, status: 500, error: error.message };
        }
    },

    /**
     * DELETE Request (Remove)
     */
    async delete(endpoint, payload = {}) {
        try {
            const response = await fetch(endpoint, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            return { ok: response.ok, status: response.status, data };
        } catch (error) {
            console.error('API DELETE Exception:', error);
            return { ok: false, status: 500, error: error.message };
        }
    }
};
