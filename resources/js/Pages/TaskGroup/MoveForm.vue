<script lang="ts" setup>
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import {ref, defineEmits, reactive, onBeforeMount } from 'vue';
import type { FormInstance } from 'element-plus'
import axios from 'axios';
import { ElMessage } from 'element-plus'
const confirmingMoveTaskGroupDeletion = ref(false);
const ruleFormRef = ref<FormInstance>()
const emit = defineEmits(['closeModal', 'unClose'])
const props = defineProps({
    activityId: {
        type: Number,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
    getTaskGroups:{
        type:Function,
    },
    taskGroups:{
        type:Object,
        default: null,
    },
    moveTaskGroupId:{
        type:Number,
    }
})
const moveTaskGroupForm = reactive({
    swapTaskGroupId: '',
    moveTaskGroupId: props.moveTaskGroupId,
})

const taskGroupsList=[];
confirmingMoveTaskGroupDeletion.value = props.isShowModal;
const moveTaskGroup = (formEl: FormInstance | undefined) => {
    if (!formEl) return
    formEl.validate((valid) => {
    if (valid) {
            axios.post('/taskgroup/move', moveTaskGroupForm).then(res => {
                if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Move taskgroup successfully',
                        type: 'success',
                    })
                    closeModal();
                }
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
            props.getTaskGroups(props.activityId);
        }
  })
};

const closeModal = () => {
    confirmingMoveTaskGroupDeletion.value = false;
    moveTaskGroupForm.swapTaskGroupId=""
    emit('closeModal', false);
};

const rules = reactive({
    swapTaskGroupId: [{required: true, message: 'Bắt buộc chọn', trigger: 'blur' }],
})

const loadTaskGroupsList=()=>{
    for(let i=0; i<props.taskGroups.length; i++){
        if(props.moveTaskGroupId!=props.taskGroups[i].id){
            taskGroupsList.push({'value':props.taskGroups[i].id, 'label':i+1});
            taskGroupsList.reverse();
        }
    }
}
loadTaskGroupsList();
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal">
            <form @submit.prevent="moveTaskGroup(ruleFormRef)" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Move TaskGroup
                    </h5>
                </div>
                <div class="modal-body relative p-4">
                    <el-form ref="ruleFormRef" :model="moveTaskGroupForm" status-icon :rules="rules" class="demo-ruleForm">
                    <el-form-item prop="swapTaskGroupId" class="d-flex">
                      <InputLabel for="swapTaskGroupId" value="Choose where you want to move this taskgroup:" />
                      <el-select v-model="moveTaskGroupForm.swapTaskGroupId" class="m-2" placeholder="Select" size="large">
                        <el-option
                        v-for="item in taskGroupsList"
                        :key="item.label"
                        :value="item.value"
                        :label="item.label"
                        />
                    </el-select>
                    </el-form-item>
                    </el-form>
                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                    <PrimaryButton class="ml-3">Lưu lại</PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
