<template>
    <div class="flex gap-4 mb-4">
        <select
            v-model="local.color"
            @change="emit('change', 'color', local.color)"
        >
            <option value="">All Colors</option>
            <option v-for="c in colors" :key="c" :value="c">{{ c }}</option>
        </select>

        <select
            v-model="local.size"
            @change="emit('change', 'size', local.size)"
        >
            <option value="">All Sizes</option>
            <option v-for="s in sizes" :key="s" :value="s">{{ s }}</option>
        </select>
    </div>
</template>

<script setup lang="ts">
import { reactive, watch } from 'vue'
import type { Filters } from '@/types'

const props = defineProps<{ filters: Filters }>()
const emit  = defineEmits<{
    (e: 'change', key: keyof Filters, val: string): void
}>()

const local = reactive({ ...props.filters })

const colors = ['yellow','blue','green','pink','white']
const sizes  = ['S','M','L']

watch(() => props.filters, v => Object.assign(local, v))
</script>
