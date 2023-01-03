
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

const props = defineProps({
    user: Object,
    pageTitle: String,
});

const form = useForm({
    name: props.user ? props.user.name : null,
    email: props.user ? props.user.email : null,
    role: props.user ? props.user.role : null,
    password: null,
});

const saveUser = () => {
    if (!props.user) {
        form.post(route('user.store'), {
            preserveScroll: true,
            onSuccess: () => { },
            onError: () => { },
            onFinish: () => { },
        })
        return;
    }

    form.patch(route('user.update', {user: props.user.id}))
}

</script>

<template>
    <AuthenticatedLayout>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white">
                <header>
                    <h3>{{ pageTitle }}</h3>
                </header>
                
                <form @submit.prevent="saveUser()" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Tên thành viên" />
                        <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                            autofocus />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Email" />
                        <TextInput id="email" type="text" class="mt-1 block w-full" v-model="form.email"
                            autofocus />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div>
                        <InputLabel for="name" value="Mật khẩu" />
                        <TextInput id="password" type="password" class="mt-1 block w-full" v-model="form.password" />

                        <InputError class="mt-2" :message="form.errors.password" />
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