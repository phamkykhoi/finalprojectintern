<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import { reactive, ref, defineEmits, inject, computed  } from 'vue';
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
    task_group_id: Number,
})

const taskForm = reactive({
    name: props.task.name,
    description: props.task.description,
    task_group_id: props.task_group_id,
    is_quickly: props.task.is_quickly == 0 ? false : true,
    is_important: props.task.is_important == 0 ? false : true,
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
const getGroupsTask = inject('getGroupsTask');

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
                    getGroupsTask();
                   
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
                <el-form enctype="multipart/form-data" ref="ruleFormRef" :model="taskForm" class="demo-ruleForm" :rules="rules">
                <el-row>
                        <el-col :span="18">
                            <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 rounded-t-md">
                                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                    {{ task.name }}
                                </h5>
                            </div>

                            <el-form-item label="Mô tả:" style="display: block;">
                                <el-input v-model="taskForm.description" :value="taskForm.description" type="textarea" :rows="2" autocomplete="off" placeholder="Mô tả công việc" clearable
                                    style="display: inline-block;" />
                            </el-form-item>
                            <el-row class="mb-2" style="display: block;">
                                <el-row>
                                    <el-col :span="18">
                                        <el-form-item label="Danh sách việc con:"></el-form-item>
                                    </el-col>
                                    <el-col :span="2" style="text-align: right;">
                                        <el-button>Tạo việc con</el-button>
                                    </el-col>
                                </el-row>
                                <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Danh sách việc con" clearable
                                    style="display: block;" />
                            </el-row>
                            <el-row class="mb-2">
                                <el-row>
                                    <el-form-item label="Tệp đính kèm:"></el-form-item>
                                    <el-button>Thêm tệp đính kèm</el-button>
                                </el-row>
                                <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Các tệp đính kèm"
                                    style="display: block;" />
                            </el-row>
                            <el-form-item label="Nhật ký việc:" style="display: block;">
                                <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Nhật ký task"
                                style="display: block;" />
                            </el-form-item>
                            <el-form-item label="Thành viên đã xem việc này:" style="display: block;">
                                <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Danh sách thành viên đã xem"
                                style="display: block;" />
                            </el-form-item>
                        </el-col>
                        <el-col :span="5" class="ml-2">
                            <el-checkbox v-model="checked1" label="Hoàn thành việc" size="large" />
                            <el-form-item label="Ngày phải thực hiện:" style="display: block;">
                                <el-input type="text" :rows="1" autocomplete="off" placeholder="Hover: Ngày thực hiện..." />
                            </el-form-item>
                            <div>Người thực hiện: <i class="el-icon-plus"></i></div>
                            <el-button>
                                <i class="el-icon-plus"></i> Thêm mới   
                            </el-button>
                            <el-checkbox v-model="taskForm.is_important" label="Việc khẩn cấp" size="large" />
                            <el-checkbox v-model="taskForm.is_quickly" label="Việc Quan trọng" size="large" />
                            <div class="btn-container">
                                <el-button class="btn-container">Cập nhật vào kế hoạch</el-button>
                                <el-button class="btn-container">Sao chép việc</el-button>
                                <el-button class="btn-container">Di chuyển việc</el-button>
                                <el-button class="btn-container">Tạo nhắc việc</el-button>
                                <el-button class="btn-container">Đánh giá hoàn thành</el-button>
                                <el-button class="btn-container">Khoá việc</el-button>
                                <el-button class="btn-container">Lưu trữ việc</el-button>
                                <el-button class="btn-container">Xoá việc</el-button>
                        </div>
                        </el-col>
                    </el-row>            
                    <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <div>
                        <el-button type="primary" @click="saveTask(ruleFormRef)">
                            Lưu
                        </el-button>
                        <el-button type="primary" @click="closeModal">
                            Đóng
                        </el-button>
                    </div>
                </div>
            </el-form>
        </form>
        </Modal>
</section>
</template>
<style scoped>
.btn-container {
    width: 105%;
    margin: 2px;
  }
</style>