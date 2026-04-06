<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { Eye, EyeOff, Pencil, Plus, Trash2 } from 'lucide-vue-next';
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
    project_status: string;
    is_published: boolean;
    sort_order: number;
    images: ProjectImage[];
    categories: Category[];
};

type Props = {
    projects: Project[];
};

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Projects', href: '/admin/projects' },
];

const deleting = ref<number | null>(null);

function confirmDelete(project: Project) {
    if (confirm(`Are you sure you want to delete "${project.title}"?`)) {
        deleting.value = project.id;
        router.delete(`/admin/projects/${project.id}`, {
            onFinish: () => {
                deleting.value = null;
            },
        });
    }
}
</script>

<template>
    <Head title="Manage Projects" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h2
                        class="text-2xl font-bold text-gray-900 dark:text-white"
                    >
                        Projects
                    </h2>
                    <p class="mt-1 text-sm text-gray-500">
                        Manage your project portfolio
                    </p>
                </div>
                <Link
                    href="/admin/projects/create"
                    class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-amber-600"
                >
                    <Plus class="h-4 w-4" />
                    Add Project
                </Link>
            </div>

            <div
                v-if="projects.length === 0"
                class="rounded-xl border bg-white py-20 text-center dark:bg-gray-900"
            >
                <p class="mb-4 text-gray-500">No projects yet.</p>
                <Link
                    href="/admin/projects/create"
                    class="inline-flex items-center gap-2 font-medium text-amber-600 hover:text-amber-700"
                >
                    <Plus class="h-4 w-4" /> Add your first project
                </Link>
            </div>

            <div
                v-else
                class="overflow-hidden rounded-xl border bg-white dark:bg-gray-900"
            >
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th
                                class="px-6 py-3 text-left font-medium text-gray-500"
                            >
                                Project
                            </th>
                            <th
                                class="hidden px-6 py-3 text-left font-medium text-gray-500 sm:table-cell"
                            >
                                Categories
                            </th>
                            <th
                                class="hidden px-6 py-3 text-left font-medium text-gray-500 md:table-cell"
                            >
                                Status
                            </th>
                            <th
                                class="hidden px-6 py-3 text-left font-medium text-gray-500 lg:table-cell"
                            >
                                Images
                            </th>
                            <th
                                class="px-6 py-3 text-right font-medium text-gray-500"
                            >
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody
                        class="divide-y divide-gray-100 dark:divide-gray-800"
                    >
                        <tr
                            v-for="project in projects"
                            :key="project.id"
                            class="hover:bg-gray-50 dark:hover:bg-gray-800/50"
                        >
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-4">
                                    <img
                                        v-if="project.images.length > 0"
                                        :src="`/storage/${project.images[0].image}`"
                                        :alt="project.title"
                                        class="h-12 w-12 rounded-lg object-cover"
                                    />
                                    <div
                                        v-else
                                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-800"
                                    >
                                        <span class="text-xs text-gray-400"
                                            >N/A</span
                                        >
                                    </div>
                                    <div>
                                        <p
                                            class="font-medium text-gray-900 dark:text-white"
                                        >
                                            {{ project.title }}
                                        </p>
                                        <p class="mt-0.5 text-xs text-gray-500">
                                            {{
                                                project.location ||
                                                'No location'
                                            }}
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="hidden px-6 py-4 sm:table-cell">
                                <div class="flex flex-wrap gap-1">
                                    <span
                                        v-for="cat in project.categories"
                                        :key="cat.id"
                                        class="rounded bg-amber-50 px-2 py-0.5 text-xs font-medium text-amber-700 dark:bg-amber-900/20 dark:text-amber-400"
                                    >
                                        {{ cat.name }}
                                    </span>
                                    <span
                                        v-if="project.categories.length === 0"
                                        class="text-xs text-gray-400"
                                        >—</span
                                    >
                                </div>
                            </td>
                            <td class="hidden px-6 py-4 md:table-cell">
                                <span
                                    :class="
                                        project.is_published
                                            ? 'bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-400'
                                            : 'bg-gray-100 text-gray-600 dark:bg-gray-800 dark:text-gray-400'
                                    "
                                    class="inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-xs font-medium"
                                >
                                    <Eye
                                        v-if="project.is_published"
                                        class="h-3 w-3"
                                    />
                                    <EyeOff v-else class="h-3 w-3" />
                                    {{
                                        project.is_published
                                            ? 'Published'
                                            : 'Draft'
                                    }}
                                </span>
                            </td>
                            <td
                                class="hidden px-6 py-4 text-gray-500 lg:table-cell"
                            >
                                {{ project.images.length }}
                            </td>
                            <td class="px-6 py-4">
                                <div
                                    class="flex items-center justify-end gap-2"
                                >
                                    <Link
                                        :href="`/admin/projects/${project.id}/edit`"
                                        class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-amber-50 hover:text-amber-600 dark:hover:bg-amber-900/20"
                                    >
                                        <Pencil class="h-4 w-4" />
                                    </Link>
                                    <button
                                        @click="confirmDelete(project)"
                                        :disabled="deleting === project.id"
                                        class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-red-50 hover:text-red-600 dark:hover:bg-red-900/20"
                                    >
                                        <Trash2 class="h-4 w-4" />
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
