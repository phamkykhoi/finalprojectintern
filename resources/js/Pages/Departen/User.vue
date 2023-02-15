<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, defineEmits, reactive, onMounted, onBeforeMount } from 'vue';
import type { FormInstance } from 'element-plus'
import { ElMessage } from 'element-plus'
import axios from 'axios'

const props = defineProps({
    department: {
        type: Object,
        pageTitle: String,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
});

const roles = ref([
  {id: 1, role: 'Trưởng phòng'},
  {id: 2, role: 'Giám sát'},
  {id: 3, role: 'Thành viên'},
])

const emit = defineEmits(['closeModal']);

const closeModal = () => {
    emit('closeModal', false);
};

const ruleFormRef = ref<FormInstance>()
const userDepartmentForm = reactive({
    user_id: '',
    role_id: '',
    department_id: props.department.id
})

const rules = reactive({
    user_id: [{required: true, message: 'Bắt buộc chọn', trigger: 'blur' }],
    role_id: [{required: true, message: 'Bắt buộc chọn', trigger: 'blur' }],
})

const assignUserToDepartment = (formEl: FormInstance | undefined) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            axios.post('/department/assign-member', userDepartmentForm).then(res => {
                console.log(res.data.status)

                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Thêm thành viên thành công',
                        type: 'success',
                    })
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
        <Modal :show="isShowModal">
            <form class="space-y-6 m-3">
                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Cập nhật thành viên ở deparment  {{ props.department.name }}
                    </h5>
                </div>

                <el-form ref="ruleFormRef" :model="userDepartmentForm" status-icon :rules="rules" class="demo-ruleForm">
                    <div style="display: flex">
                        <div>
                            <el-form-item prop="user_id">
                                <el-select v-model="userDepartmentForm.user_id" class="m-2" placeholder="Thành viên">
                                    <el-option
                                        v-for="user in users"
                                        :key="user.id"
                                        :label="user.name"
                                        :value="user.id"/>
                                </el-select>
                            </el-form-item>
                        </div>
                        <div>
                            <el-form-item prop="role_id">
                                <el-select v-model="userDepartmentForm.role_id" placeholder="Quyền hạn">
                                    <el-option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :label="role.role"
                                        :value="role.id" />
                                    </el-select>
                            </el-form-item>
                        </div>
                        <div style="margin: auto;">
                            <el-button type="primary" @click="assignUserToDepartment(ruleFormRef)">
                                Thêm mới
                            </el-button>
                        </div>
                    </div>
                </el-form>

                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Danh sách thành viên
                    </h5>
                </div>

                <div>
                    <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
                        <el-tab-pane label="Tất cả thành viên" name="first">
                            <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                        <el-tab-pane label="Trưởng phòng" name="second">
                             <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                        <el-tab-pane label="Giám sát" name="third">
                            <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                    </el-tabs>
                </div>
                <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>

<style>
    .demo-tabs > .el-tabs__content {
        padding: 0 20px;
        color: #6b778c;
        font-size: 32px;
        font-weight: 600;
    }
</style>
