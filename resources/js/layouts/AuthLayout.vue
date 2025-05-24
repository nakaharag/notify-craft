<script setup lang="ts">

</script>

<template>
    <nav class="navbar auth-navbar">
        <h1 class="app-title">Post-It App</h1>
    </nav>

    <main class="main-content auth-main">
        <div class="auth-container">
            <slot />
        </div>
    </main>
</template>

<style>
.auth-navbar {
    background: var(--color-surface);
    border-bottom: 1px solid var(--color-border);
    display: flex;
    justify-content: center;
    padding: 1rem 2rem;
}
.app-title {
    color: var(--color-text);
    font-size: 1.75rem;
    font-weight: bold;
}

.auth-main {
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--color-background);
    min-height: calc(100vh - 72px);
    padding: 2rem;
}

.auth-container {
    width: 100%;
    max-width: 360px;
    background: var(--color-surface);
    padding: 2rem;
    border-radius: 0.75rem;
    border: 1px solid var(--color-border);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.05);
}

.auth-container h2 {
    margin-bottom: 1.5rem;
    text-align: center;
    color: var(--color-primary);
    font-size: 1.5rem;
}

.form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

label {
    font-size: 0.9rem;
    color: var(--color-text-secondary);
}

input {
    padding: 0.75rem 1rem;
    border: 1px solid var(--color-border);
    border-radius: 0.5rem;
    font-size: 1rem;
    color: var(--color-text);
    background: #fafafa;
    transition: border-color 0.2s, box-shadow 0.2s;
}

input:focus {
    outline: none;
    border-color: var(--color-primary);
    box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.2);
}

.action-buttons {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-primary {
    flex: 1;
    padding: 0.75rem;
    background: var(--color-primary);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background 0.2s ease-in-out;
}
.btn-primary:hover {
    background: var(--color-primary-dark);
}

.btn-secondary {
    flex: 1;
    padding: 0.75rem;
    background: var(--color-secondary);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    transition: background 0.2s ease-in-out;
}
.btn-secondary:hover {
    background: var(--color-secondary-dark);
}
</style>
