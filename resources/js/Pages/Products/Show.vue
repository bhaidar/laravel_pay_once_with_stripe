<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';

const props = defineProps({
    product: Object,
});

const addToCart = function(e) {
    Inertia.post(route('cart.products.store'), {
        product_id: props.product.id,
    });
}
</script>

<template>
    <Head title="Product" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ props.product.name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                         <h1 class="text-lg font-semibold mb-2">{{ props.product.title }}</h1>
                        <div>{{ props.product.price }}</div>
                        <p>{{ props.product.description }}</p>


                        <Button class="mt-3" @click="addToCart">
                            Add to cart
                        </Button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
