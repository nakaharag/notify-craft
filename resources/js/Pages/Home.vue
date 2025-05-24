<template>
  <AppLayout>
      <PostItGrid :notes="store.postIts || []" @select="openModal" />
      <PostItModal :post="selected" :visible="showModal" @close="closeModal" />
  </AppLayout>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { usePostItStore } from '@/stores/postIts';
import AppLayout from '@/layouts/AppLayout.vue';
import PostItGrid from '@/components/PostItGrid.vue';
import PostItModal from '@/components/PostItModal.vue';
import type { PostIt } from '@/types';

const store = usePostItStore();
const showModal = ref(false);
const selected = ref<PostIt | null>(null);

onMounted(() => {
  store.fetch();
});

function openModal(note: PostIt) {
  selected.value = note;
  showModal.value = true;
}

function closeModal() {
  showModal.value = false;
}
</script>
