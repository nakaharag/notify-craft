<template>
    <div class="post-it-grid">
        <div
            v-for="note in props.notes"
            :key="note.id"
            class="post-it"
            :class="[note.size.toLowerCase(), note.color]"
            @click="emit('select', note)"
        >
            <h3>{{ note.title }}</h3>
            <p>{{ note.description }}</p>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { PostIt } from '../../types'

const props = defineProps<{
    notes: PostIt[]
}>()

const emit = defineEmits<{
    (e: 'select', note: PostIt): void
}>()
</script>

<style scoped>
.post-it { background: #ffeb3b; }
.post-it.s { height: 150px; }
.post-it.m { height: 200px; }
.post-it.l { height: 250px; }
</style>
