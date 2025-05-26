import { defineStore } from 'pinia';
import axios from 'axios';
import type { User, LoginCredentials } from '../types';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null as User | null,
        loading: false,
        error: null as string | null,
    }),

    getters: {
        isAuthenticated: (s) => !!s.user,
        isAnonymous:    (s) => s.user?.email.startsWith('anonymous+') || false,
    },

    actions: {
        async init() {
            axios.defaults.withCredentials = true;

            try {
                await axios.get('/sanctum/csrf-cookie');
            } catch (e) {
                console.error('CSRF cookie fetch failed', e);
            }

            await this.fetchUser();
        },

        async fetchUser() {
            try {
                const { data } = await axios.get('/api/user');
                this.user = data.data;
            } catch {
                this.user = null;
            }
        },

        async login(creds: LoginCredentials) {
            this.loading = true; this.error = null;
            await axios.get('/sanctum/csrf-cookie');       // obtém CSRF cookie
            try {
                const { data } = await axios.post('/api/login', creds);
                this.user = data.user;
            } catch (e: any) {
                this.error = e.response?.data?.message || 'Login failed';
                throw e;
            } finally {
                this.loading = false;
            }
        },

        async loginAnonymous() {
            this.loading = true; this.error = null;
            await axios.get('/sanctum/csrf-cookie');
            try {
                const { data } = await axios.post('/api/login/anonymous');
                this.user = data.user;
                console.log('Anonymous user logged in:', this.user);
            } catch (e: any) {
                this.error = e.response?.data?.message || 'Anonymous login failed';
                throw e;
            } finally {
                this.loading = false;
            }
        },

        async logout() {
            await axios.post('/api/logout');
            this.user = null;
            window.location.href = '/login';
        },
    },
});
