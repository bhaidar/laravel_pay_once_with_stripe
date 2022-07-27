<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';

const props = defineProps({
    courses: Array,
});

</script>

<template>
    <Head title="Members Area" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Members
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                        <div>
                            <h2 class="font-bold text-2xl text-slate-600 my-4 mt-8">Courses</h2>
                             <ul class="list-disc">
                                <li v-for="course in props.courses" :key="course.name">
                                    <p>{{ course.name }}</p>
                                    <p>{{ course.created_at }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
