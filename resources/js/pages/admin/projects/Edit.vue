<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { X } from 'lucide-vue-next';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type Category = {
    id: number;
    name: string;
};

type ProjectImage = {
    id: number;
    image: string;
};

type Project = {
    id: number;
    title: string;
    slug: string;
    location: string;
    owner: string;
    project_status: string;
    project_date: string;
    description: string;
    meta_title: string;
    meta_description: string;
    is_published: boolean;
    sort_order: number;
    images: ProjectImage[];
    categories: Category[];
};

type Props = {
    project: Project;
    categories: Category[];
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Projects', href: '/admin/projects' },
    { title: 'Edit', href: `/admin/projects/${props.project.id}/edit` },
];

const form = ref({
    title: props.project.title || '',
    location: props.project.location || '',
    owner: props.project.owner || '',
    project_status: props.project.project_status || '',
    project_date: props.project.project_date || '',
    description: props.project.description || '',
    meta_title: props.project.meta_title || '',
    meta_description: props.project.meta_description || '',
    is_published: props.project.is_published,
    sort_order: props.project.sort_order || 0,
});

const selectedCategoryIds = ref<number[]>(
    props.project.categories.map((c) => c.id),
);
const existingImages = ref<ProjectImage[]>([...props.project.images]);
const removeImageIds = ref<number[]>([]);
const newImageFiles = ref<File[]>([]);
const newImagePreviews = ref<string[]>([]);
const processing = ref(false);
const errors = ref<Record<string, string>>({});

function toggleCategory(id: number) {
    const idx = selectedCategoryIds.value.indexOf(id);

    if (idx === -1) {
        selectedCategoryIds.value.push(id);
    } else {
        selectedCategoryIds.value.splice(idx, 1);
    }
}

function handleImagesChange(e: Event) {
    const target = e.target as HTMLInputElement;

    if (target.files) {
        for (const file of target.files) {
            newImageFiles.value.push(file);
            newImagePreviews.value.push(URL.createObjectURL(file));
        }
    }

    target.value = '';
}

function removeExistingImage(imageId: number) {
    removeImageIds.value.push(imageId);
    existingImages.value = existingImages.value.filter(
        (img) => img.id !== imageId,
    );
}

function removeNewImage(index: number) {
    newImageFiles.value.splice(index, 1);
    newImagePreviews.value.splice(index, 1);
}

