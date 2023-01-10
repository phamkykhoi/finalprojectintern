
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    department: Object,
    pageTitle: String,
});

const form = useForm({
    name: props.department ? props.department.name : null,
    description: props.department ? props.department.description : null,
    type: props.department ? props.department.type : null,
});

const saveDepartment = () => {
    if (!props.department) {
        form.post(route('department.store'), {
            preserveScroll: true,
            onSuccess: () => { },
            onError: () => { },
            onFinish: () => { },
        })
        return;
    }

    form.patch(route('department.update', {department: props.department.id}))
}

</script>

<template>
    <AuthenticatedLayout>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white">
                <header>
                    <h3>{{ pageTitle }}</h3>
                </header>
                
                <form @submit.prevent="saveDepartment()" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Tên Phòng ban" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                            autofocus />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Mô tả phòng ban" />
                        <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description"
                            autofocus />

                        <InputError class="mt-2" :message="form.errors.description" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Type" />
                        <TextInput id="type" type="number" class="mt-1 block w-full" v-model="form.type" />

                        <InputError class="mt-2" :message="form.errors.type" />
                    </div>

                    <div>
                        <SecondaryButton> Đóng</SecondaryButton>
                        <PrimaryButton class="ml-3">Lưu lại</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>