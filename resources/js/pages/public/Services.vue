<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowRight, Building2, Ruler, Box, Wrench, Zap, HardHat } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

type Service = {
    id: number;
    title: string;
    slug: string;
    short_description: string;
    icon: string;
    image: string;
};

type Props = {
    services: Service[];
    aboutInfo: Record<string, string>;
    contactInfo: Record<string, string>;
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
    const key = Object.keys(serviceIcons).find((k) => icon?.toLowerCase().includes(k));

    return key ? serviceIcons[key] : Building2;
}
</script>

<template>
    <PublicLayout title="Our Services" :contact-info="contactInfo" :about-info="aboutInfo">
        <!-- Page Header -->
        <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-amber-400 font-semibold text-sm uppercase tracking-wider">What We Offer</span>
                <h1 class="text-4xl sm:text-5xl font-bold mt-3">Our Services</h1>
                <p class="text-gray-300 mt-4 max-w-2xl mx-auto">
                    Comprehensive engineering solutions from concept to completion.
                </p>
            </div>
        </section>

        <!-- Services Grid -->
        <section class="bg-gray-50 py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div v-if="services.length === 0" class="text-center py-20">
                    <Building2 class="w-16 h-16 text-gray-300 mx-auto mb-4" />
                    <p class="text-gray-500 text-lg">No services available at the moment.</p>
                </div>

                <div v-else class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    <Link
                        v-for="service in services"
                        :key="service.id"
                        :href="`/services/${service.slug}`"
                        class="group bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-xl hover:border-amber-200 transition-all duration-300 hover:-translate-y-1"
                    >
                        <div class="p-8">
                            <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center mb-6 group-hover:bg-amber-500 transition-colors duration-300">
                                <component
                                    :is="getServiceIcon(service.icon || '')"
                                    class="w-7 h-7 text-amber-500 group-hover:text-white transition-colors duration-300"
                                />
                            </div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-3">{{ service.title }}</h3>
                            <p class="text-gray-500 leading-relaxed">{{ service.short_description }}</p>
                            <div class="mt-6 flex items-center gap-2 text-amber-500 font-medium text-sm">
                                Learn More <ArrowRight class="w-4 h-4 group-hover:translate-x-1 transition-transform" />
                            </div>
                        </div>
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
