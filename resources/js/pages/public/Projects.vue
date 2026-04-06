<script setup lang="ts">
import { Link, router } from '@inertiajs/vue3';
import { Building2, MapPin } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

type Category = {
    id: number;
    name: string;
    slug: string;
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
    images: ProjectImage[];
    categories: Category[];
};

type Props = {
    projects: Project[];
    categories: Category[];
    filters: {
        category: string | null;
    };
    aboutInfo: Record<string, string>;
    contactInfo: Record<string, string>;
};

const props = defineProps<Props>();

function filterByCategory(slug: string) {
    if (slug) {
        router.get('/projects', { category: slug }, { preserveState: true });
    } else {
        router.get('/projects', {}, { preserveState: true });
    }
}
</script>

<template>
    <PublicLayout
        title="Our Projects"
        :contact-info="contactInfo"
        :about-info="aboutInfo"
    >
        <!-- Page Header -->
        <section
            class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 text-white"
        >
            <div class="mx-auto max-w-7xl px-4 text-center sm:px-6 lg:px-8">
                <span
                    class="text-sm font-semibold tracking-wider text-amber-400 uppercase"
                    >Our Portfolio</span
                >
                <h1 class="mt-3 text-4xl font-bold sm:text-5xl">
                    Our Projects
                </h1>
                <p class="mx-auto mt-4 max-w-2xl text-gray-300">
                    Explore our portfolio of engineering projects across various
                    categories.
                </p>
            </div>
        </section>

        <!-- Category Filter -->
        <section class="sticky top-20 z-40 border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex flex-wrap items-center gap-2">
                        <button
                            @click="filterByCategory('')"
                            :class="
                                !props.filters.category
                                    ? 'bg-amber-500 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                            "
                            class="rounded-full px-4 py-2 text-sm font-medium transition-colors"
                        >
                            All
                        </button>
                        <button
                            v-for="cat in categories"
                            :key="cat.id"
                            @click="filterByCategory(cat.slug)"
                            :class="
                                props.filters.category === cat.slug
                                    ? 'bg-amber-500 text-white'
                                    : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
                            "
                            class="rounded-full px-4 py-2 text-sm font-medium transition-colors"
                        >
                            {{ cat.name }}
                        </button>
                    </div>
                    <span class="hidden text-sm text-gray-500 sm:inline"
                        >{{ projects.length }} project(s)</span
                    >
                </div>
            </div>
        </section>

        <!-- Projects Grid -->
        <section class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div v-if="projects.length === 0" class="py-20 text-center">
                    <Building2 class="mx-auto mb-4 h-16 w-16 text-gray-300" />
                    <p class="text-lg text-gray-500">No projects found.</p>
                    <button
                        v-if="props.filters.category"
                        @click="filterByCategory('')"
                        class="mt-4 font-medium text-amber-600 hover:text-amber-700"
                    >
                        View all projects
                    </button>
                </div>

                <div
                    v-else
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="project in projects"
                        :key="project.id"
                        :href="`/projects/${project.slug}`"
                        class="group overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-gray-200">
                            <img
                                v-if="project.images.length > 0"
                                :src="`/storage/${project.images[0].image}`"
                                :alt="project.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300"
                            >
                                <Building2 class="h-12 w-12 text-gray-400" />
                            </div>
                        </div>
                        <div class="p-6">
                            <div
                                class="mb-3 flex flex-wrap items-center gap-1.5"
                            >
                                <span
                                    v-for="cat in project.categories"
                                    :key="cat.id"
                                    class="rounded-full bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-700"
                                >
                                    {{ cat.name }}
                                </span>
                                <span
                                    v-if="project.project_status"
                                    class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700"
                                >
                                    {{ project.project_status }}
                                </span>
                            </div>
                            <h3
                                class="mb-2 text-lg font-semibold text-gray-900 transition-colors group-hover:text-amber-600"
                            >
                                {{ project.title }}
                            </h3>
                            <p
                                v-if="project.location"
                                class="flex items-center gap-1 text-sm text-gray-500"
                            >
                                <MapPin class="h-3.5 w-3.5" />
                                {{ project.location }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
