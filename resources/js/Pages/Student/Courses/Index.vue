<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Pagination from '@/Shared/Pagination.vue';
import { Link } from '@inertiajs/vue3';
import Search from '@/Shared/Search.vue';

defineProps({
    courses: Object
})
</script>

<template>
    <AppLayout title="Courses">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Courses
            </h2>
        </template>
        <div class="container mt-2 mx-auto px-4">
            <div class="flex justify-between pb-4">
                <Search />
            </div>
            <div class="flex flex-wrap">
                <Link
                    class="max-w-sm rounded overflow-hidden shadow-lg mx-2 my-2"
                    v-for="course in courses.data"
                    :key="course.id"
                    :href="route('student.courses.show', course.id)"
                >
                    <img class="w-full" :src="course.image" :alt="course.title">
                    <div class="px-6 py-4">
                        <div class="font-bold text-xl mb-2">{{ course.title }}</div>
                        <p class="text-gray-700 text-base">
                            <label v-if="course.description.length < 100">{{ course.description }}</label>
                            <label v-else>{{ course.description.substring(0, 100) }}...</label>
                        </p>
                    </div>
                </Link>
            </div>
            <pagination :links="courses.links"/>
        </div>
    </AppLayout>
</template>
