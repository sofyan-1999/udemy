<script setup>
import { router } from '@inertiajs/vue3';
import { watch, ref } from "vue";

const url = new URL(document.location);
const searchParam = url.searchParams.get("search");
const search = searchParam ? ref(searchParam) : ref();

watch(search, (searchTerm) => {
    router.reload({
        only: ['courses'],
        data: {
            search: searchTerm,
            page: 1,
        }
    });
})
</script>

<template>
    <div class="w-1/4">
        <label for="table-search" class="sr-only">Search</label>
        <div class="relative mt-1">
            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                <svg
                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        fill-rule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clip-rule="evenodd"
                    ></path>
                </svg>
            </div>
            <input
                type="text"
                v-model="search"
                id="table-search"
                class="block p-2 pl-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-100 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500"
                placeholder="Search for courses"
            >
        </div>
    </div>
</template>
