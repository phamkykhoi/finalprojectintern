<script lang="ts" setup>
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, defineEmits, reactive } from 'vue';
import type { FormInstance } from 'element-plus'
import axios from 'axios';
import { ElMessage } from 'element-plus'
const confirmingTaskGroupDeletion = ref(false);
const ruleFormRef = ref<FormInstance>()
const emit = defineEmits(['closeModal', 'unClose'])
const props = defineProps({
    activityId: {
        type: Number,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
    getTaskGroups:{
        type:Function,
    },
})
const taskGroupForm = reactive({
    name: '',
    activity_id: props.activityId,
})
confirmingTaskGroupDeletion.value = props.isShowModal;
const saveTaskGroup = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
    if (valid) {
            axios.post('/taskgroup/', taskGroupForm).then(res => {
                    ElMessage({
                        showClose: true,
                        message: 'Add taskgroup successfully',
                        type: 'success',
                    })
                    closeModal();
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
            props.getTaskGroups(props.activityId);
        }
  })
};
const closeModal = () => {
    confirmingTaskGroupDeletion.value = false;
    taskGroupForm.name=""
    emit('closeModal', false);
};
const rules = reactive({
    name: [{required: true, message: 'Bắt buộc nhập', trigger: 'blur' }],
})
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal">
            <form @submit.prevent="saveTaskGroup(ruleFormRef)" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Thêm nhóm công việc
                    </h5>
                </div>
                <div class="modal-body relative p-4">
                    <el-form ref="ruleFormRef" :model="taskGroupForm" status-icon :rules="rules" class="demo-ruleForm">
                    <el-form-item prop="name">
                      <InputLabel for="name" value="Task Group Name:" />
                      <el-input
                      v-model="taskGroupForm.name"
                      type="text"
                      autocomplete="off"
                      />
                    </el-form-item>
                    <el-form-item prop="activityId"  >
                      <el-input
                      v-model="taskGroupForm.activity_id"
                      type="hidden"
                      autocomplete="off"
                      />
                    </el-form-item>

                    </el-form>
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
