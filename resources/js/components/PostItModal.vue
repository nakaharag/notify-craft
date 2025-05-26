<template>
    <div v-if="visible" class="modal-overlay" @click="$emit('close')">
        <div class="modal-content" :class="[post?.color || 'yellow']" @click.stop>
            <div class="modal-header">
                <h2>{{ post?.title || 'Untitled' }}</h2>
                <button class="close-button" @click="$emit('close')">×</button>
            </div>
            <div class="modal-body">
                <p>{{ post?.description || '' }}</p>
            </div>
            <div class="modal-footer">
                <small>Created: {{ formatDate(post?.created_at) }}</small>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { PostIt } from '../types';

const props = defineProps<{
    post: PostIt | null;
    visible: boolean;
}>();

defineEmits<{
    (e: 'close'): void;
}>();

function formatDate(dateStr?: string): string {
    if (!dateStr) return '';
    const date = new Date(dateStr);
    return date.toLocaleDateString();
}
</script>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 10;
}

.modal-content {
    background-color: #ffeb3b;
    width: 90%;
    max-width: 500px;
    border-radius: 4px;
    padding: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}

.modal-content.yellow { background-color: #ffeb3b; }
.modal-content.blue { background-color: #90caf9; }
.modal-content.green { background-color: #a5d6a7; }
.modal-content.pink { background-color: #f8bbd0; }
.modal-content.white { background-color: #ffffff; }

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 1rem;
}

.modal-header h2 {
    margin: 0;
}

.close-button {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    padding: 0;
}

.modal-footer {
    margin-top: 1.5rem;
    color: #666;
}
</style>
