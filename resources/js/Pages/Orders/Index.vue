<script setup>
import { computed, ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia'
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
    orders: Array,
    auth: Object,
});

const userHasOrders = computed(() => props.orders?.length > 0);
</script>

<template>
    <Head title="Orders" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Orders
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <template v-if="userHasOrders">
                    <div
                        v-for="order in props.orders"
                        :key="order.id"
                        class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                        <div class="font-semibold mb-2">
                            Order #{{order.id}}
                        </div>
                        <div class="my-4">
                            <div
                                class="mb-2"
                                v-for="product in order.products"
                                :key="product.id"
                            >
                                <div>{{ product.title }} <a :href="route('products.download.show', product)" class="text-indigo-500">Download</a></div>
                            </div>
                        </div>
                       <div class="mt-4">
                            <div class="mb-2">Cart Total: {{ order.total }}</div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <p>You have no orders</p>
                </template>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
