<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import {reactive, nextTick, ref, defineEmits, watch } from 'vue';

const confirmingTaskDeletion = ref(false);

const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
})

const form = useForm({
    description: '',
    task_id: 1,
});

const emit = defineEmits(['closeModal', 'unClose'])

confirmingTaskDeletion.value = props.isShowModal;

const confirmTaskDeletion = () => {
    confirmingTaskDeletion.value = true;
};

const closeModal = () => {
    confirmingTaskDeletion.value = false;
    emit('closeModal', false);
    form.reset();
};
</script>

<template>
    <section class="space-y-6">
                <Modal :show="isShowModal" @close="closeModal">
                    <slot name="taskForm"/>
                    <div
                        class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                        <PrimaryButton class="ml-3" @click="saveTask">Lưu lại</PrimaryButton>
                    </div>
                </Modal>
            </section>
    

</template>

<style scoped>
.el-form-item{
    display: flex;
    flex-direction: column;
}
</style>
