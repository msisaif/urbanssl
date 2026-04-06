<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { ArrowLeft, Phone } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

type Service = {
    id: number;
    title: string;
    slug: string;
    short_description: string;
    description: string;
    icon: string;
    image: string;
    meta_title: string;
    meta_description: string;
};

type Props = {
    service: Service;
    aboutInfo: Record<string, string>;
    contactInfo: Record<string, string>;
};

defineProps<Props>();
</script>

<template>
    <PublicLayout
        :title="service.title"
        :meta-title="service.meta_title || service.title"
        :meta-description="service.meta_description || service.short_description"
        :contact-info="contactInfo"
        :about-info="aboutInfo"
    >
        <!-- Page Header -->
        <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <Link href="/services" class="inline-flex items-center gap-2 text-gray-400 hover:text-white mb-6 transition-colors">
                    <ArrowLeft class="w-4 h-4" />
                    Back to Services
                </Link>
                <h1 class="text-4xl sm:text-5xl font-bold">{{ service.title }}</h1>
                <p v-if="service.short_description" class="text-gray-300 mt-4 max-w-2xl text-lg">
                    {{ service.short_description }}
                </p>
            </div>
        </section>

        <!-- Service Content -->
        <section class="py-16">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-gray-900">
                <img
                    v-if="service.image"
                    :src="`/storage/${service.image}`"
                    :alt="service.title"
                    class="w-full rounded-xl mb-10 shadow-lg"
                    loading="lazy"
                />

                <div
                    v-if="service.description"
                    class="prose prose-lg max-w-none prose-headings:text-gray-900 prose-p:text-gray-600 prose-a:text-amber-600 whitespace-pre-wrap text-justify"
                    v-html="service.description"
                />

                <!-- CTA -->
                <div class="mt-16 bg-gradient-to-r from-amber-50 to-amber-100/50 rounded-xl p-8 sm:p-12 text-center">
                    <h3 class="text-2xl font-bold text-gray-900 mb-4">Interested in this service?</h3>
                    <p class="text-gray-600 mb-8">Contact us to discuss your project requirements.</p>
                    <Link
                        href="/contact"
                        class="inline-flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-8 py-3.5 rounded-lg font-semibold transition-all shadow-lg shadow-amber-500/25"
                    >
                        <Phone class="w-5 h-5" />
                        Get Consultation
                    </Link>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
