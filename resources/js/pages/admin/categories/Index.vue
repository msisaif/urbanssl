<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, EyeOff, Pencil, Plus, Trash2 } from 'lucide-vue-next';
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
    categories: Category[];
};

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Categories', href: '/admin/categories' },
];

const deleting = ref<number | null>(null);

function confirmDelete(category: Category) {
    if (confirm(`Are you sure you want to delete "${category.name}"?`)) {
        deleting.value = category.id;
        router.delete(`/admin/categories/${category.id}`, {
            onFinish: () => {
                deleting.value = null;
            },
        });
    }
}
</script>

<template>
    <Head title="Manage Categories" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Project Categories</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage categories for your projects</p>
                </div>
                <Link
                    href="/admin/categories/create"
                    class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                >
                    <Plus class="w-4 h-4" />
                    Add Category
                </Link>
            </div>

            <div v-if="categories.length === 0" class="text-center py-20 rounded-xl border bg-white dark:bg-gray-900">
                <p class="text-gray-500 mb-4">No categories yet.</p>
                <Link
                    href="/admin/categories/create"
                    class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium"
                >
                    <Plus class="w-4 h-4" /> Add your first category
                </Link>
            </div>

            <div v-else class="rounded-xl border bg-white dark:bg-gray-900 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Category</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden md:table-cell">Order</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr v-for="category in categories" :key="category.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-6 py-4">
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ category.name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ category.slug }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span
                                    :class="category.is_active
                                        ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                                        : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                >
                                    <Eye v-if="category.is_active" class="w-3 h-3" />
                                    <EyeOff v-else class="w-3 h-3" />
                                    {{ category.is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ category.sort_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link
                                        :href="`/admin/categories/${category.id}/edit`"
                                        class="p-2 text-gray-400 hover:text-amber-600 transition-colors rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(category)"
                                        :disabled="deleting === category.id"
                                        class="p-2 text-gray-400 hover:text-red-600 transition-colors rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20"
                                    >
                                        <Trash2 class="w-4 h-4" />
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
