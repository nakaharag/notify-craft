import { defineStore } from 'pinia';
import api from '@/api';

export const useAuthStore = defineStore('auth', {
    state: () => ({ user: null as User|null, token: '' }),
    actions: {
        async login(credentials) { /* POST /api/login */ },
        async register(data) { /* POST /api/register */ },
        async logout()    { /* POST /api/logout */ },
        async fetchUser() { /* GET /api/user */ }
    }
});
