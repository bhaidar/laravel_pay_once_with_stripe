<script setup>
import { computed, ref } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Inertia } from '@inertiajs/inertia'
import { Head, Link } from '@inertiajs/inertia-vue3';
import Button from '@/Components/Button.vue';

const props = defineProps({
    checkoutSessionId: String,
});

const stripeKeyRef = ref(import.meta.env.VITE_STRIPE_KEY);

const checkout = async function(e) {
    let result = null;
    try {
        await window.Stripe(stripeKeyRef.value).redirectToCheckout({
            sessionId: props.checkoutSessionId
        });
    } catch (error) {
        alert(error.message);
    }
}
</script>

<template>
    <Head title="Checkout" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Checkout
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <Button @click.prevent="checkout">Pay</Button>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
