<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Building2, Eye, EyeOff, FolderKanban, Tags } from 'lucide-vue-next';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import type { BreadcrumbItem } from '@/types';

type Stats = {
    total_services: number;
    published_services: number;
    total_projects: number;
    published_projects: number;
    total_categories: number;
};

type Props = {
    stats: Stats;
};

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard(),
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Dashboard
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Overview of your website content
                </p>
            </div>

            <!-- Stats Grid -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <div
                    class="rounded-xl border bg-white p-6 shadow-sm dark:bg-gray-900"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg bg-amber-50 p-3 dark:bg-amber-900/20"
                        >
                            <Building2 class="h-6 w-6 text-amber-500" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Total Services
                            </p>
                            <p
                                class="text-2xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ stats?.total_services || 0 }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="mt-3 flex items-center gap-2 text-xs text-gray-500"
                    >
                        <Eye class="h-3.5 w-3.5 text-green-500" />
                        <span
                            >{{
                                stats?.published_services || 0
                            }}
                            published</span
                        >
                        <EyeOff class="ml-2 h-3.5 w-3.5 text-gray-400" />
                        <span
                            >{{
                                (stats?.total_services || 0) -
                                (stats?.published_services || 0)
                            }}
                            draft</span
                        >
                    </div>
                </div>

                <div
                    class="rounded-xl border bg-white p-6 shadow-sm dark:bg-gray-900"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg bg-blue-50 p-3 dark:bg-blue-900/20"
                        >
                            <FolderKanban class="h-6 w-6 text-blue-500" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Total Projects
                            </p>
                            <p
                                class="text-2xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ stats?.total_projects || 0 }}
                            </p>
                        </div>
                    </div>
                    <div
                        class="mt-3 flex items-center gap-2 text-xs text-gray-500"
                    >
                        <Eye class="h-3.5 w-3.5 text-green-500" />
                        <span
                            >{{
                                stats?.published_projects || 0
                            }}
                            published</span
                        >
                        <EyeOff class="ml-2 h-3.5 w-3.5 text-gray-400" />
                        <span
                            >{{
                                (stats?.total_projects || 0) -
                                (stats?.published_projects || 0)
                            }}
                            draft</span
                        >
                    </div>
                </div>

                <div
                    class="rounded-xl border bg-white p-6 shadow-sm dark:bg-gray-900"
                >
                    <div class="flex items-center gap-4">
                        <div
                            class="rounded-lg bg-yellow-50 p-3 dark:bg-yellow-900/20"
                        >
                            <Tags class="h-6 w-6 text-yellow-500" />
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                Categories
                            </p>
                            <p
                                class="text-2xl font-bold text-gray-900 dark:text-white"
                            >
                                {{ stats?.total_categories || 0 }}
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col justify-center rounded-xl border bg-white p-6 shadow-sm dark:bg-gray-900"
                >
                    <p class="mb-3 text-sm text-gray-500 dark:text-gray-400">
                        Quick Actions
                    </p>
                    <div class="flex flex-col gap-2">
                        <Link
                            href="/admin/services/create"
                            class="text-sm font-medium text-amber-600 hover:text-amber-700"
                            >+ Add Service</Link
                        >
                        <Link
                            href="/admin/projects/create"
                            class="text-sm font-medium text-blue-600 hover:text-blue-700"
                            >+ Add Project</Link
                        >
                        <Link
                            href="/admin/categories/create"
                            class="text-sm font-medium text-yellow-600 hover:text-yellow-700"
                            >+ Add Category</Link
                        >
                    </div>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                <Link
                    href="/admin/services"
                    class="group rounded-xl border bg-white p-6 shadow-sm transition-all hover:border-amber-200 hover:shadow-md dark:bg-gray-900"
                >
                    <Building2 class="mb-3 h-8 w-8 text-amber-500" />
                    <h3
                        class="font-semibold text-gray-900 group-hover:text-amber-600 dark:text-white"
                    >
                        Manage Services
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Add, edit or remove services
                    </p>
                </Link>
                <Link
                    href="/admin/projects"
                    class="group rounded-xl border bg-white p-6 shadow-sm transition-all hover:border-blue-200 hover:shadow-md dark:bg-gray-900"
                >
                    <FolderKanban class="mb-3 h-8 w-8 text-blue-500" />
                    <h3
                        class="font-semibold text-gray-900 group-hover:text-blue-600 dark:text-white"
                    >
                        Manage Projects
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Add, edit or remove projects
                    </p>
                </Link>
                <Link
                    href="/admin/contact-info"
                    class="group rounded-xl border bg-white p-6 shadow-sm transition-all hover:border-green-200 hover:shadow-md dark:bg-gray-900"
                >
                    <Building2 class="mb-3 h-8 w-8 text-green-500" />
                    <h3
                        class="font-semibold text-gray-900 group-hover:text-green-600 dark:text-white"
                    >
                        Contact Info
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Update contact details
                    </p>
                </Link>
                <Link
                    href="/admin/about-info"
                    class="group rounded-xl border bg-white p-6 shadow-sm transition-all hover:border-purple-200 hover:shadow-md dark:bg-gray-900"
                >
                    <Building2 class="mb-3 h-8 w-8 text-purple-500" />
                    <h3
                        class="font-semibold text-gray-900 group-hover:text-purple-600 dark:text-white"
                    >
                        About Info
                    </h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Update company information
                    </p>
                </Link>
            </div>

            <!-- View Site Link -->
            <div
                class="rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 p-6 text-white"
            >
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-semibold">
                            Urban Structural Solutions
                        </h3>
                        <p class="mt-1 text-sm text-amber-100">
                            View your public website
                        </p>
                    </div>
                    <a
                        href="/"
                        target="_blank"
                        class="rounded-lg bg-white px-5 py-2.5 text-sm font-semibold text-amber-600 transition-colors hover:bg-amber-50"
                    >
                        View Site →
                    </a>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
