<script setup lang="ts">
import PublicLayout from '@/layouts/PublicLayout.vue';
import { Link } from '@inertiajs/vue3';
import {
    ArrowRight,
    Box,
    Building2,
    CheckCircle,
    HardHat,
    MapPin,
    Phone,
    Ruler,
    Wrench,
    Zap,
} from 'lucide-vue-next';

type Service = {
    id: number;
    title: string;
    slug: string;
    short_description: string;
    icon: string;
    image: string;
};

type ProjectImage = {
    id: number;
    image: string;
};

type Category = {
    id: number;
    name: string;
    slug: string;
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

type AboutInfo = {
    company_name: string;
    tagline: string;
    about_text: string;
    years_experience: string;
    total_projects: string;
    happy_clients: string;
    hero_title: string;
    hero_subtitle: string;
    hero_image: string;
    logo: string;
    why_choose_us: string;
};

type ContactInfo = {
    phone: string;
    email: string;
    whatsapp: string;
    facebook_url: string;
    linkedin_url: string;
    address: string;
};

type Props = {
    services: Service[];
    projects: Project[];
    aboutInfo: AboutInfo;
    contactInfo: ContactInfo;
};

defineProps<Props>();

const serviceIcons: Record<string, typeof Building2> = {
    architectural: Building2,
    structural: Ruler,
    '3d': Box,
    plumbing: Wrench,
    electrical: Zap,
    supervision: HardHat,
};

function getServiceIcon(icon: string) {
    const key = Object.keys(serviceIcons).find((k) =>
        icon?.toLowerCase().includes(k),
    );

    return key ? serviceIcons[key] : Building2;
}
</script>

<template>
    <PublicLayout
        title="Home"
        :contact-info="contactInfo"
        :about-info="aboutInfo"
    >
        <!-- Hero Section -->
        <section
            class="relative overflow-hidden bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white"
        >
            <div class="absolute inset-0 opacity-10">
                <div
                    class="absolute inset-0"
                    style="
                        background-image: url('data:image/svg+xml,%3Csvg width=&quot;60&quot; height=&quot;60&quot; viewBox=&quot;0 0 60 60&quot; xmlns=&quot;http://www.w3.org/2000/svg&quot;%3E%3Cg fill=&quot;none&quot; fill-rule=&quot;evenodd&quot;%3E%3Cg fill=&quot;%23ffffff&quot; fill-opacity=&quot;0.4&quot;%3E%3Cpath d=&quot;M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z&quot;/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');
                    "
                ></div>
            </div>
            <div
                class="absolute top-0 right-0 h-96 w-96 rounded-full bg-amber-500/10 blur-3xl"
            ></div>
            <div
                class="absolute bottom-0 left-0 h-96 w-96 rounded-full bg-amber-500/5 blur-3xl"
            ></div>

            <div
                class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-36"
            >
                <div class="max-w-3xl">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/20 px-4 py-1.5"
                    >
                        <div
                            class="h-2 w-2 animate-pulse rounded-full bg-amber-500"
                        ></div>
                        <span class="text-sm font-medium text-amber-300"
                            >Engineering Excellence Since Day One</span
                        >
                    </div>
                    <h1
                        class="mb-6 text-4xl leading-tight font-bold sm:text-5xl lg:text-6xl"
                    >
                        {{
                            aboutInfo?.hero_title ||
                            "Building Tomorrow's Structures Today"
                        }}
                    </h1>
                    <p
                        class="mb-10 max-w-2xl text-lg leading-relaxed text-gray-300 sm:text-xl"
                    >
                        {{
                            aboutInfo?.hero_subtitle ||
                            'Professional engineering consultancy providing comprehensive architectural, structural, and MEP solutions for your construction projects.'
                        }}
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <Link
                            href="/contact"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-8 py-4 font-semibold text-white shadow-lg shadow-amber-500/25 transition-all duration-200 hover:bg-amber-600 hover:shadow-amber-500/40"
                        >
                            Get Consultation
                            <ArrowRight class="h-5 w-5" />
                        </Link>
                        <Link
                            href="/projects"
                            class="inline-flex items-center gap-2 rounded-lg border border-white/20 px-8 py-4 font-semibold text-white backdrop-blur-sm transition-all duration-200 hover:border-white/40"
                        >
                            View Projects
                        </Link>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats -->
        <section class="border-b border-gray-100 bg-white">
            <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 gap-8 md:grid-cols-4">
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-amber-500 sm:text-4xl"
                        >
                            {{ aboutInfo?.years_experience || '10' }}+
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            Years Experience
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-amber-500 sm:text-4xl"
                        >
                            {{ aboutInfo?.total_projects || '150' }}+
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            Projects Completed
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-amber-500 sm:text-4xl"
                        >
                            {{ aboutInfo?.happy_clients || '100' }}+
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            Happy Clients
                        </div>
                    </div>
                    <div class="text-center">
                        <div
                            class="text-3xl font-bold text-amber-500 sm:text-4xl"
                        >
                            6+
                        </div>
                        <div class="mt-1 text-sm text-gray-500">
                            Core Services
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Overview -->
        <section class="bg-gray-50 py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <span
                        class="text-sm font-semibold tracking-wider text-amber-500 uppercase"
                        >What We Do</span
                    >
                    <h2
                        class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl"
                    >
                        Our Services
                    </h2>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-500">
                        Comprehensive engineering solutions tailored to meet the
                        unique demands of every project.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="service in services"
                        :key="service.id"
                        :href="`/services/${service.slug}`"
                        class="group rounded-xl border border-gray-100 bg-white p-8 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-amber-200 hover:shadow-lg"
                    >
                        <div
                            class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl bg-amber-50 transition-colors duration-300 group-hover:bg-amber-500"
                        >
                            <component
                                :is="getServiceIcon(service.icon || '')"
                                class="h-7 w-7 text-amber-500 transition-colors duration-300 group-hover:text-white"
                            />
                        </div>
                        <h3 class="mb-3 text-lg font-semibold text-gray-900">
                            {{ service.title }}
                        </h3>
                        <p class="text-sm leading-relaxed text-gray-500">
                            {{ service.short_description }}
                        </p>
                        <div
                            class="mt-4 flex items-center gap-1 text-sm font-medium text-amber-500 opacity-0 transition-opacity duration-300 group-hover:opacity-100"
                        >
                            Learn More <ArrowRight class="h-4 w-4" />
                        </div>
                    </Link>
                </div>

                <div class="mt-12 text-center">
                    <Link
                        href="/services"
                        class="inline-flex items-center gap-2 font-semibold text-amber-600 transition-colors hover:text-amber-700"
                    >
                        View All Services <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Projects -->
        <section class="bg-white py-20 lg:py-28" v-if="projects.length > 0">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mb-16 text-center">
                    <span
                        class="text-sm font-semibold tracking-wider text-amber-500 uppercase"
                        >Our Portfolio</span
                    >
                    <h2
                        class="mt-3 text-3xl font-bold text-gray-900 sm:text-4xl"
                    >
                        Our Projects
                    </h2>
                    <p class="mx-auto mt-4 max-w-2xl text-gray-500">
                        Explore our latest and most notable engineering
                        projects.
                    </p>
                </div>

                <div
                    class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3"
                >
                    <Link
                        v-for="project in projects"
                        :key="project.id"
                        :href="`/projects/${project.slug}`"
                        class="group relative overflow-hidden rounded-xl shadow-sm transition-all duration-300 hover:shadow-xl"
                    >
                        <div class="aspect-[4/3] overflow-hidden bg-gray-200">
                            <img
                                v-if="project.images.length > 0"
                                :src="`/storage/${project.images[0].image}`"
                                :alt="project.title"
                                class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
                                loading="lazy"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300"
                            >
                                <Building2 class="h-12 w-12 text-gray-400" />
                            </div>
                        </div>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"
                        ></div>
                        <div
                            class="absolute right-0 bottom-0 left-0 p-6 text-white"
                        >
                            <div class="mb-2 flex flex-wrap items-center gap-2">
                                <span
                                    v-for="cat in project.categories"
                                    :key="cat.id"
                                    class="rounded-full bg-amber-500/90 px-2.5 py-1 text-xs font-medium"
                                >
                                    {{ cat.name }}
                                </span>
                                <span
                                    v-if="project.project_status"
                                    class="rounded-full bg-white/20 px-2.5 py-1 text-xs"
                                >
                                    {{ project.project_status }}
                                </span>
                            </div>
                            <h3 class="text-lg font-semibold">
                                {{ project.title }}
                            </h3>
                            <p
                                v-if="project.location"
                                class="mt-1 flex items-center gap-1 text-sm text-gray-300"
                            >
                                <MapPin class="h-3.5 w-3.5" />
                                {{ project.location }}
                            </p>
                        </div>
                    </Link>
                </div>

                <div class="mt-12 text-center">
                    <Link
                        href="/projects"
                        class="inline-flex items-center gap-2 font-semibold text-amber-600 transition-colors hover:text-amber-700"
                    >
                        View All Projects <ArrowRight class="h-5 w-5" />
                    </Link>
                </div>
            </div>
        </section>

        <!-- Why Choose Us -->
        <section class="bg-gray-50 py-20 lg:py-28">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div
                    class="grid grid-cols-1 items-center gap-16 lg:grid-cols-2"
                >
                    <div>
                        <span
                            class="text-sm font-semibold tracking-wider text-amber-500 uppercase"
                            >Why Choose Us</span
                        >
                        <h2
                            class="mt-3 mb-8 text-3xl font-bold text-gray-900 sm:text-4xl"
                        >
                            Trusted Engineering Partner for Your Vision
                        </h2>
                        <div class="space-y-5">
                            <div class="flex gap-4">
                                <CheckCircle
                                    class="mt-0.5 h-6 w-6 flex-shrink-0 text-amber-500"
                                />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Experienced Team
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Our team of licensed engineers brings
                                        decades of combined experience.
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <CheckCircle
                                    class="mt-0.5 h-6 w-6 flex-shrink-0 text-amber-500"
                                />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        End-to-End Solutions
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        From architectural design to site
                                        supervision, we handle every phase.
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <CheckCircle
                                    class="mt-0.5 h-6 w-6 flex-shrink-0 text-amber-500"
                                />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Quality Assurance
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        We adhere to the highest standards of
                                        structural safety and design quality.
                                    </p>
                                </div>
                            </div>
                            <div class="flex gap-4">
                                <CheckCircle
                                    class="mt-0.5 h-6 w-6 flex-shrink-0 text-amber-500"
                                />
                                <div>
                                    <h3 class="font-semibold text-gray-900">
                                        Timely Delivery
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        We value your time and ensure prompt
                                        delivery without compromising quality.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="relative">
                        <div
                            class="aspect-[4/3] overflow-hidden rounded-2xl bg-gradient-to-br from-amber-100 to-amber-50"
                        >
                            <img
                                v-if="aboutInfo?.hero_image"
                                :src="`/storage/${aboutInfo.hero_image}`"
                                alt="Our Work"
                                class="h-full w-full object-cover"
                                loading="lazy"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center"
                            >
                                <Building2 class="h-24 w-24 text-amber-300" />
                            </div>
                        </div>
                        <div
                            class="absolute -bottom-6 -left-6 rounded-xl bg-amber-500 px-6 py-4 text-white shadow-xl"
                        >
                            <div class="text-2xl font-bold">
                                {{ aboutInfo?.years_experience || '10' }}+
                            </div>
                            <div class="text-sm opacity-90">
                                Years of Excellence
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="bg-gradient-to-r from-gray-900 to-gray-800 py-20">
            <div class="mx-auto max-w-4xl px-4 text-center sm:px-6 lg:px-8">
                <h2 class="mb-6 text-3xl font-bold text-white sm:text-4xl">
                    Ready to Start Your Project?
                </h2>
                <p class="mx-auto mb-10 max-w-2xl text-lg text-gray-300">
                    Get in touch with our expert team for a free consultation.
                    Let's build something extraordinary together.
                </p>
                <div class="flex flex-wrap justify-center gap-4">
                    <Link
                        href="/contact"
                        class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-8 py-4 font-semibold text-white shadow-lg shadow-amber-500/25 transition-all duration-200 hover:bg-amber-600"
                    >
                        <Phone class="h-5 w-5" />
                        Get Consultation
                    </Link>
                    <a
                        v-if="contactInfo?.whatsapp"
                        :href="`https://wa.me/${contactInfo.whatsapp}`"
                        target="_blank"
                        class="inline-flex items-center gap-2 rounded-lg bg-green-600 px-8 py-4 font-semibold text-white transition-all duration-200 hover:bg-green-700"
                    >
                        <svg
                            class="h-5 w-5"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"
                            />
                        </svg>
                        WhatsApp
                    </a>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
