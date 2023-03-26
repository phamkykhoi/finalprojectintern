<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import { useForm } from '@inertiajs/inertia-vue3'
import { ref, defineEmits, inject } from 'vue';
import request from '../../utils/request';
import { ElMessage } from 'element-plus';
import type { FormInstance } from 'element-plus';

const ruleFormRef = ref<FormInstance>()

const confirmingUserDeletion = ref(false);

const props = defineProps({
    activity: {
        type: Object,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    }
})
const rules = {
    name: [
        { required: true, message: 'name is required' },
    ],
    description: [
        { required: true, message: 'description is required' },
    ],
}

const emit = defineEmits(['closeModal', 'unClose'])

confirmingUserDeletion.value = props.isShowModal;

const form = useForm({
    name: props.activity.name,
    description: props.activity.description,
});

const getDepartment = inject('getDepartment');
const saveActivity = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
        if (valid) {
            request.put(`/activity/${props.activity.id}`, form).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Sửa activity thành công',
                        type: 'success',
                    })
                    closeModal();
                    getDepartment();
                }
            })
        }
    })
}

const closeModal = () => {
    confirmingUserDeletion.value = false;
    emit('closeModal', false);
    form.reset();
};

</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal">
            <form class="space-y-6">
                <el-form ref="ruleFormRef" :model="form" class="demo-ruleForm" :rules="rules">
                    <div
                        class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                        <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                            Chỉnh sửa activity
                        </h5>
                    </div>
                    <el-form-item label="Tên Activity (bắt buộc)" prop="name">
                        <el-input v-model="form.name" type="text" autocomplete="off" clearable />
                    </el-form-item>
                    <el-form-item label="Mô tả (bắt buộc)" prop="description">
                        <el-input v-model="form.description" type="textarea" autocomplete="off" clearable />
                    </el-form-item>
                </el-form>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <div>
                        <el-button type="danger" @click="closeModal" class="mr-3">
                            Đóng
                        </el-button>
                        <el-button type="success" @click="saveActivity(ruleFormRef)">
                         Lưu lại
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
    padding: 0 12px;
}
::v-deep .el-form-item__label{
    justify-content: flex-start
}
</style>
