<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { ref, defineEmits, reactive, onMounted, onBeforeMount } from 'vue';
import type { FormInstance } from 'element-plus'
import { ElMessage } from 'element-plus'

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

    // Get member by department ID
    getMembers()
});

async function getMembers()
{
    loading.value = true

    await axios.get(`/department/${props.department.id}/members`).then((res) => {
        members.value = res.data.users
        loading.value = false
    })
}

async function assignRole(userId, targetRole) {
    let params = {
        user_id: userId,
        role_id: targetRole,
        department_id: props.department.id,
    }

    axios.post('/department/assign-member', params).then(res => {
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
    axios.delete(`department/${props.department.id}/remove/member/${userId}`).then(res => {
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
}

function getRoleName(role)
{
    if (role == 1) {
        return 'Trưởng phòng';
    }

    if (role == 2) {
        return 'Giám sát';
    }

    if (role == 3) {
        return 'Thành viên'
    }
}


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

                <div v-loading="loading" >
                    <ul class="members">
                        <li class="member-item" :key="index" v-for="(member, index) in members">
                            {{ member.name }} - {{ member.id }}
                            <p>{{  getRoleName(member.role) }} - {{ member.role }}</p>
                            <ul class="member-actions">
                                <li><a href="#" @click="assignRole(member.id, 3)" v-if="member.role != 3">Chuyển thành thành viên</a></li>
                                <li><a href="#" @click="assignRole(member.id, 2)" v-if="member.role != 2">Chuyển thành giám sát</a></li>
                                <li><a href="#" @click="assignRole(member.id, 1)" v-if="member.role != 1">Chuyển thành trưởng phòng</a></li>
                                <li><a href="#" @click="removeMember(member.id)">Delete</a></li>
                            </ul>
                        </li>
                    </ul>
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

    ul.members {
        display: flex;
        list-style-type: none;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    ul.members > li {
        border: 1px dashed #ccc;
        width: 46%;
        margin-right: 15px;
        padding: 8px;
        margin-bottom: 10px;
        position: relative;
    }

    ul.members > li:hover ul.member-actions {
        display: block;
    }

    ul.member-actions {
        position: absolute;
        width: 250px;
        list-style-type: none;
        background: #f1f1f1;
        border: 1px solid #ccc;
        top: 0px;
        left: 90%;
        display: none;
    }

    ul.member-actions li {
        background: #ccc;
    }

    ul.member-actions li:hover {
        background: orange;
    }
</style>
