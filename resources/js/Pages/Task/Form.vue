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
    }
})
const ValidateForm = reactive({
  name: '',
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
            <form @submit.prevent="saveTask()" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Tạo công việc
                    </h5>
                </div>
                <div class="modal-body relative p-4">
                        <div>
                            <el-form
                                ref="formRef"
                                :model="ValidateForm"
                                label-width="100px"
                                class="demo-ruleForm"
    >
                                <el-form-item
                                    label="Tên công việc"
                                    prop="name"
                                    :rules="[
                                        { required: true, message: 'name is required' },
                                    ]"
                                    >
                                    <el-input
                                        v-model="ValidateForm.name"
                                        type="text"
                                        autocomplete="off"
                                    />
                                </el-form-item>
                            </el-form>
                        </div>

                        <div>
                            <InputLabel for="description" value="Mô tả công việc" />
                            <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description" />
                            <InputError class="mt-2" :message="form.errors.description" />
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

<style scoped>
.el-form-item{
    display: flex;
    flex-direction: column;
}
</style>
