<script setup lang="ts">
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import type { BreadcrumbItem } from '@/types';

type AboutInfoType = {
    id: number;
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
    meta_title: string;
    meta_description: string;
    why_choose_us: string;
};

type Props = {
    aboutInfo: AboutInfoType;
};

const props = defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
    { title: 'About Info', href: '/admin/about-info' },
];

const form = ref({
    company_name: props.aboutInfo.company_name || '',
    tagline: props.aboutInfo.tagline || '',
    about_text: props.aboutInfo.about_text || '',
    years_experience: props.aboutInfo.years_experience || '',
    total_projects: props.aboutInfo.total_projects || '',
    happy_clients: props.aboutInfo.happy_clients || '',
    hero_title: props.aboutInfo.hero_title || '',
    hero_subtitle: props.aboutInfo.hero_subtitle || '',
    hero_image: null as File | null,
    logo: null as File | null,
    meta_title: props.aboutInfo.meta_title || '',
    meta_description: props.aboutInfo.meta_description || '',
    why_choose_us: props.aboutInfo.why_choose_us || '',
});

const heroImagePreview = ref<string | null>(
    props.aboutInfo.hero_image ? `/storage/${props.aboutInfo.hero_image}` : null,
);
const logoPreview = ref<string | null>(
    props.aboutInfo.logo ? `/storage/${props.aboutInfo.logo}` : null,
);
const processing = ref(false);
const errors = ref<Record<string, string>>({});
const saved = ref(false);

function handleHeroImageChange(e: Event) {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.value.hero_image = target.files[0];
        heroImagePreview.value = URL.createObjectURL(target.files[0]);
    }
}

function handleLogoChange(e: Event) {
    const target = e.target as HTMLInputElement;

    if (target.files && target.files[0]) {
        form.value.logo = target.files[0];
        logoPreview.value = URL.createObjectURL(target.files[0]);
    }
}

function submit() {
    processing.value = true;
    saved.value = false;
    const formData = new FormData();

    Object.entries(form.value).forEach(([key, value]) => {
        if ((key === 'hero_image' || key === 'logo') && value instanceof File) {
            formData.append(key, value);
        } else if (key === 'hero_image' || key === 'logo') {
            return;
        } else if (value !== null && value !== undefined) {
            formData.append(key, String(value));
        }
    });

    router.post('/admin/about-info', formData, {
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
    <Head title="About Info" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-6 p-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">About Info</h2>
                <p class="text-sm text-gray-500 mt-1">Manage company information displayed on the website</p>
            </div>

            <form @submit.prevent="submit" class="max-w-3xl space-y-6">
                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Company Details</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company Name</label>
                            <input v-model="form.company_name" type="text" placeholder="Urban Structural Solutions" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tagline</label>
                            <input v-model="form.tagline" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">About Text (HTML supported)</label>
                        <textarea v-model="form.about_text" rows="5" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-mono"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Why Choose Us (HTML supported)</label>
                        <textarea v-model="form.why_choose_us" rows="5" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white font-mono"></textarea>
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Statistics</h3>

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Years Experience</label>
                            <input v-model="form.years_experience" type="text" placeholder="10" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Projects</label>
                            <input v-model="form.total_projects" type="text" placeholder="150" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Happy Clients</label>
                            <input v-model="form.happy_clients" type="text" placeholder="100" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                        </div>
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Hero Section</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hero Title</label>
                        <input v-model="form.hero_title" type="text" placeholder="Building Tomorrow's Structures Today" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hero Subtitle</label>
                        <textarea v-model="form.hero_subtitle" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hero Image</label>
                        <input type="file" accept="image/*" @change="handleHeroImageChange" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                        <img v-if="heroImagePreview" :src="heroImagePreview" alt="Hero Preview" class="mt-3 w-64 h-40 object-cover rounded-lg" />
                        <p v-if="errors.hero_image" class="text-red-500 text-xs mt-1">{{ errors.hero_image }}</p>
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">Branding</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Logo</label>
                        <input type="file" accept="image/*" @change="handleLogoChange" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100" />
                        <img v-if="logoPreview" :src="logoPreview" alt="Logo Preview" class="mt-3 w-24 h-24 object-cover rounded-full" />
                        <p v-if="errors.logo" class="text-red-500 text-xs mt-1">{{ errors.logo }}</p>
                    </div>
                </div>

                <div class="rounded-xl border bg-white dark:bg-gray-900 p-6 space-y-5">
                    <h3 class="font-semibold text-gray-900 dark:text-white border-b pb-3">SEO</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Title</label>
                        <input v-model="form.meta_title" type="text" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Meta Description</label>
                        <textarea v-model="form.meta_description" rows="2" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 text-sm focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"></textarea>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <button type="submit" :disabled="processing" class="bg-amber-500 hover:bg-amber-600 disabled:opacity-50 text-white px-6 py-2.5 rounded-lg font-semibold text-sm transition-colors">
                        {{ processing ? 'Saving...' : 'Save About Info' }}
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
