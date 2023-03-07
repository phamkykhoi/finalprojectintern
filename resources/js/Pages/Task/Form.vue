<script lang="ts" setup>

import Modal from '@/Components/Modal.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { reactive, nextTick, ref, defineEmits, watch, onBeforeMount } from 'vue';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import FileUpload from '@/Components/FileUpload.vue';
import axios from 'axios';
import request from '../../utils/request';
import {
  Check,
  Delete,
  Edit,
  Message,
  Search,
  Star,
} from '@element-plus/icons-vue'


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
    getGroupsTask :{
        type:Function,
    },
})

const taskForm = reactive({
    name: '',
    description: '',
    task_group_id: props.task.id,
    start_date: '2021-10-29',
    end_date: '2021-10-30',
    is_quickly: 0,
    is_important: 0,
    file: null,
    fileList: [],
    user_id: '',
    role_id: ''
})

const roles = ref([
    {id: 1, role: 'Admin'},
    {id: 2, role: 'Giám sát department'},
    {id: 3, role: 'Giám sát activity'},
    {id: 4, role: 'Người phối hợp'},
    {id: 5, role: 'Người theo dõi'},
    {id: 6, role: 'Chủ task'},
])

const uploadRef = ref()

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
    user_id: [
        { required: true, message: 'user_id is required' },
    ],
    role_id: [
        { required: true, message: 'role_id is required' },
    ],
}

const addTask = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            request.post('/task', taskForm).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Thêm task thành công',
                        type: 'success',
                    })
                    closeModal()
                    props.getGroupsTask()
                }
            })
        }
    })
}

const users = ref([])

onBeforeMount(async () => {
    await axios.get(`/user/list`).then((res) => {
        users.value = res.data.users
    })
});
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
                    <el-form enctype="multipart/form-data" ref="ruleFormRef" :model="taskForm" label-width="110px" class="demo-ruleForm" :rules="rules">
                        <el-form-item label="Tên công việc" prop="name">
                            <el-input v-model="taskForm.name" type="text" autocomplete="off" clearable />
                        </el-form-item>
                        <el-form-item label="Mô tả công việc" prop="description">
                            <el-input v-model="taskForm.description" type="textarea" :rows="3" autocomplete="off"
                                clearable />
                        </el-form-item>
                        <el-form-item label="Tệp đính kèm">
                            <FileUpload></FileUpload>
                        </el-form-item>
                        <el-row>
                            <el-col :span="12">
                                <span style="font-size: 14px;">Người thực hiện</span>
                                <el-select v-model="taskForm.user_id" placeholder="Thành viên">
                                    <el-option
                                        v-for="user in users"
                                        :key="user.id"
                                        :label="user.name"
                                        :value="user.id"/>
                                </el-select>
                            </el-col>
                            <el-col :span="12">
                                <span style="font-size: 14px;">Quyền hạn</span>
                                <el-select v-model="taskForm.role_id" placeholder="Quyền hạn">
                                    <el-option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :label="role.role"
                                        :value="role.id" />
                                </el-select>
                            </el-col>
                        </el-row>
                            
                        <el-row>
                            <el-col :span="12">
                                <span style="font-size: 14px;">Ngày bắt đầu</span>
                                <el-date-picker
                                    v-model="taskForm.start_date"
                                    type="date"
                                    placeholder="Chọn"
                                    clearable
                                    style="display: block; width: 100%;"
                                />
                                <el-checkbox v-model="taskForm.is_important" label="Xác định là khẩn cấp" />
                                <el-checkbox v-model="taskForm.is_quickly" label="Xác định là quan trọng" />
                                <el-checkbox label="Đánh dấu tập huấn hội nghị" />
                                <el-checkbox label="Cập nhật vào kế hoạch" />
                            </el-col>
                            <el-col :span="12">
                                <span style="font-size: 14px;">Ngày kết thúc</span>
                                <el-date-picker
                                    v-model="taskForm.end_date"
                                    type="date"
                                    placeholder="Chọn"
                                    clearable
                                    style="display: block; width: 100%;"
                                />
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
.el-select{
    width: 100%;
}
::v-deep .el-input__wrapper{
    width: 100%;
}
</style>
