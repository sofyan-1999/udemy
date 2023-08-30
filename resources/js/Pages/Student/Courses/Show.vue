<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import {Link, router} from '@inertiajs/vue3';
import {toast} from "vue3-toastify";

const props = defineProps({
    course: Object
});

function joinCourse() {
    router.get(route("student.courses.join", props.course.id), {
        onFinish: () => {
            console.log('here');
            toast.success("Joined course successfully!", {position: toast.POSITION.BOTTOM_RIGHT,});
        },
    });
}
</script>
<template>
    <AppLayout title="Course">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Courses
            </h2>
        </template>
        <div class="container mt-2 mx-auto px-4">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <img :src="course.image" :alt="course.title" class="rounded">

                <h1 class="font-semibold text-xl text-black-800 mt-4 mb-2 ml-3">
                    {{ course.title }}
                </h1>
                <Link class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mt-4 ml-3" @click="joinCourse">Join course</Link>
                <p class="mt-4 w-1/2 ml-3 mb-2">{{ course.description }}</p>
            </div>
        </div>
    </AppLayout>
</template>

