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

const confirmingUserDeletion = ref(false);
const nameInput = ref(null);

const props = defineProps({
    activityId: {
        type: Number,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    }
})

const form = useForm({
    name: '',
    activityId: props.activityId,
});

const emit = defineEmits(['closeModal', 'unClose'])

confirmingUserDeletion.value = props.isShowModal;

const confirmUserDeletion = () => {
    confirmingUserDeletion.value = true;
};

const saveTask = () => {
    form.post(route(''), {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => nameInput.value.focus(),
        onFinish: () => form.reset(),
    })
};

const closeModal = () => {
    confirmingUserDeletion.value = false;
    emit('closeModal', false);
    form.reset();
};

</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal">
            <form @submit.prevent="saveTask()" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Thêm nhóm công việc
                    </h5>
                </div>
                <div class="modal-body relative p-4">
                        <div>
                            <InputLabel for="name" value="Tên nhóm công việc (bắt buộc)" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus
                                autocomplete="name" ref="nameInput"/>
                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>
                        <div>
                            <TextInput id="activityId" type="hidden" class="mt-1 block w-full" v-model="form.activityId" disabled />
                            <InputError class="mt-2" :message="form.errors.activityId" />
                        </div>
                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                    <PrimaryButton class="ml-3" @click="saveTask">Lưu lại</PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
/
