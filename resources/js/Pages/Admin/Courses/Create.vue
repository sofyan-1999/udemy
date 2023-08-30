<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {useForm} from "@inertiajs/vue3";
import {toast} from "vue3-toastify";

const form = useForm({
    title: null,
    description: null,
    image: null,
});

const submit = () => {
    form.post(route('admin.courses.store'), {
        forceFormData: true,
        onSuccess: () => {
            toast.success("Courses successfully created!", {position: toast.POSITION.BOTTOM_RIGHT,});
        },
    });
};
</script>

<template>
    <AppLayout title="Courses">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Courses
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <form class="px-8 pt-6 pb-8" @submit.prevent="submit">
                        <div class="mb-4">
                            <InputLabel for="title" value="Title" />
                            <TextInput
                                id="title"
                                v-model="form.title"
                                type="text"
                                class="mt-1 block w-full"
                                required
                            />
                            <InputError class="mt-2" :message="form.errors.title" />
                        </div>
                        <div class="mb-6">
                            <InputLabel for="description" value="Desciption" />
                            <textarea
                                id="description"
                                v-model="form.description"
                                class="mt-1 block w-full rounded-md"
                                required
                            ></textarea>
                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>
                        <div class="mb-6">
                            <InputLabel for="image" value="Image" />
                            <input id="image" type="file" @input="form.image = $event.target.files[0]" />
                            <InputError class="mt-2" :message="form.errors.image" />
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <PrimaryButton class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create
                            </PrimaryButton>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
