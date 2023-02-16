<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import { reactive, ref, defineEmits } from 'vue';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import axios from 'axios';

const ruleFormRef = ref<FormInstance>()

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
    task_group_id: Number
})

const taskForm = reactive({
    name: props.task.name,
    description: props.task.description,
    task_group_id: props.task_group_id,
})

const emit = defineEmits(['closeModal', 'unClose'])

confirmingTaskDeletion.value = props.isShowModal;

const closeModal = () => {
    confirmingTaskDeletion.value = false;
    emit('closeModal', false);
};

const rules = {
    name: [
        { required: true, message: 'name is required' },
    ],
    description: [
        { required: true, message: 'description is required' },
    ],
}

const saveTask = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            axios.put(`/task/${props.task.id}`, taskForm).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Sửa task thành công',
                        type: 'success',
                    })
                    closeModal()
                }
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
        }
    })
}
</script>

<template>
        <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal">
            <form class="space-y-6 m-3">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Chỉnh sửa công việc
                    </h5>
                </div>
                    
                <div class="modal-body relative p-4">
                    <div>
                    <el-form
                        ref="ruleFormRef"
                        :model="taskForm"
                        label-width="110px"
                        class="demo-ruleForm"
                        :rules="rules"
                    >
                        <el-form-item
                            label="Tên công việc"
                            prop="name"
                            >
                            <el-input
                                v-model="taskForm.name"
                                type="text"
                                autocomplete="off"
                                clearable
                            />
                        </el-form-item>
                        <el-form-item
                            label="Mô tả công việc"
                            prop="description"
                            >
                            <el-input
                                v-model="taskForm.description"
                                type="text"
                                autocomplete="off"
                                clearable
                            />
                        </el-form-item>
                    </el-form>
                    </div>
                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <div>
                            <el-button type="primary" @click="closeModal">
                                Đóng 
                            </el-button>
                            <el-button type="primary" @click="saveTask(ruleFormRef)">
                                Lưu lại
                            </el-button>
                        </div>
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