// resources/js/api/axiosConfig.js
import axios from 'axios';
import initializeCsrf from './initializeCsrf';

// Function to retrieve token dynamically
const getToken = () => {
    const token = localStorage.getItem('token');
    if (token) return token;

    const envToken = import.meta.env.VITE_SANCTUM_TOKEN;
    if (envToken) {
        localStorage.setItem('token', envToken);
        return envToken;
    }

    console.warn('No token found in localStorage or environment variables.');
    return null;
};

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
    withCredentials: true,
});


privateClient.interceptors.request.use(
    async (config) => {
        await initializeCsrf(); 
        return config;
    },
    (error) => Promise.reject(error)
);

privateClient.interceptors.request.use(
    (config) => {
        const token = getToken();
        if (token) {
            config.headers.Authorization = `Bearer ${token}`;
        }
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
