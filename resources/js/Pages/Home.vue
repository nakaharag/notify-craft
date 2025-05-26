<template>
    <AppLayout>
        <button
            @click="showCreate = true"
            class="mb-4 px-4 py-2 bg-primary text-white rounded"
        >
            + New Post-It
        </button>
        <PostItGrid :notes="store.postIts" @select="openModal" />
        <PostItModal
            v-if="selected"
            :post="selected"
            :visible="showModal"
            @close="closeModal"
        />
        <CreatePostItModal :visible="showCreate" @close="closeCreateModal" />
    </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePostItStore } from '../stores/postIts';
import AppLayout from '../layouts/AppLayout.vue';
import PostItGrid from '../components/PostItGrid.vue';
import PostItModal from '../components/PostItModal.vue';
import CreatePostItModal from '../components/CreatePostItModal.vue';
import type { PostIt } from '../types';

const store = usePostItStore();
const showModal = ref(false);
const selected = ref<PostIt | null>(null);

const showCreate = ref(false);

onMounted(async () => {
    await store.fetch();
});

function openModal(note: PostIt) {
    selected.value = note;
    showModal.value = true;
}

function closeModal() {
    showModal.value = false;
    setTimeout(() => {
        selected.value = null;
    }, 100);
}

function closeCreateModal() {
    showCreate.value = false;
}
</script>

<style>
:root {
    --color-primary: #4a5568;
    --color-secondary: #718096;
    --color-background: #f7fafc;
    --color-surface: #ffffff;
    --color-text: #2d3748;
    --color-text-secondary: #4a5568;
    --color-border: #e2e8f0;
}

.bg-primary {
    background-color: var(--color-primary);
}

.text-white {
    color: white;
}

.rounded {
    border-radius: 0.25rem;
}

.mb-4 {
    margin-bottom: 1rem;
}

.px-4 {
    padding-left: 1rem;
    padding-right: 1rem;
}

.py-2 {
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
}

button {
    cursor: pointer;
    border: none;
}
</style>
