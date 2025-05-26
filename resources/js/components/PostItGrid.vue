<template>
    <div class="post-it-grid">
        <div
            v-for="note in notes"
            :key="note?.id || Math.random()"
            class="post-it"
            :class="[note?.size?.toLowerCase(), note?.color || 'yellow']"
            @click="$emit('select', note)"
        >
            <h3>{{ note?.title || 'Untitled' }}</h3>
            <p>{{ note?.description || '' }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { PostIt } from '../types';

defineProps<{
    notes?: PostIt[];
}>();

defineEmits<{
    (e: 'select', note: PostIt): void;
}>();
</script>

<style scoped>
.post-it-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
    gap: 1.5rem;
}

.post-it {
    background-color: #ffeb3b;
    padding: 1rem;
    border-radius: 2px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    transition: transform 0.2s, box-shadow 0.2s;
}

.post-it:hover {
    transform: translateY(-4px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
}

.post-it.yellow { background-color: #ffeb3b; }
.post-it.blue { background-color: #90caf9; }
.post-it.green { background-color: #a5d6a7; }
.post-it.pink { background-color: #f8bbd0; }
.post-it.white { background-color: #ffffff; }

.post-it.s {
    height: 150px;
    overflow: hidden;
}
.post-it.m {
    height: 200px;
    overflow: hidden;
}
.post-it.l {
    height: 250px;
    overflow: hidden;
}

.post-it h3 {
    margin-top: 0;
    margin-bottom: 0.5rem;
    font-size: 1.2rem;
}

.post-it p {
    margin: 0;
    font-size: 0.9rem;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 6;
    -webkit-box-orient: vertical;
}
</style>
