<script setup lang="ts">
import { computed } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { useAuthStore } from '../stores/auth'

const authStore = useAuthStore()
const hasUser = computed(() => authStore.isAuthenticated)
const isAnonymous = computed(() => authStore.isAnonymous)

const userName = computed(() =>
    isAnonymous.value
        ? 'Anonymous'
        : authStore.user?.name ?? ''
)

const userInitials = computed(() =>
    isAnonymous.value
        ? 'A'
        : (authStore.user?.name || '')
        .split(' ')
        .map(n => n[0])
        .join('')
        .toUpperCase() || ''
)

function toLogin() {
    Inertia.visit('/login')
}

async function loginAnonymous() {
    try {
        await authStore.loginAnonymous()
        window.location.reload()
    } catch (error) {
        console.error('Anonymous login failed:', error)
    }
}

function logout() {
    authStore.logout()
}
</script>

<template>
    <nav class="navbar">
        <div class="user-info">
            <span class="user-avatar">{{ userInitials }}</span>
            <span class="user-name">{{ userName }}</span>
        </div>
        <div class="nav-actions">
            <button v-if="!hasUser" @click="toLogin">Login</button>
            <button v-if="!hasUser" @click="loginAnonymous">Login as Anonymous</button>
            <button v-else @click="logout">Logout</button>
        </div>
    </nav>
    <main class="main-content">
        <slot />
    </main>
</template>

<style scoped>
.navbar {
    background: var(--color-surface);
    border-bottom: 1px solid var(--color-border);
    display: flex;
    align-items: center;
    padding: 1rem 2rem;
    color: var(--color-text);
    justify-content: space-between;
}
.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}
.user-avatar {
    background: var(--color-primary);
    color: #fff;
    border-radius: 50%;
    width: 2.2rem;
    height: 2.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.1rem;
}
.user-name {
    font-size: 1.1rem;
    color: var(--color-text-secondary);
}
.logout-btn {
    background: var(--color-secondary);
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 0.5em 1em;
    font-size: 1rem;
    cursor: pointer;
    transition: background 0.2s;
}
.logout-btn:hover {
    background: var(--color-secondary-dark);
}
.main-content {
    padding: 2rem;
    background: var(--color-background);
    min-height: 90vh;
}


.nav-actions {
    display: flex;
    gap: 0.75rem;
}

.nav-actions button {
    background-color: var(--color-secondary);
    color: #fff;
    border: none;
    border-radius: 4px;
    padding: 0.5em 1em;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.2s ease-in-out;
}

.nav-actions button:hover {
    background-color: var(--color-secondary-dark);
}
</style>
