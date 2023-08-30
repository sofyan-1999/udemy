<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import {toast} from "vue3-toastify";
import Pagination from '@/Shared/Pagination.vue';
import Sort from "@/Shared/Sort.vue";
import { watch, ref } from "vue";
import Search from "@/Shared/Search.vue";

defineProps({
    courses: Object
})

function destroy(id) {
    if (confirm("Are you sure you want to delete the course?")) {
        router.delete(route("admin.courses.destroy", id), {
            onSuccess: () => {
                toast.success("Courses successfully deleted!", {position: toast.POSITION.BOTTOM_RIGHT,});
            },
        });
    }
}

const url = new URL(document.location);
const searchParam = url.searchParams.get("search");
const search = searchParam ? ref(searchParam) : ref();

watch(search, (searchTerm) => {
    router.reload({
        only: ['courses'],
        data: {
            search: searchTerm,
        }
    });
});

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
                <Search/>
                <div class="w-1/4 flex justify-end">
                    <Link
                        :href="route('admin.courses.create')"
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
                    >
                        Create course
                    </Link>
                </div>
            </div>

            <p v-if="courses.length === 0" class="text-center">
                <b>Geen cursussen</b>
            </p>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mx-auto">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                <Sort label="Id" attribute="id" />
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <Sort label="Title" attribute="title" />
                            </th>
                            <th scope="col" class="px-6 py-3">
                                <Sort label="Description" attribute="description" />
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Image
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="course in courses.data"
                            :key="course.id"
                            class="bg-white border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        >
                            <td class="px-6 py-4">{{ course.id }}</td>
                            <td class="px-6 py-4">{{ course.title }}</td>
                            <td class="px-6 py-4" v-if="course.description.length < 100">{{ course.description }}</td>
                            <td class="px-6 py-4" v-else>{{ course.description.substring(0, 100) }}...</td>
                            <td class="px-6 py-4"><img :src="course.image" :alt="course.title" width="50" height="50"></td>
                            <td class="px-6 py-4">
                                <Link
                                    :href="route('admin.courses.edit', {id: course.id})"
                                    class="mr-2 font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                >
                                    Edit
                                </Link>
                                <Link @click="destroy(course.id)" class="text-red-500 hover:underline">Delete</Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <pagination :links="courses.links"/>
            </div>
        </div>
    </AppLayout>
</template>
