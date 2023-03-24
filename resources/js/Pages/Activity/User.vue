<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { ref, defineEmits, reactive, onBeforeMount } from 'vue';
import type { FormInstance } from 'element-plus'
import { ElMessage, ElMessageBox } from 'element-plus'
import axios from 'axios'
import {
ArrowDown, Delete, Edit
}
from '@element-plus/icons-vue';
const props = defineProps({
    activity: {
        type: Object,
        pageTitle: String,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
});

const roles = ref([
  {id: 1, role: 'Chủ Hoạt Động'},
  {id: 2, role: 'Giám sát hoạt động'},
  {id: 3, role: 'Thành viên'},
])

const emit = defineEmits(['closeModal']);

const closeModal = () => {
    emit('closeModal', false);
};

const ruleFormRef = ref<FormInstance>()
const userActivityForm = reactive({
    user_id: '',
    role_id: '',
    activity_id: props.activity.id
})

const rules = reactive({
    user_id: [{required: true, message: 'Bắt buộc chọn', trigger: 'blur' }],
    role_id: [{required: true, message: 'Bắt buộc chọn', trigger: 'blur' }],
})

const assignUserToActivity = (formEl: FormInstance | undefined) => {
    if (!formEl) return

    formEl.validate((valid) => {
        if (valid) {
            axios.post('/activity/assign-member', userActivityForm).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Thêm thành viên thành công',
                        type: 'success',
                    })

                    getMembers()

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
const members = ref([])
const loading = ref(true)

onBeforeMount(async () => {
    await axios.get(`/user/list`).then((res) => {
        users.value = res.data.users
    })

    // Get member by activity ID
    getMembers()
});

async function getMembers()
{
    loading.value = true

    await axios.get(`/activity/${props.activity.id}/members`).then((res) => {
        members.value = res.data.users
        loading.value = false
    })
}

async function assignRole(userId, targetRole) {
    let params = {
        user_id: userId,
        role_id: targetRole,
        activity_id: props.activity.id,
    }

    axios.post('/activity/assign-member', params).then(res => {
        if (res.data.status) {
            ElMessage({
                showClose: true,
                message: 'Thêm thành viên thành công',
                type: 'success',
            })

            getMembers()
        }
    }).catch(err => {
        ElMessage({
            showClose: true,
            message: err.response.data.message,
            type: 'error',
        })
    })
}

async function removeMember(userId)
{
    ElMessageBox.confirm(
        'Bạn chắc chắn muốn xóa thành viên này chứ?',
        'Warning',
        {
            confirmButtonText: 'OK',
            cancelButtonText: 'Cancel',
            type: 'warning',
        }
    )
    .then(() => {
        axios.delete(`/activity/${props.activity.id}/remove/member/${userId}`).then(res => {
            if (res.data.status) {
                ElMessage({
                    showClose: true,
                    message: 'Xoá member thành công',
                    type: 'success',
                })

                getMembers()
            }
        }).catch(err => {
            ElMessage({
                showClose: true,
                message: err.response.data.message,
                type: 'error',
            })
        })
    })
    .catch(() => {
        ElMessage({
            type: 'info',
            message: 'Delete canceled',
        })
    })
}

function getRoleName(role)
{
    if (role == 1) {
        return 'Chủ hoạt động';
    }

    if (role == 2) {
        return 'Giám sát';
    }

    if (role == 3) {
        return 'Thành viên'
    }
}

const state = reactive({
    circleUrl:'https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png',
    sizeList: ['small', '', 'large'] as const,
})
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal">
            <form class="space-y-6 m-3">
                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Cập nhật thành viên Activity
                    </h5>
                </div>

                <el-form ref="ruleFormRef" :model="userActivityForm" status-icon :rules="rules" class="demo-ruleForm">
                    <el-row>
                        <el-col :span="8">
                            <el-form-item prop="user_id">
                                <el-select v-model="userActivityForm.user_id" placeholder="Thành viên">
                                    <el-option
                                        v-for="user in users"
                                        :key="user.id"
                                        :label="user.name"
                                        :value="user.id"/>
                                </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item prop="role_id">
                                <el-select v-model="userActivityForm.role_id" placeholder="Quyền hạn" class="mr-2 ml-2">
                                    <el-option
                                        v-for="role in roles"
                                        :key="role.id"
                                        :label="role.role"
                                        :value="role.id" />
                                    </el-select>
                            </el-form-item>
                        </el-col>
                        <el-col :span="8">
                            <el-button type="primary" @click="assignUserToActivity(ruleFormRef)">
                                Thêm mới
                            </el-button>
                        </el-col>
                    </el-row>
                </el-form>

                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Danh sách thành viên
                    </h5>
                </div>

                <div v-loading="loading" >
                    <el-row>
                        <el-col :span="12" :key="index" v-for="(member, index) in members">
                            <el-card shadow="hover">
                                <el-avatar :size="40" :src="circleUrl" />
                                <el-dropdown>
                                    <span class="el-dropdown-link">
                                        {{ member.name }}
                                        <el-icon class="el-icon--right"></el-icon><br>
                                        <el-tag v-if="member.role_activity === 3">Thành viên</el-tag>
                                        <el-tag type="success" v-if="member.role_activity  === 2">Giám sát</el-tag>
                                        <el-tag type="warning" v-if="member.role_activity  === 1">Chủ hoạt động</el-tag>
                                    </span>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item  @click="assignRole(member.id, 3)" v-if="member.role != 3">Chuyển thành thành viên</el-dropdown-item>
                                            <el-dropdown-item  @click="assignRole(member.id, 2)" v-if="member.role != 2">Chuyển thành giám sát hoạt động</el-dropdown-item>
                                            <el-dropdown-item  @click="assignRole(member.id, 1)" v-if="member.role != 1">Chuyển thành chủ hoạt động</el-dropdown-item>
                                            <el-dropdown-item  @click="removeMember(member.id)">Xóa thành viên</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                            </el-card>
                        </el-col>
                    </el-row>
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

    .el-col {
        padding: 0.25rem;
    }

    .el-dropdown-link {
        padding-left: 8px;
        line-height: 25px;
        width: 240px;
    }

    .el-card {
        white-space: nowrap;
    }
</style>
