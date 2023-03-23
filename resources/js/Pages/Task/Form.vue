<script lang="ts" setup>
import Modal from "@/Components/Modal.vue";
import {
    reactive,
    ref,
    defineEmits,
    onBeforeMount,
} from "vue";
import type { FormInstance, FormRules } from "element-plus";
import { ElMessage } from "element-plus";
import FileUpload from "@/Components/FileUpload.vue";
import axios from "axios";
import request from "../../utils/request";

const ruleFormRef = ref<FormInstance>();

const confirmingTaskDeletion = ref(false);
const today = new Date();
const todayTime = new Date(today.getFullYear(), today.getMonth(), today.getDate()).getTime();
const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
    getGroupsTask: {
        type: Function,
    },
});

const taskForm = reactive({
    name: '',
    description: '',
    task_group_id: props.task.id,
    is_quickly: 0,
    is_important: 0,
    user_id: '',
    role_id: '',
    start_date: '',
    end_date: '',
});

const roles = ref([
    { id: 1, role: "Admin" },
    { id: 2, role: "Giám sát department" },
    { id: 3, role: "Giám sát activity" },
    { id: 4, role: "Người phối hợp" },
    { id: 5, role: "Người theo dõi" },
    { id: 6, role: "Chủ task" },
]);

const listAttachments = [];

const emit = defineEmits(['closeModal', 'unClose']);

confirmingTaskDeletion.value = props.isShowModal;

const closeModal = () => {
    confirmingTaskDeletion.value = false;
    emit("closeModal", false);
};

const checkStartDate = (rule: any, value: any, callback: any) => {
    if(new Date(value).getTime()< todayTime && new Date(value).getTime()!=0) {
        callback(new Error("You cannot choose a date in the past"))
        return
    }

    if(new Date(value).getTime()> new Date(taskForm.end_date).getTime()){
            callback(new Error("You cannot choose the start date greater than the end date"))
            return
    }

    callback();
};

const checkEndDate = (rule: any, value: any, callback: any) => {
    if(new Date(value).getTime()< todayTime && new Date(value).getTime()!=0) {
        callback(new Error("You cannot choose a date in the past"))
    return
    }

    if(new Date(value).getTime()< new Date(taskForm.start_date).getTime()){
        callback(new Error("You cannot choose the end date less than the start date"))
        return;
    }
    callback();
};

const checkRoleID = (rule: any, value: any, callback: any) => {
    if(taskForm.user_id && !value){
        callback(new Error("You must choose role for the user"))
        return;
    }   
    callback();
};

const rules = {
    name: [{ required: true, message: "name is required" }],
    role_id: [{ validator: checkRoleID, trigger: "blur" }],
    start_date: [{ validator: checkStartDate, trigger: "blur" }],
    end_date: [{ validator: checkEndDate, trigger: "blur" }],
};

const updateAttachableInfor = (task)=>{
    request.post(`/update_attachments`,{
        task : task,
        listAttachments:listAttachments,
        }
            ).then((res) => {
            console.log(res.data.status);
            });
}
const addTask = (formEl: FormInstance | undefined) => {
    if (!formEl) return;
    formEl.validate((valid) => {
        if (valid) {
            request.post('/task', taskForm).then((res) => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: "Thêm task thành công",
                        type: "success",
                    });
                    updateAttachableInfor(res.data.result.task);
                    closeModal();
                    props.getGroupsTask();
                }
            });
        }
    });
};

const users = ref([]);

const handleLoadData = (data)=>{
    listAttachments.push(data.attachment.id);
}

onBeforeMount(async () => {
    await axios.get(`/user/list`).then((res) => {
        users.value = res.data.users;
    });
});
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal" v-bind:max-width="'3xl'">
            <form class="space-y-6 m-3">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md"
                >
                    <h5
                        class="text-xl font-medium leading-normal text-gray-800"
                        id="exampleModalScrollableLabel"
                    >
                        Tạo công việc
                    </h5>
                </div>

                <div class="modal-body relative p-4">
                    <el-form
                        enctype="multipart/form-data"
                        ref="ruleFormRef"
                        :model="taskForm"
                        label-width="110px"
                        class="demo-ruleForm"
                        :rules="rules"
                    >
                        <el-form-item label="Tên công việc" prop="name">
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
                            <FileUpload @data="handleLoadData" :show-file-list = "true"></FileUpload>
                        </el-form-item>
                        <el-row>
                            <el-col :span="12">
                                <el-form-item prop="user_id">
                                    <span style="font-size: 14px"
                                        >Người thực hiện</span
                                    >
                                    <el-select
                                        v-model="taskForm.user_id"
                                        placeholder="Thành viên"
                                    >
                                        <el-option
                                            v-for="user in users"
                                            :key="user.id"
                                            :label="user.name"
                                            :value="user.id"
                                        />
                                    </el-select>
                                </el-form-item>
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="role_id">
                                    <span style="font-size: 14px"
                                        >Quyền hạn</span
                                    >
                                    <el-select
                                        v-model="taskForm.role_id"
                                        placeholder="Quyền hạn"
                                    >
                                        <el-option
                                            v-for="role in roles"
                                            :key="role.id"
                                            :label="role.role"
                                            :value="role.id"
                                        />
                                    </el-select>
                                </el-form-item>
                            </el-col>
                        </el-row>

                        <el-row>
                            <el-col :span="12">
                                <el-form-item prop="start_date">
                                    <span style="font-size: 14px"
                                        >Ngày bắt đầu</span
                                    >
                                    <el-date-picker
                                        v-model="taskForm.start_date"
                                        type="date"
                                        placeholder="Chọn"
                                        format="YYYY/MM/DD"
                                        clearable
                                        value-format="YYYY-MM-DD"
                                        class="date-picker"
                                        style="
                                            display: block;
                                            width: 100%;
                                            margin: 0;
                                        "
                                    />
                                </el-form-item>

                                <el-checkbox
                                    v-model="taskForm.is_important"
                                    label="Xác định là khẩn cấp"
                                />
                                <el-checkbox
                                    v-model="taskForm.is_quickly"
                                    label="Xác định là quan trọng"
                                />
                                <el-checkbox
                                    label="Đánh dấu tập huấn hội nghị"
                                />
                                <el-checkbox label="Cập nhật vào kế hoạch" />
                            </el-col>
                            <el-col :span="12">
                                <el-form-item prop="end_date">
                                    <span style="font-size: 14px"
                                        >Ngày kết thúc</span
                                    >
                                    <el-date-picker
                                        v-model="taskForm.end_date"
                                        type="date"
                                        placeholder="Chọn"
                                        format="YYYY/MM/DD"
                                        clearable
                                        value-format="YYYY-MM-DD"
                                        style="display: block; width: 100%"
                                    />
                                </el-form-item>
                            </el-col>
                        </el-row>
                    </el-form>
                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md"
                >
                    <div>
                        <el-button type="danger" @click="closeModal" class="mr-4">
                            Đóng
                        </el-button>
                        <el-button type="success" @click="addTask(ruleFormRef)">
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
.el-select {
    width: 100%;
}
::v-deep .el-input__wrapper {
    width: 100%;
}
::v-deep .el-form-item__content {
    margin-left: 0px !important;
}
</style>
