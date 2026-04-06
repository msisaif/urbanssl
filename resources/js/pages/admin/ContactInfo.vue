<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type ContactInfoType = {
    id: number;
    phone: string;
    email: string;
    whatsapp: string;
    facebook_url: string;
    linkedin_url: string;
    google_map_embed: string;
    address: string;
};

type Props = {
    contactInfo: ContactInfoType;
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'Contact Info', href: '/admin/contact-info' },
];

const form = ref({
    phone: props.contactInfo.phone || '',
    email: props.contactInfo.email || '',
    whatsapp: props.contactInfo.whatsapp || '',
    facebook_url: props.contactInfo.facebook_url || '',
    linkedin_url: props.contactInfo.linkedin_url || '',
    google_map_embed: props.contactInfo.google_map_embed || '',
    address: props.contactInfo.address || '',
});

const processing = ref(false);
const errors = ref<Record<string, string>>({});
const saved = ref(false);

function submit() {
    processing.value = true;
    saved.value = false;

    router.post('/admin/contact-info', form.value, {
        onSuccess: () => {
            saved.value = true;
            setTimeout(() => {
                saved.value = false;
            }, 3000);
        },
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
    <Head title="Contact Info" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Contact Info</h2>
                <p class="text-sm text-gray-500 mt-1">Manage your contact details shown on the website</p>
            </div>

            <form @submit.prevent="submit" class="max-w-3xl space-y-6">
                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Contact Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Phone</label>
                            <input v-model="form.phone" type="text" placeholder="01766-777276" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                            <p v-if="errors.phone" class="text-red-500 text-xs mt-1">{{ errors.phone }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                            <input v-model="form.email" type="email" placeholder="urbansslbd@gmail.com" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                            <p v-if="errors.email" class="text-red-500 text-xs mt-1">{{ errors.email }}</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">WhatsApp Number</label>
                        <input v-model="form.whatsapp" type="text" placeholder="8801766777276 (with country code, no +)" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        <p class="text-xs text-gray-400 mt-1">Used for wa.me link. Include country code without +</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Address</label>
                        <input v-model="form.address" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Social Links</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Facebook URL</label>
                        <input v-model="form.facebook_url" type="url" placeholder="https://facebook.com/..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">LinkedIn URL</label>
                        <input v-model="form.linkedin_url" type="url" placeholder="https://linkedin.com/..." class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Google Map</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Google Map Embed Code</label>
                        <textarea v-model="form.google_map_embed" rows="4" placeholder='Paste the <iframe> embed code from Google Maps' class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-mono"></textarea>
                        <p class="text-xs text-gray-400 mt-1">Go to Google Maps → Share → Embed a map → Copy HTML</p>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="processing" class="bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-colors">
                        {{ processing ? 'Saving...' : 'Save Contact Info' }}
                    </button>
                    <Transition
                        enter-active-class="transition ease-in-out"
                        enter-from-class="opacity-0"
                        leave-active-class="transition ease-in-out"
                        leave-to-class="opacity-0"
                    >
                        <p v-if="saved" class="text-sm text-green-600 font-medium">Saved successfully!</p>
                    </Transition>
                </div>
            </form>
        </div>
    </AppLayout>
</template>
