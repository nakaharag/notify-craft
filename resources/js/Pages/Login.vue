<template>
    <AuthLayout>
            <h2>Login</h2>
            <form @submit.prevent="login" class="form">
                <label for="email">Email</label>
                <input
                    id="email"
                    v-model="email"
                    type="email"
                    placeholder="you@example.com"
                    required
                />

                <label for="password">Password</label>
                <input
                    id="password"
                    v-model="password"
                    type="password"
                    placeholder="••••••••"
                    required
                />

                <div class="action-buttons">
                    <button type="submit" class="btn-primary">Login</button>
                    <button type="button" @click="loginAnonymous" class="btn-secondary">
                        Login as Anonymous
                    </button>
                </div>
            </form>
    </AuthLayout>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import AuthLayout from '../layouts/AuthLayout.vue'
import { useAuthStore } from '../stores/auth'

const email = ref('')
const password = ref('')
const authStore = useAuthStore()

function login() {
    Inertia.post('/login', { email: email.value, password: password.value })
}

async function loginAnonymous() {
    try {
        await authStore.loginAnonymous();
        Inertia.visit('/');
    } catch (error) {
        console.error('Anonymous login failed:', error);
    }
}
</script>
