<template>
    <div class="w-full max-w-sm mx-auto mt-20">
        <h2 class="text-2xl mb-4">Login</h2>
        <form @submit.prevent="submit">
            <div class="mb-3">
                <label>Email</label>
                <input v-model="form.email" type="email" required class="w-full border p-2" />
            </div>
            <div class="mb-3">
                <label>Password</label>
                <input v-model="form.password" type="password" required class="w-full border p-2" />
            </div>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2">Login</button>
        </form>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const auth = useAuthStore();
const router = useRouter();
const form = reactive({ email: '', password: '' });

async function submit() {
    await auth.login(form);
    router.push('/');
}
</script>
