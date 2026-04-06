<script setup lang="ts">
import { Phone, Mail, MapPin, ExternalLink } from 'lucide-vue-next';
import PublicLayout from '@/layouts/PublicLayout.vue';

type ContactInfo = {
    phone: string;
    email: string;
    whatsapp: string;
    facebook_url: string;
    linkedin_url: string;
    google_map_embed: string;
    address: string;
};

type Props = {
    contactInfo: ContactInfo;
    aboutInfo: Record<string, string>;
};

defineProps<Props>();
</script>

<template>
    <PublicLayout title="Contact Us" :contact-info="contactInfo" :about-info="aboutInfo">
        <!-- Page Header -->
        <section class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 text-white py-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <span class="text-amber-400 font-semibold text-sm uppercase tracking-wider">Contact</span>
                <h1 class="text-4xl sm:text-5xl font-bold mt-3">Get in Touch</h1>
                <p class="text-gray-300 mt-4 max-w-2xl mx-auto text-lg">
                    Have a project in mind? We'd love to hear from you.
                </p>
            </div>
        </section>

        <!-- Contact Details -->
        <section class="py-20">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                    <!-- Phone -->
                    <a
                        v-if="contactInfo?.phone"
                        :href="`tel:${contactInfo.phone}`"
                        class="group flex items-start gap-5 bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-lg hover:border-amber-200 transition-all duration-300"
                    >
                        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                            <Phone class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Phone</h3>
                            <p class="text-amber-600 font-medium text-lg">{{ contactInfo.phone }}</p>
                            <p class="text-sm text-gray-400 mt-1">Tap to call</p>
                        </div>
                    </a>

                    <!-- Email -->
                    <a
                        v-if="contactInfo?.email"
                        :href="`mailto:${contactInfo.email}`"
                        class="group flex items-start gap-5 bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-lg hover:border-amber-200 transition-all duration-300"
                    >
                        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-amber-500 transition-colors">
                            <Mail class="w-6 h-6 text-amber-500 group-hover:text-white transition-colors" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Email</h3>
                            <p class="text-amber-600 font-medium">{{ contactInfo.email }}</p>
                            <p class="text-sm text-gray-400 mt-1">Tap to send email</p>
                        </div>
                    </a>

                    <!-- Address -->
                    <div
                        v-if="contactInfo?.address"
                        class="flex items-start gap-5 bg-white border border-gray-100 rounded-xl p-8 shadow-sm"
                    >
                        <div class="w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                            <MapPin class="w-6 h-6 text-amber-500" />
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">Address</h3>
                            <p class="text-gray-600">{{ contactInfo.address }}</p>
                        </div>
                    </div>

                    <!-- WhatsApp -->
                    <a
                        v-if="contactInfo?.whatsapp"
                        :href="`https://wa.me/${contactInfo.whatsapp}`"
                        target="_blank"
                        class="group flex items-start gap-5 bg-white border border-gray-100 rounded-xl p-8 shadow-sm hover:shadow-lg hover:border-green-200 transition-all duration-300"
                    >
                        <div class="w-14 h-14 bg-green-50 rounded-xl flex items-center justify-center flex-shrink-0 group-hover:bg-green-500 transition-colors">
                            <svg class="w-6 h-6 text-green-500 group-hover:text-white transition-colors" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 text-lg mb-1">WhatsApp</h3>
                            <p class="text-green-600 font-medium">Chat with us</p>
                            <p class="text-sm text-gray-400 mt-1">Tap to open WhatsApp</p>
                        </div>
                    </a>
                </div>

                <!-- Social Links -->
                <div class="flex justify-center gap-4 mb-16">
                    <a
                        v-if="contactInfo?.facebook_url"
                        :href="contactInfo.facebook_url"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                        Facebook
                        <ExternalLink class="w-4 h-4" />
                    </a>
                    <a
                        v-if="contactInfo?.linkedin_url"
                        :href="contactInfo.linkedin_url"
                        target="_blank"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-medium transition-colors"
                    >
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/></svg>
                        LinkedIn
                        <ExternalLink class="w-4 h-4" />
                    </a>
                </div>

                <!-- Google Map -->
                <div v-if="contactInfo?.google_map_embed" class="rounded-xl overflow-hidden shadow-lg border border-gray-100">
                    <div v-html="contactInfo.google_map_embed" class="w-full [&>iframe]:w-full [&>iframe]:h-[400px] [&>iframe]:border-0"></div>
                </div>
            </div>
        </section>
    </PublicLayout>
</template>
