<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import {
    ArrowLeft,
    Building2,
    Calendar,
    ChevronLeft,
    ChevronRight,
    MapPin,
    Maximize2,
    Phone,
    User,
    X,
} from 'lucide-vue-next';
import { ref } from 'vue';
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
    owner: string;
    project_status: string;
    project_date: string;
    description: string;
    meta_title: string;
    meta_description: string;
    images: ProjectImage[];
    categories: Category[];
};

type Props = {
    project: Project;
    relatedProjects: Project[];
    aboutInfo: Record<string, string>;
    contactInfo: Record<string, string>;
};

defineProps<Props>();

const lightboxOpen = ref(false);
const lightboxIndex = ref(0);

function openLightbox(index: number) {
    lightboxIndex.value = index;
    lightboxOpen.value = true;
}

function closeLightbox() {
    lightboxOpen.value = false;
}

function nextImage(total: number) {
    lightboxIndex.value = (lightboxIndex.value + 1) % total;
}

function prevImage(total: number) {
    lightboxIndex.value = (lightboxIndex.value - 1 + total) % total;
}
</script>

<template>
    <PublicLayout
        :title="project.title"
        :meta-title="project.meta_title || project.title"
        :meta-description="project.meta_description"
        :contact-info="contactInfo"
        :about-info="aboutInfo"
    >
        <!-- Page Header -->
        <section
            class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 py-20 text-white"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <Link
                    href="/projects"
                    class="mb-6 inline-flex items-center gap-2 text-gray-400 transition-colors hover:text-white"
                >
                    <ArrowLeft class="h-4 w-4" />
                    Back to Projects
                </Link>
                <div class="mb-4 flex flex-wrap items-center gap-2">
                    <span
                        v-for="cat in project.categories"
                        :key="cat.id"
                        class="rounded-full bg-amber-500/90 px-3 py-1.5 text-xs font-medium"
                    >
                        {{ cat.name }}
                    </span>
                    <span
                        v-if="project.project_status"
                        class="rounded-full bg-white/10 px-3 py-1.5 text-xs font-medium"
                    >
                        {{ project.project_status }}
                    </span>
                </div>
                <h1 class="text-4xl font-bold sm:text-5xl">
                    {{ project.title }}
                </h1>
                <p
                    v-if="project.location"
                    class="mt-4 flex items-center gap-2 text-lg text-gray-300"
                >
                    <MapPin class="h-5 w-5 text-amber-400" />
                    {{ project.location }}
                </p>
            </div>
        </section>

        <!-- Project Details -->
        <section class="py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <!-- Info Cards -->
                <div class="mb-12 grid grid-cols-2 gap-4 sm:grid-cols-4">
                    <div
                        v-if="project.location"
                        class="rounded-xl bg-gray-50 p-5"
                    >
                        <div
                            class="mb-2 flex items-center gap-2 text-xs tracking-wider text-gray-500 uppercase"
                        >
                            <MapPin class="h-4 w-4" /> Location
                        </div>
                        <div class="font-semibold text-gray-900">
                            {{ project.location }}
                        </div>
                    </div>
                    <div v-if="project.owner" class="rounded-xl bg-gray-50 p-5">
                        <div
                            class="mb-2 flex items-center gap-2 text-xs tracking-wider text-gray-500 uppercase"
                        >
                            <User class="h-4 w-4" /> Owner
                        </div>
                        <div class="font-semibold text-gray-900">
                            {{ project.owner }}
                        </div>
                    </div>
                    <div
                        v-if="project.project_status"
                        class="rounded-xl bg-gray-50 p-5"
                    >
                        <div
                            class="mb-2 flex items-center gap-2 text-xs tracking-wider text-gray-500 uppercase"
                        >
                            <Building2 class="h-4 w-4" /> Status
                        </div>
                        <div class="font-semibold text-gray-900">
                            {{ project.project_status }}
                        </div>
                    </div>
                    <div
                        v-if="project.project_date"
                        class="rounded-xl bg-gray-50 p-5"
                    >
                        <div
                            class="mb-2 flex items-center gap-2 text-xs tracking-wider text-gray-500 uppercase"
                        >
                            <Calendar class="h-4 w-4" /> Date
                        </div>
                        <div class="font-semibold text-gray-900">
                            {{ project.project_date }}
                        </div>
                    </div>
                </div>

                <!-- Image Gallery -->
                <div v-if="project.images.length > 0" class="mb-12">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">
                        Project Gallery
                    </h2>
                    <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                        <div
                            v-for="(img, index) in project.images"
                            :key="img.id"
                            class="group relative aspect-[4/3] cursor-pointer overflow-hidden rounded-xl"
                            @click="openLightbox(index)"
                        >
                            <img
                                :src="`/storage/${img.image}`"
                                :alt="`${project.title} - Image ${index + 1}`"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                class="absolute inset-0 flex items-center justify-center bg-black/0 transition-colors group-hover:bg-black/30"
                            >
                                <Maximize2
                                    class="h-8 w-8 text-white opacity-0 transition-opacity group-hover:opacity-100"
                                />
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div v-if="project.description" class="mb-12 text-gray-900">
                    <h2 class="mb-6 text-2xl font-bold text-gray-900">
                        Project Description
                    </h2>
                    <div
                        class="prose prose-lg prose-headings:text-gray-900 prose-p:text-gray-600 max-w-none whitespace-pre-wrap text-justify"
                        v-html="project.description"
                    />
                </div>

                <!-- CTA -->
                <div
                    class="rounded-xl bg-gradient-to-r from-amber-50 to-amber-100/50 p-8 text-center sm:p-12"
                >
                    <h3 class="mb-4 text-2xl font-bold text-gray-900">
                        Have a Similar Project?
                    </h3>
                    <p class="mb-8 text-gray-600">
                        Let us help you bring your vision to life.
                    </p>
                    <Link
                        href="/contact"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-8 py-3.5 font-semibold text-white shadow-lg shadow-amber-500/25 transition-all hover:bg-amber-600"
                    >
                        <Phone class="h-5 w-5" />
                        Get Consultation
                    </Link>
                </div>
            </div>
        </section>

        <!-- Related Projects -->
        <section v-if="relatedProjects.length > 0" class="bg-gray-50 py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <h2 class="mb-8 text-2xl font-bold text-gray-900">
                    Related Projects
                </h2>
                <div
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4"
                >
                    <Link
                        v-for="rp in relatedProjects"
                        :key="rp.id"
                        :href="`/projects/${rp.slug}`"
                        class="group overflow-hidden rounded-xl border border-gray-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-gray-200">
                            <img
                                v-if="rp.images.length > 0"
                                :src="`/storage/${rp.images[0].image}`"
                                :alt="rp.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                loading="lazy"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300"
                            >
                                <Building2 class="h-10 w-10 text-gray-400" />
                            </div>
                        </div>
                        <div class="p-4">
                            <h3
                                class="line-clamp-1 font-semibold text-gray-900 transition-colors group-hover:text-amber-600"
                            >
                                {{ rp.title }}
                            </h3>
                            <p
                                v-if="rp.location"
                                class="mt-1 flex items-center gap-1 text-xs text-gray-500"
                            >
                                <MapPin class="h-3 w-3" />
                                {{ rp.location }}
                            </p>
                        </div>
                    </Link>
                </div>
            </div>
        </section>

        <!-- Lightbox -->
        <Teleport to="body">
            <Transition
                enter-active-class="transition duration-200 ease-out"
                enter-from-class="opacity-0"
                enter-to-class="opacity-100"
                leave-active-class="transition duration-150 ease-in"
                leave-from-class="opacity-100"
                leave-to-class="opacity-0"
            >
                <div
                    v-if="lightboxOpen && project.images.length > 0"
                    class="fixed inset-0 z-[100] flex items-center justify-center bg-black/95"
                    @click.self="closeLightbox"
                >
                    <button
                        @click="closeLightbox"
                        class="absolute top-4 right-4 z-10 text-white/70 hover:text-white"
                    >
                        <X class="h-8 w-8" />
                    </button>
                    <button
                        v-if="project.images.length > 1"
                        @click="prevImage(project.images.length)"
                        class="absolute left-4 z-10 text-white/70 hover:text-white"
                    >
                        <ChevronLeft class="h-10 w-10" />
                    </button>
                    <button
                        v-if="project.images.length > 1"
                        @click="nextImage(project.images.length)"
                        class="absolute right-4 z-10 text-white/70 hover:text-white"
                    >
                        <ChevronRight class="h-10 w-10" />
                    </button>
                    <img
                        :src="`/storage/${project.images[lightboxIndex].image}`"
                        :alt="`${project.title} - Image ${lightboxIndex + 1}`"
                        class="max-h-[85vh] max-w-[90vw] rounded-lg object-contain"
                    />
                    <div class="absolute bottom-4 text-sm text-white/50">
                        {{ lightboxIndex + 1 }} / {{ project.images.length }}
                    </div>
                </div>
            </Transition>
        </Teleport>
    </PublicLayout>
</template>
