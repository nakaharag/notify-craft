<template>
    <div v-if="visible" class="modal-overlay" @click="$emit('close')">
        <div class="modal-content" :class="[formData.color]" @click.stop>
            <div class="modal-header">
                <h2>New Post-It</h2>
                <button class="close-button" @click="$emit('close')">×</button>
            </div>
            <div class="modal-body">
                <form @submit.prevent="save">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input
                            id="title"
                            v-model="formData.title"
                            type="text"
                            required
                            placeholder="Title"
                        />
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            v-model="formData.description"
                            rows="4"
                            placeholder="Description"
                        ></textarea>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Color</label>
                            <div class="color-options">
                                <label
                                    v-for="color in colorOptions"
                                    :key="color"
                                    :class="{ selected: formData.color === color }"
                                >
                                    <input
                                        type="radio"
                                        :value="color"
                                        v-model="formData.color"
                                        class="sr-only"
                                    />
                                    <span class="color-swatch" :class="color"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Size</label>
                            <div class="size-options">
                                <label
                                    v-for="size in sizeOptions"
                                    :key="size.value"
                                    :class="{ selected: formData.size === size.value }"
                                >
                                    <input
                                        type="radio"
                                        :value="size.value"
                                        v-model="formData.size"
                                        class="sr-only"
                                    />
                                    <span class="size-option">{{ size.label }}</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="font_family">Font</label>
                            <select id="font_family" v-model="formData.font_family">
                                <option
                                    v-for="font in fontFamilyOptions"
                                    :key="font"
                                    :value="font"
                                >
                                    {{ font }}
                                </option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="font_size">Font Size</label>
                            <select id="font_size" v-model="formData.font_size">
                                <option
                                    v-for="size in fontSizeOptions"
                                    :key="size.value"
                                    :value="size.value"
                                >
                                    {{ size.label }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" @click="$emit('close')" class="btn-secondary">Cancel</button>
                        <button type="submit" class="btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { reactive } from 'vue';
import { usePostItStore } from '../stores/postIts';

const props = defineProps<{
    visible: boolean;
}>();

const emit = defineEmits<{
    (e: 'close'): void;
}>();

const colorOptions = ['yellow', 'blue', 'green', 'pink', 'white'];
const sizeOptions = [
    { value: 'S', label: 'Small' },
    { value: 'M', label: 'Medium' },
    { value: 'L', label: 'Large' }
];
const fontFamilyOptions = ['Arial', 'Times New Roman', 'Courier New', 'Comic Sans MS'];
const fontSizeOptions = [
    { value: 'small', label: 'Small' },
    { value: 'medium', label: 'Medium' },
    { value: 'large', label: 'Large' }
];

const formData = reactive({
    title: '',
    description: '',
    color: 'yellow',
    font_family: 'Arial',
    font_size: 'medium',
    size: 'M'
});

const store = usePostItStore();

async function save() {
    try {
        await store.create({ ...formData });
        emit('close');
    } catch (error) {
        console.error('Failed to save post-it:', error);
    }
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
    background-color: #fff;
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

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-group input[type="text"],
.form-group textarea,
.form-group select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: rgba(255, 255, 255, 0.7);
}

.form-row {
    display: flex;
    gap: 1rem;
    margin-bottom: 1rem;
}

.form-row .form-group {
    flex: 1;
    margin-bottom: 0;
}

.color-options,
.size-options {
    display: flex;
    gap: 0.5rem;
}

.color-swatch {
    display: block;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    border: 2px solid transparent;
    cursor: pointer;
}

.color-options label.selected .color-swatch {
    border-color: #333;
}

.color-swatch.yellow { background-color: #ffeb3b; }
.color-swatch.blue { background-color: #90caf9; }
.color-swatch.green { background-color: #a5d6a7; }
.color-swatch.pink { background-color: #f8bbd0; }
.color-swatch.white { background-color: #ffffff; border: 1px solid #ddd; }

.size-option {
    display: block;
    padding: 0.25rem 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: white;
    cursor: pointer;
}

.size-options label.selected .size-option {
    background-color: #333;
    color: white;
    border-color: #333;
}

.sr-only {
    position: absolute;
    width: 1px;
    height: 1px;
    padding: 0;
    margin: -1px;
    overflow: hidden;
    clip: rect(0, 0, 0, 0);
    white-space: nowrap;
    border: 0;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 0.75rem;
    margin-top: 1.5rem;
}

.btn-primary,
.btn-secondary {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    font-weight: 500;
    cursor: pointer;
    border: none;
}

.btn-primary {
    background-color: var(--color-primary, #4a5568);
    color: white;
}

.btn-secondary {
    background-color: #e2e8f0;
    color: #4a5568;
}
</style>
