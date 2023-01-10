<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { nextTick, ref, defineEmits, watch } from 'vue';

const props = defineProps({
    department:{
        type: Object,
        pageTitle: String,
        // default: {name: null},
    },
    isShowModal: {
        type: Boolean,
        default: false,
    }
})
const emit = defineEmits(['closeModal']);
const closeModal = () => {
    emit('closeModal', false);   
};


const saveDepartment = () => {
    const form = useForm({ name: props.department.name });
    form.put(route('department.update', {department:props.department.id}), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => {},
        onFinish: () => {},
    })
    alert(props.department.name);
};


</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" >
            <form @submit.prevent="saveDepartment()" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Cập nhật phòng ban
                    </h5>
                </div>
                <div>
                    <InputLabel for="name" value="Tên Phòng ban (bắt buộc)" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="department.name" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Mô tả" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" v-model="department.description" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Type" />
                    <TextInput id="name" type="number" class="mt-1 block w-full" v-model="department.type" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>

                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                    <PrimaryButton class="ml-3">Lưu lại</PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
