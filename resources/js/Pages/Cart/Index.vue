<script setup>
import { computed } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import Button from '@/Components/Button.vue';
import { Inertia } from '@inertiajs/inertia'
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
    auth: Object,
    cart: Object,
});

const cartProductsExist = computed(() => props.cart?.products?.length > 0);
const products = computed(() => props.cart?.products);

const removeFromCart = function(product) {
    Inertia.delete(route('cart.products.destroy', product));
}
</script>

<template>
    <Head title="Cart" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <template v-if="cartProductsExist">
                        <div v-for="product in products" :key="product.id" class="mb-4 pb-4 border-b">
                            <div class="font-semibold">{{ product.title }}</div>
                            <div>{{ product.price }}</div>

                            <Button class="mt-3" @click="removeFromCart(product)">
                                Remove
                            </Button>
                        </div>
                        <div class="mt-4">
                            <div class="mb-2">Cart Total: x</div>
                            <Button @click="checkout">
                                Checkout
                            </Button>
                        </div>
                    </template>
                    <template v-else>
                        Your cart is empty
                    </template>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
