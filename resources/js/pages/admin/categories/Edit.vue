<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Category = {
    id: number;
    name: string;
    slug: string;
    description: string;
    is_active: boolean;
    sort_order: number;
};

type Props = {
    category: Category;
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Categories', href: '/admin/categories' },
    { title: 'Edit', href: `/admin/categories/${props.category.id}/edit` },
];

const form = ref({
    name: props.category.name || '',
    description: props.category.description || '',
    is_active: props.category.is_active,
    sort_order: props.category.sort_order || 0,
});

const processing = ref(false);
const errors = ref<Record<string, string>>({});

function submit() {
    processing.value = true;

    router.post(`/admin/categories/${props.category.id}`, {
        ...form.value,
        is_active: form.value.is_active ? 1 : 0,
    }, {
        onError: (e) => {
            errors.value = e;
        },
        onFinish: () => {
            processing.value = false;
        },
    });
}
</script>

<template>
    <Head :title="`Edit: ${category.name}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Edit Category</h2>
                <p class="text-sm text-gray-500 mt-1">Update "{{ category.name }}"</p>
            </div>

            <form @submit.prevent="submit" class="max-w-2xl space-y-6">
                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name *</label>
                        <input v-model="form.name" type="text" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        <p v-if="errors.name" class="text-red-500 text-xs mt-1">{{ errors.name }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea v-model="form.description" rows="3" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort Order</label>
                            <input v-model.number="form.sort_order" type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input v-model="form.is_active" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="processing" class="bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-colors">
                        {{ processing ? 'Saving...' : 'Update Category' }}
                    </button>
                    <a href="/admin/categories" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