function submit() {
    processing.value = true;
    const formData = new FormData();

    Object.entries(form.value).forEach(([key, value]) => {
        if (key === 'is_published') {
            formData.append(key, value ? '1' : '0');
        } else if (value !== null && value !== undefined) {
            formData.append(key, String(value));
        }
    });

    selectedCategoryIds.value.forEach((id, index) => {
        formData.append(`category_ids[${index}]`, String(id));
    });

    newImageFiles.value.forEach((file, index) => {
        formData.append(`images[${index}]`, file);
    });

    removeImageIds.value.forEach((id, index) => {
        formData.append(`remove_images[${index}]`, String(id));
    });

    router.post(`/admin/projects/${props.project.id}`, formData, {
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
    <Head :title="`Edit: ${project.title}`" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Edit Project
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Update "{{ project.title }}"
                </p>
            </div>

            <form @submit.prevent="submit" class="max-w-3xl space-y-6">
                <div
                    class="space-y-5 rounded-xl border bg-white p-6 dark:bg-gray-900"
                >
                    <h3
                        class="border-b pb-3 font-semibold text-gray-900 dark:text-white"
                    >
                        Project Details
                    </h3>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Title *</label
                        >
                        <input
                            v-model="form.title"
                            type="text"
                            required
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        />
                        <p
                            v-if="errors.title"
                            class="mt-1 text-xs text-red-500"
                        >
                            {{ errors.title }}
                        </p>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Location</label
                        >
                        <input
                            v-model="form.location"
                            type="text"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        />
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Owner</label
                            >
                            <input
                                v-model="form.owner"
                                type="text"
                                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                            />
                        </div>
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Project Status</label
                            >
                            <select
                                v-model="form.project_status"
                                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                            >
                                <option value="">Select status</option>
                                <option value="Upcoming">Upcoming</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Date</label
                        >
                        <input
                            v-model="form.project_date"
                            type="date"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Description (HTML supported)</label
                        >
                        <textarea
                            v-model="form.description"
                            rows="6"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 font-mono text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        ></textarea>
                    </div>
                </div>

                <div
                    class="space-y-5 rounded-xl border bg-white p-6 dark:bg-gray-900"
                >
                    <h3
                        class="border-b pb-3 font-semibold text-gray-900 dark:text-white"
                    >
                        Categories
                    </h3>

                    <div
                        v-if="categories.length === 0"
                        class="text-sm text-gray-500"
                    >
                        No categories available.
                        <a
                            href="/admin/categories/create"
                            class="text-amber-600 hover:text-amber-700"
                            >Create one first.</a
                        >
                    </div>
                    <div v-else class="flex flex-wrap gap-2">
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            type="button"
                            @click="toggleCategory(cat.id)"
                            :class="
                                selectedCategoryIds.includes(cat.id)
                                    ? 'border-amber-500 bg-amber-500 text-white'
                                    : 'border-gray-200 bg-white text-gray-700 hover:border-amber-300 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300'
                            "
                            class="rounded-lg border px-4 py-2 text-sm font-medium transition-colors"
                        >
                            {{ cat.name }}
                        </button>
                    </div>
                </div>

                <div
                    class="space-y-5 rounded-xl border bg-white p-6 dark:bg-gray-900"
                >
                    <h3
                        class="border-b pb-3 font-semibold text-gray-900 dark:text-white"
                    >
                        Project Images
                    </h3>

                    <!-- Existing Images -->
                    <div v-if="existingImages.length > 0">
                        <p class="mb-3 text-sm text-gray-500">
                            Existing images:
                        </p>
                        <div class="grid grid-cols-3 gap-4">
                            <div
                                v-for="img in existingImages"
                                :key="img.id"
                                class="group relative"
                            >
                                <img
                                    :src="`/storage/${img.image}`"
                                    alt="Project image"
                                    class="h-32 w-full rounded-lg object-cover"
                                />
                                <button
                                    type="button"
                                    @click="removeExistingImage(img.id)"
                                    class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white opacity-0 transition-opacity group-hover:opacity-100"
                                >
                                    <X class="h-3 w-3" />
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- New Images -->
                    <div>
                        <p class="mb-2 text-sm text-gray-500">
                            Add new images:
                        </p>
                        <input
                            type="file"
                            accept="image/*"
                            multiple
                            @change="handleImagesChange"
                            class="w-full text-sm text-gray-500 file:mr-4 file:rounded-lg file:border-0 file:bg-amber-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-amber-700 hover:file:bg-amber-100"
                        />
                    </div>

                    <div
                        v-if="newImagePreviews.length > 0"
                        class="grid grid-cols-3 gap-4"
                    >
                        <div
                            v-for="(preview, index) in newImagePreviews"
                            :key="index"
                            class="group relative"
                        >
                            <img
                                :src="preview"
                                alt="Preview"
                                class="h-32 w-full rounded-lg object-cover"
                            />
                            <button
                                type="button"
                                @click="removeNewImage(index)"
                                class="absolute top-1 right-1 rounded-full bg-red-500 p-1 text-white opacity-0 transition-opacity group-hover:opacity-100"
                            >
                                <X class="h-3 w-3" />
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    class="space-y-5 rounded-xl border bg-white p-6 dark:bg-gray-900"
                >
                    <h3
                        class="border-b pb-3 font-semibold text-gray-900 dark:text-white"
                    >
                        SEO & Settings
                    </h3>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Meta Title</label
                        >
                        <input
                            v-model="form.meta_title"
                            type="text"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        />
                    </div>

                    <div>
                        <label
                            class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                            >Meta Description</label
                        >
                        <textarea
                            v-model="form.meta_description"
                            rows="2"
                            class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                        ></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="mb-1 block text-sm font-medium text-gray-700 dark:text-gray-300"
                                >Sort Order</label
                            >
                            <input
                                v-model.number="form.sort_order"
                                type="number"
                                class="w-full rounded-lg border border-gray-200 px-4 py-2.5 text-sm focus:border-amber-500 focus:ring-amber-500 dark:border-gray-700 dark:bg-gray-800 dark:text-white"
                            />
                        </div>
                        <div class="flex items-end">
                            <label
                                class="flex cursor-pointer items-center gap-3"
                            >
                                <input
                                    v-model="form.is_published"
                                    type="checkbox"
                                    class="h-5 w-5 rounded border-gray-300 text-amber-500 focus:ring-amber-500"
                                />
                                <span
                                    class="text-sm font-medium text-gray-700 dark:text-gray-300"
                                    >Publish</span
                                >
                            </label>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button
                        type="submit"
                        :disabled="processing"
                        class="rounded-lg bg-amber-500 px-6 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-amber-600 disabled:opacity-50"
                    >
                        {{ processing ? 'Saving...' : 'Update Project' }}
                    </button>
                    <a
                        href="/admin/projects"
                        class="text-sm text-gray-500 hover:text-gray-700"
                        >Cancel</a
                    >
                </div>
            </form>
        </div>
    </AppLayout>
</template>
