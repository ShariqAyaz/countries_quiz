// resources/js/api/axiosConfig.js
import axios from 'axios';
import initializeCsrf from './initializeCsrf';

// Public client
export const publicClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
    },
    withCredentials: true, 
});

// Protected client
export const privateClient = axios.create({
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
    },
    withCredentials: true, // Enable sending cookies
});

// Interceptor & initialize CSRF before each request
privateClient.interceptors.request.use(
    async (config) => {
        await initializeCsrf(); 
        return config;
    },
    (error) => Promise.reject(error)
);

// privateClient.interceptors.response.use(
//     (response) => response,
//     (error) => {
//         if (error.response && error.response.status === 401) {
//             // Handle unauthorized access, e.g., redirect to login
//             window.location.href = '/login';
//         }
//         return Promise.reject(error);
//     }
// );
