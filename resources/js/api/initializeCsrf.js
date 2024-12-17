// resources/js/api/initializeCsrf.js
import { publicClient } from '@/api/axiosConfig';

const initializeCsrf = async () => {
    try {
        await publicClient.get('/sanctum/csrf-cookie');
    } catch (error) {
        console.error('Failed to initialize CSRF protection:', error);
    }
};

export default initializeCsrf;
