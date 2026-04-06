<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, EyeOff, Pencil, Plus, Trash2 } from 'lucide-vue-next';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Service = {
    id: number;
    title: string;
    slug: string;
    short_description: string;
    image: string;
    is_published: boolean;
    sort_order: number;
    created_at: string;
};

type Props = {
    services: Service[];
};

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Services', href: '/admin/services' },
];

const deleting = ref<number | null>(null);

function confirmDelete(service: Service) {
    if (confirm(`Are you sure you want to delete "${service.title}"?`)) {
        deleting.value = service.id;
        router.delete(`/admin/services/${service.id}`, {
            onFinish: () => {
                deleting.value = null;
            },
        });
    }
}
</script>

<template>
    <Head title="Manage Services" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Services</h2>
                    <p class="text-sm text-gray-500 mt-1">Manage your service offerings</p>
                </div>
                <Link
                    href="/admin/services/create"
                    class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2.5 rounded-lg text-sm font-semibold transition-colors"
                >
                    <Plus class="w-4 h-4" />
                    Add Service
                </Link>
            </div>

            <div v-if="services.length === 0" class="text-center py-20 rounded-xl border bg-white dark:bg-gray-900">
                <p class="text-gray-500 mb-4">No services yet.</p>
                <Link
                    href="/admin/services/create"
                    class="inline-flex items-center gap-2 text-amber-600 hover:text-amber-700 font-medium"
                >
                    <Plus class="w-4 h-4" /> Add your first service
                </Link>
            </div>

            <div v-else class="rounded-xl border bg-white dark:bg-gray-900 overflow-hidden">
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left px-6 py-3 font-medium text-gray-500">Service</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden sm:table-cell">Status</th>
                            <th class="text-left px-6 py-3 font-medium text-gray-500 hidden md:table-cell">Order</th>
                            <th class="text-right px-6 py-3 font-medium text-gray-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        <tr v-for="service in services" :key="service.id" class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        v-if="service.image"
                                        :src="`/storage/${service.image}`"
                                        :alt="service.title"
                                        class="w-12 h-12 rounded-lg object-cover"
                                    />
                                    <div v-else class="w-12 h-12 rounded-lg bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                                        <span class="text-gray-400 text-xs">N/A</span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900 dark:text-white">{{ service.title }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5">/services/{{ service.slug }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <span
                                    :class="service.is_published
                                        ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                                        : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'"
                                    class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium"
                                >
                                    <Eye v-if="service.is_published" class="w-3 h-3" />
                                    <EyeOff v-else class="w-3 h-3" />
                                    {{ service.is_published ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-gray-500 hidden md:table-cell">{{ service.sort_order }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <Link
                                        :href="`/admin/services/${service.id}/edit`"
                                        class="p-2 text-gray-400 hover:text-amber-600 transition-colors rounded-lg hover:bg-amber-50 dark:hover:bg-amber-900/20"
                                    >
                                        <Pencil class="w-4 h-4" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(service)"
                                        :disabled="deleting === service.id"
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
