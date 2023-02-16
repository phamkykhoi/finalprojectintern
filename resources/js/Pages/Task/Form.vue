<script lang="ts" setup>

import Modal from '@/Components/Modal.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { reactive, nextTick, ref, defineEmits, watch, onBeforeMount } from 'vue';
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
})

const taskForm = reactive({
    name: '',
    description: '',
    task_group_id: props.task.id,
    start_date: '2021-10-29',
})

const value = ref('2021-10-29')

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
}
const addTask = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            axios.post('/task', taskForm).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Thêm task thành công',
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
        <Modal :show="isShowModal" @close="closeModal" v-bind:max-width="'3xl'">
            <form class="space-y-6 m-3">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Tạo công việc
                    </h5>
                </div>

                <div class="modal-body relative p-4">

                    <el-form ref="ruleFormRef" :model="taskForm" label-width="110px" class="demo-ruleForm" :rules="rules">
                        <el-form-item label="Tên công việc" prop="name">
                            <el-input v-model="taskForm.name" type="text" autocomplete="off" clearable />
                        </el-form-item>
                        <el-form-item label="Mô tả công việc" prop="description">
                            <el-input v-model="taskForm.description" type="textarea" :rows="3" autocomplete="off"
                                clearable />
                        </el-form-item>

                        <el-form-item label="Tệp đính kèm">
                            <el-upload ref="uploadRef" class="upload-demo" :auto-upload="false">
                                <template #trigger>
                                    <el-button type="primary">Chọn file</el-button>
                                </template>
                            </el-upload>
                        </el-form-item>

                       <p>Danh sách Users:</p>
                        <el-input v-model="textarea" :rows="2" type="textarea" placeholder="Please input" />
                        <el-row>
                            <el-col :span="12">
                                <el-input class="mb-2 mt-2" placeholder="Chọn ngày bắt đầu" />
                                <el-checkbox label="Xác định là khẩn cấp" />
                                <el-checkbox label="Xác định là quan trọng" />
                                <el-checkbox label="Đánh dấu tập huấn hội nghị" />
                                <el-checkbox label="Cập nhật vào kế hoạch" />
                            </el-col>
                            <el-col :span="12">
                                <el-input class="m-2" placeholder="Chọn ngày kết thúc" />
                            </el-col>
                        </el-row>
                    </el-form>

                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <div>
                        <el-button type="primary" @click="closeModal">
                            Đóng
                        </el-button>
                        <el-button type="primary" @click="addTask(ruleFormRef)">
                            Thêm mới
                        </el-button>
                    </div>
                </div>
            </form>
        </Modal>
</section>
</template>

<style scoped>
.el-form-item {
    display: flex;
    flex-direction: column;
}
</style>
