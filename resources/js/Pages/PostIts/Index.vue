<template>
    <div class="space-y-6">
        <Filters
            :filters="filters"
            @change="onFilter"
        />

        <Board
            :notes="items"
            @select="openModal"
        />

        <Pagination
            :meta="meta"
            @page="onPage"
        />

        <CreatePostItModal
            :visible="showCreate"
            @close="showCreate = false"
            @created="reload()"
        />
        <PostItModal
            v-if="selected"
            :post="selected"
            :visible="showModal"
            @close="closeModal"
        />

        <button
            @click="showCreate = true"
            class="fixed bottom-6 right-6 bg-primary text-white p-4 rounded-full shadow-lg"
        >+</button>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { Inertia } from '@inertiajs/inertia'
import { usePage } from '@inertiajs/inertia-vue3'

import Filters           from '@/components/PostIts/Filters.vue'
import Board             from '@/components/PostIts/Board.vue'
import Pagination        from '@/components/PostIts/Pagination.vue'
import CreatePostItModal from '@/components/PostIts/CreatePostItModal.vue'
import PostItModal       from '@/components/PostIts/PostItModal.vue'
import type { PostIt, Filters as F, Meta } from '@/types'

const { props } = usePage<{
    items: PostIt[]
    meta:  Meta
    filters: F
}>()

// reactive props
const items   = props.items
const meta    = props.meta
const filters = ref({ ...props.filters })

// modal state
const showCreate = ref(false)
const showModal  = ref(false)
const selected   = ref<PostIt|null>(null)

function onFilter(key: keyof F, val: string) {
    Inertia.visit('/post-its', {
        method: 'get',
        data:   { ...filters.value, [key]: val, page: 1 },
        preserveState: true,
        preserveScroll: true,
    })
}

function onPage(page: number) {
    Inertia.visit('/post-its', {
        method: 'get',
        data:   { ...filters.value, page },
        preserveState: true,
        preserveScroll: true,
    })
}

function openModal(post: PostIt) {
    selected.value = post
    showModal.value = true
}
function closeModal() {
    showModal.value = false
    selected.value = null
}

function reload() {
    Inertia.reload({ preserveState: true, preserveScroll: true })
}
</script>
