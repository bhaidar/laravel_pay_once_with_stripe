<template>
    <Head title="Payment" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Payment
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                         <StripeElements
                            v-slot="{ elements }"
                            ref="elms"
                            :stripe-key="stripeKey"
                            :instance-options="instanceOptions"
                            :elements-options="elementsOptions"
                            class="py-8"
                        >
                            <!-- type="payment" -->
                            <StripeElement
                                ref="card"
                                :elements="elements"
                                :options="cardOptions"
                            />
                        </StripeElements>
                        <div v-if="cardError" v-text="cardError" class="text-red-500 mt-2" />
                        <BreezeButton class="mt-4" @click.prevent="makePayment">Make Payment</BreezeButton>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import { computed, ref } from 'vue';
import { Inertia } from '@inertiajs/inertia'
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { StripeElements, StripeElement } from 'vue-stripe-js'
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import BreezeButton from '@/Components/Button.vue';

const props = defineProps({
    'paymentIntent': Object,
});

const user = computed(() => usePage().props.value.auth.user);

const stripe = () => elms.value.instance;
const cardElement = () => card.value.stripeElement;

const makePayment = async function(e) {
    cardError.value = null;

    // Use this code with payment elements not card element
    // const { paymentIntent, error } = await stripe().confirmPayment({
    //     elements: card.value.elements,
    //     confirmParams: {
    //         return_url: 'http://localhost:8098/dashboard',
    //     }
    // });


    // Use this code with card element not payment element
    const { paymentIntent, error } = await stripe().confirmCardPayment(
        `${props.paymentIntent.client_secret}`,
        {
            payment_method: {
                card: cardElement(),
                billing_details: {
                    email: user.email,
                }
            }
        },
    );

    if (error) {
        if (error.type === 'card_error') {
            cardError.value = error.message;
        }
    }

    if (paymentIntent) {
        // Redirect to Dashboard
        Inertia.post(route('payments.redirect'));
    }
};

const stripeKey = ref(import.meta.env.VITE_STRIPE_KEY);
const card = ref();
const elms = ref();
const instanceOptions = ref({
    // https://stripe.com/docs/js/initializing#init_stripe_js-options
})
const elementsOptions = ref({
    // https://stripe.com/docs/js/elements_object/create#stripe_elements-options

    // To use Payment Element, set the clientSecret and appearance
    // and use type="payment"
    //clientSecret: props.paymentIntent.client_secret,

    // https://stripe.com/docs/elements/appearance-api
    // appearance: {
    //     theme: 'stripe',
    // },
})
const cardOptions = ref({
    // https://stripe.com/docs/stripe.js#element-options
    style: {
      base: {
        color: "#32325d",
        fontFamily: 'Arial, sans-serif',
        fontSmoothing: "antialiased",
        fontSize: "24px",
        "::placeholder": {
          color: "#32325d"
        }
      },
      invalid: {
        fontFamily: 'Arial, sans-serif',
        color: "#fa755a",
        iconColor: "#fa755a"
      }
    },
    clientSecret: stripeKey,
});
const cardError = ref();
</script>
