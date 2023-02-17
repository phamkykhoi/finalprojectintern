<script lang="ts" setup>

import Modal from '@/Components/Modal.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3'
import { reactive, ref, defineEmits, onBeforeMount } from 'vue';
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
    user_thuc_hien: '',
    user_giam_sat: '',
    user_phoi_hop: '',
    user_theo_doi: '',
    is_quickly: '',
    is_important: '',
    file: null,
    fileList: [],
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
            <form enctype="multipart/form-data" class="space-y-6 m-3">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Tạo công việc
                    </h5>
                </div>

                <div class="modal-body relative p-4">

                    <el-form
                        ref="ruleFormRef"
                        :model="taskForm"
                        label-width="110px"
                        class="demo-ruleForm"
                        :rules="rules"
                        enctype="multipart/form-data"
                    >
                        <el-form-item
                            label="Tên công việc"
                            prop="name">
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
                                type="textarea"
                                :rows="3"
                                autocomplete="off"
                                clearable
                            />
                        </el-form-item>

                        <el-form-item label="Tệp đính kèm">
                            <el-upload
                                :multiple="true"
                                name="file"
                                v-model:file-list="taskForm.fileList"
                                class="upload-demo"
                                :auto-upload="false">
                                <template #trigger>
                                    <el-button type="primary">Chọn file</el-button>
                                </template>
                            </el-upload>
                        </el-form-item>

                        <el-row :gutter="20">
                            <el-col :span="12">
                                <el-select class="m-2" placeholder="Việc mặc định">
                                    <el-option
                                        v-for="(item, index) in []"
                                        :key="index"
                                        :label="item"
                                        :value="item"/>
                                </el-select>

                                <el-select v-model="taskForm.user_thuc_hien" class="m-2" placeholder="Người thực hiện">
                                    <el-option
                                        v-for="(user, index) in users"
                                        :key="index"
                                        :label="user.name"
                                        :value="user.name"/>
                                </el-select>
                                <el-checkbox label="Xác định là khẩn cấp"  v-model="taskForm.is_quickly"/>
                                <el-checkbox label="Xác định là quan trọng"  v-model="taskForm.is_important"/>
                                <el-checkbox label="Đánh dấu tập huấn hội nghị" />
                                <el-checkbox label="Cập nhật vào kế hoạch" />
                            </el-col>

                            <el-col :span="12">
                                <el-select v-model="taskForm.user_giam_sat" style="width: 100%;" class="m-2" placeholder="Người giám sát (tuỳ chọn)">
                                    <el-option
                                        v-for="(user, index) in users"
                                        :key="index"
                                        :label="user.name"
                                        :value="user.name"/>
                                </el-select>

                                <el-select v-model="taskForm.user_phoi_hop" style="width: 100%;" class="m-2" placeholder="Người phối hợp thực hiện">
                                    <el-option
                                        v-for="(user, index) in users"
                                        :key="index"
                                        :label="user.name"
                                        :value="user.name"/>
                                </el-select>

                                <el-select v-model="taskForm.user_theo_doi" style="width: 100%;" class="m-2" placeholder="Người theo dõi (mặc định tuỳ chọn)">
                                    <el-option
                                        v-for="(user, index) in users"
                                        :key="index"
                                        :label="user.name"
                                        :value="user.name"/>
                                </el-select>
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
.el-form-item{
    display: flex;
    flex-direction: column;
}
</style>
