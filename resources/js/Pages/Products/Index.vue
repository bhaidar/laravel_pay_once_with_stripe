<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    products: Array,
});
</script>

<template>
    <Head title="Products" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Products
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <Link
                        v-for="product in props.products"
                        :key="product.id"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6"
                        :href="route('products.show', product)"
                    >
                        <h1 class="text-lg font-semibold mb-2">{{ product.title }}</h1>
                        <div>{{ product.price }}</div>
                        <p>{{ product.description }}</p>
                    </Link>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
