<template>
    <div class="flex justify-center mt-6 space-x-4">
        <button
            :disabled="meta.current_page === 1"
            @click="emit('page', meta.current_page - 1)"
        >
            Prev
        </button>
        <span>
      Page {{ meta.current_page }} / {{ meta.last_page }}
    </span>
        <button
            :disabled="meta.current_page === meta.last_page"
            @click="emit('page', meta.current_page + 1)"
        >
            Next
        </button>
    </div>
</template>

<script setup lang="ts">
import type { Meta } from '../../types'

const props = defineProps<{
    meta: Meta
}>()

const emit = defineEmits<{
    (e: 'page', page: number): void
}>()
</script>
