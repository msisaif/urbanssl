<script setup lang="ts">
import { Head, Link } from '@inertiajs/vue3';
import { Menu, Phone, X } from 'lucide-vue-next';
import { ref } from 'vue';

type Props = {
    title?: string;
    metaTitle?: string;
    metaDescription?: string;
    contactInfo?: {
        phone?: string;
        email?: string;
        whatsapp?: string;
        facebook_url?: string;
        linkedin_url?: string;
    };
    aboutInfo?: {
        company_name?: string;
        logo?: string;
    };
};

withDefaults(defineProps<Props>(), {
    title: 'Urban Structural Solutions',
});

const mobileMenuOpen = ref(false);

const navLinks = [
    { label: 'Home', href: '/' },
    { label: 'Services', href: '/services' },
    { label: 'Projects', href: '/projects' },
    { label: 'Contact', href: '/contact' },
];
</script>

<template>
    <Head :title="title">
        <meta v-if="metaTitle" name="title" :content="metaTitle" />
        <meta
            v-if="metaDescription"
            name="description"
            :content="metaDescription"
        />
        <meta v-if="metaTitle" property="og:title" :content="metaTitle" />
        <meta
            v-if="metaDescription"
            property="og:description"
            :content="metaDescription"
        />
    </Head>

    <div class="flex min-h-screen flex-col bg-white">
        <!-- Navbar -->
        <nav
            class="sticky top-0 z-50 border-b border-gray-100 bg-white/95 shadow-sm backdrop-blur-sm"
        >
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-20 items-center justify-between">
                    <!-- Logo -->
                    <Link href="/" class="flex items-center gap-3">
                        <img
                            v-if="aboutInfo?.logo"
                            :src="`/storage/${aboutInfo.logo}`"
                            alt="Urban Structural Solutions"
                            class="h-12 w-12 rounded-full object-cover"
                        />
                        <div
                            v-else
                            class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-500"
                        >
                            <span class="text-lg font-bold text-white">U</span>
                        </div>
                        <div class="hidden sm:block">
                            <span
                                class="block text-xl leading-tight font-bold text-gray-900"
                                >Urban</span
                            >
                            <span
                                class="text-xs font-medium tracking-wider text-gray-500 uppercase"
                                >Structural Solutions</span
                            >
                        </div>
                    </Link>

                    <!-- Desktop Nav -->
                    <div class="hidden items-center gap-8 md:flex">
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="relative text-sm font-medium text-gray-600 transition-colors duration-200 after:absolute after:bottom-[-4px] after:left-0 after:h-0.5 after:w-0 after:bg-amber-500 after:transition-all after:duration-300 hover:text-amber-600 hover:after:w-full"
                        >
                            {{ link.label }}
                        </Link>
                        <a
                            v-if="contactInfo?.phone"
                            :href="`tel:${contactInfo.phone}`"
                            class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white shadow-lg shadow-amber-500/25 transition-all duration-200 hover:bg-amber-600"
                        >
                            <Phone class="h-4 w-4" />
                            {{ contactInfo.phone }}
                        </a>
                    </div>

                    <!-- Mobile menu button -->
                    <button
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        class="p-2 text-gray-600 md:hidden"
                    >
                        <X v-if="mobileMenuOpen" class="h-6 w-6" />
                        <Menu v-else class="h-6 w-6" />
                    </button>
                </div>

                <!-- Mobile Nav -->
                <Transition
                    enter-active-class="transition duration-200 ease-out"
                    enter-from-class="opacity-0 -translate-y-2"
                    enter-to-class="opacity-100 translate-y-0"
                    leave-active-class="transition duration-150 ease-in"
                    leave-from-class="opacity-100 translate-y-0"
                    leave-to-class="opacity-0 -translate-y-2"
                >
                    <div
                        v-if="mobileMenuOpen"
                        class="mt-2 border-t border-gray-100 pt-4 pb-4 md:hidden"
                    >
                        <Link
                            v-for="link in navLinks"
                            :key="link.href"
                            :href="link.href"
                            class="block py-2.5 text-sm font-medium text-gray-600 hover:text-amber-600"
                            @click="mobileMenuOpen = false"
                        >
                            {{ link.label }}
                        </Link>
                        <a
                            v-if="contactInfo?.phone"
                            :href="`tel:${contactInfo.phone}`"
                            class="mt-3 inline-flex items-center gap-2 rounded-lg bg-amber-500 px-5 py-2.5 text-sm font-semibold text-white"
                        >
                            <Phone class="h-4 w-4" />
                            {{ contactInfo.phone }}
                        </a>
                    </div>
                </Transition>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-1">
            <slot />
        </main>

        <!-- Footer -->
        <footer class="bg-gray-900 text-gray-300">
            <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-3">
                    <!-- Company Info -->
                    <div>
                        <div class="mb-4 flex items-center gap-3">
                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-full bg-amber-500"
                            >
                                <span class="font-bold text-white">U</span>
                            </div>
                            <div>
                                <span class="block font-bold text-white"
                                    >Urban Structural Solutions</span
                                >
                            </div>
                        </div>
                        <p class="text-sm leading-relaxed text-gray-400">
                            Professional engineering consultancy providing
                            architectural, structural, and MEP solutions for
                            residential and commercial projects.
                        </p>
                    </div>

                    <!-- Quick Links -->
                    <div>
                        <h3 class="mb-4 font-semibold text-white">
                            Quick Links
                        </h3>
                        <ul class="space-y-2">
                            <li v-for="link in navLinks" :key="link.href">
                                <Link
                                    :href="link.href"
                                    class="text-sm text-gray-400 transition-colors hover:text-amber-500"
                                >
                                    {{ link.label }}
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="mb-4 font-semibold text-white">
                            Contact Us
                        </h3>
                        <ul class="space-y-3">
                            <li v-if="contactInfo?.phone">
                                <a
                                    :href="`tel:${contactInfo.phone}`"
                                    class="text-sm text-gray-400 transition-colors hover:text-amber-500"
                                >
                                    {{ contactInfo.phone }}
                                </a>
                            </li>
                            <li v-if="contactInfo?.email">
                                <a
                                    :href="`mailto:${contactInfo.email}`"
                                    class="text-sm text-gray-400 transition-colors hover:text-amber-500"
                                >
                                    {{ contactInfo.email }}
                                </a>
                            </li>
                            <li
                                v-if="contactInfo?.address"
                                class="text-sm text-gray-400"
                            >
                                {{ contactInfo.address }}
                            </li>
                        </ul>
                        <div class="mt-4 flex gap-3">
                            <a
                                v-if="contactInfo?.facebook_url"
                                :href="contactInfo.facebook_url"
                                target="_blank"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-amber-500"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"
                                    />
                                </svg>
                            </a>
                            <a
                                v-if="contactInfo?.linkedin_url"
                                :href="contactInfo.linkedin_url"
                                target="_blank"
                                class="flex h-9 w-9 items-center justify-center rounded-full bg-gray-800 transition-colors hover:bg-amber-500"
                            >
                                <svg
                                    class="h-4 w-4"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6zM2 9h4v12H2z"
                                    />
                                    <circle cx="4" cy="4" r="2" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="mt-12 border-t border-gray-800 pt-8 text-center">
                    <p class="text-sm text-gray-500">
                        &copy; {{ new Date().getFullYear() }} Urban Structural
                        Solutions. All rights reserved.
                    </p>
                </div>
            </div>
        </footer>
    </div>
</template>
