<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Services', href: '/admin/services' },
    { title: 'Create', href: '/admin/services/create' },
];

const form = ref({
    title: '',
    short_description: '',
    description: '',
    icon: '',
    image: null as File | null,
    meta_title: '',
    meta_description: '',
    is_published: false,
    sort_order: 0,
});

const imagePreview = ref<string | null>(null);
const processing = ref(false);
const errors = ref<Record<string, string>>({});

function handleImageChange(e: Event) {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.value.image = target.files[0];
        imagePreview.value = URL.createObjectURL(target.files[0]);
    }
}

function submit() {
    processing.value = true;
    const formData = new FormData();

    Object.entries(form.value).forEach(([key, value]) => {
        if (key === 'image' && value instanceof File) {
            formData.append(key, value);
        } else if (key === 'is_published') {
            formData.append(key, value ? '1' : '0');
        } else if (value !== null && value !== undefined) {
            formData.append(key, String(value));
        }
    });

    router.post('/admin/services', formData, {
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
    <Head title="Create Service" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Create Service</h2>
                <p class="text-sm text-gray-500 mt-1">Add a new service to your website</p>
            </div>

            <form @submit.prevent="submit" class="max-w-3xl space-y-6">
                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Service Details</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title *</label>
                        <input v-model="form.title" type="text" required class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        <p v-if="errors.title" class="text-red-500 text-xs mt-1">{{ errors.title }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Short Description</label>
                        <textarea v-model="form.short_description" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                        <p v-if="errors.short_description" class="text-red-500 text-xs mt-1">{{ errors.short_description }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description (HTML supported)</label>
                        <textarea v-model="form.description" rows="8" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-mono"></textarea>
                        <p v-if="errors.description" class="text-red-500 text-xs mt-1">{{ errors.description }}</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Icon Keyword</label>
                        <input v-model="form.icon" type="text" placeholder="e.g. architectural, structural, 3d, plumbing, electrical, supervision" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        <p class="text-xs text-gray-400 mt-1">Used to select the icon on the frontend</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Image</label>
                        <input type="file" accept="image/*" @change="handleImageChange" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                        <img v-if="imagePreview" :src="imagePreview" alt="Preview" class="mt-3 w-48 h-32 object-cover rounded-lg" />
                        <p v-if="errors.image" class="text-red-500 text-xs mt-1">{{ errors.image }}</p>
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">SEO & Settings</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                        <input v-model="form.meta_title" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                        <textarea v-model="form.meta_description" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Sort Order</label>
                            <input v-model.number="form.sort_order" type="number" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                        <div class="flex items-end">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input v-model="form.is_published" type="checkbox" class="w-5 h-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500" />
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Publish</span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="processing" class="bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-colors">
                        {{ processing ? 'Saving...' : 'Create Service' }}
                    </button>
                    <a href="/admin/services" class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
