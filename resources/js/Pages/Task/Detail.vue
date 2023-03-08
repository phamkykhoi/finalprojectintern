<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import TaskCommentSection from '@/Components/TaskCommentSection.vue';
import FileManagerOfTask from '@/Components/FileManagerOfTask.vue';
import Participant from '@/Components/Participant.vue';
import { reactive, ref, defineEmits, inject, unref  } from 'vue';
import SubTask from '@/Pages/Task/SubTask.vue';
import TaskActivity from '@/Pages/Task/TaskActivity.vue';
import FileUpload from '@/Components/FileUpload.vue';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import axios from 'axios';
import request from '../../utils/request';
import { ClickOutside as vClickOutside } from 'element-plus'
import { ElMessageBox } from 'element-plus'
import {
ArrowDown, Document, EditPen,
List, Comment , Avatar, Clock,
Delete, CloseBold, Search, CircleCheck,
CirclePlusFilled, CircleCloseFilled,
StarFilled, Calendar, MoreFilled,
DocumentCopy, Rank, Bell, Share,
Pointer, Finished, Lock, TakeawayBox,
Close, DocumentAdd, Link, ChromeFilled,
Box, Cloudy, Folder, ArrowUpBold
}
from '@element-plus/icons-vue';

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
    activity: {
      type: Object,
      default: () => ({ name: 'activityName' })
    },
    taskGroup: {
      type: Object,
      default: () => ({ name: 'taskGroupName' })
    }
})

const taskForm = reactive({
    name: props.task.name,
    description: props.task.description,
    task_group_id: props.task_group_id,
    is_important: props.task.is_important,
    is_quickly: props.task.is_quickly
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
            request.put(`/task/${props.task.id}`, taskForm).then(res => {
                if (res.data.result.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Sửa task thành công',
                        type: 'success',
                    })
                    closeModal()
                    getGroupsTask();

                }
            })
        }
    })
}

function changeImportantStatus(taskId) {
    request.put(`/task/${taskId}`, {
    is_important: taskForm.is_important,
    change_status_type: 'important',
})
    .then(res => {
        getGroupsTask();
    })
}

function changeQuicklyStatus(taskId) {
    request.put(`/task/${taskId}`, {
        is_quickly: taskForm.is_quickly,
        change_status_type: 'quickly',
})
        .then(res => {
            getGroupsTask();
        })
}
const showHistory = ref(false)

function ShowHistory(){
    showHistory.value = true
}
function CloseHistory(){
    showHistory.value = false
}

const showInputDescription = ref(false)

function ShowInputDes(){
    showInputDescription.value = true
}

function CloseInputDes(){
    showInputDescription.value = false
}

const showTask = ref(false)

function ShowTaskName(){
    showTask.value = true
}

function CloseTaskName(){
    showTask.value = false
}

const showInputEdit = ref(false)

function handleShowEdit() {
    showInputEdit.value = true
}

function closeEdit() {
    showInputEdit.value = false
}

const buttonRef7 = ref()
const popoverRef7 = ref()
const onClickOutside7 = () => {
  unref(popoverRef7).popperRef7?.delayHide?.()
}
const hidePopover7 = () => {
    popoverRef7.value.hide()
}

const buttonRef8 = ref()
const popoverRef8 = ref()
const onClickOutside8 = () => {
  unref(popoverRef8).popperRef8?.delayHide?.()
}
const hidePopover8 = () => {
    popoverRef8.value.hide()
}

const buttonRef9 = ref()
const popoverRef9 = ref()
const onClickOutside9 = () => {
  unref(popoverRef9).popperRef9?.delayHide?.()
}
const hidePopover9 = () => {
    popoverRef9.value.hide()
}

const buttonRef10 = ref()
const popoverRef10 = ref()
const onClickOutside10 = () => {
  unref(popoverRef10).popperRef10?.delayHide?.()
}
const hidePopover10 = () => {
    popoverRef10.value.hide()
}

const checkAll = ref(false)
const isIndeterminate = ref(true)
const checkedFiles = ref([])
const files = ['']
const handleCheckAllChange = (val: boolean) => {
  checkedFiles.value = val ? files : []
  isIndeterminate.value = false
}
const handlecheckedFilesChange = (value: string[]) => {
  const checkedCount = value.length
  checkAll.value = checkedCount === files.length
  isIndeterminate.value = checkedCount > 0 && checkedCount < files.length
}

const checked1 = ref(false)
const value = ref()

</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal" v-bind:max-width="'4xl'">
            <form class="space-y-6 m-3">
                <el-form enctype="multipart/form-data" ref="ruleFormRef" :model="taskForm" class="demo-ruleForm" :rules="rules">
                <el-row>
                    <el-col :span="18">
                        <div v-if="!showTask" class="modal-header flex flex-shrink-0 items-center justify-between rounded-t-md">
                            <h5  class="text-xl font-medium leading-normal text-gray-800 " id="exampleModalScrollableLabel"
                                style="display: flex;">
                                <el-icon class="el-icon" :size="25">
                                    <Document />
                                </el-icon>
                                <strong @click="ShowTaskName" class="ml-6"> {{ task.name }}</strong>
                            </h5>
                        </div>
                        <el-row v-if="showTask" class="mb-2" style="display: block;">
                            <el-row>
                                <el-col :span="1" style="text-align: right; margin-right: 8px;" >
                                    <el-icon class="el-icon" :size="25">
                                        <Document />
                                    </el-icon>
                                </el-col>
                                <el-col :span="22">
                                    <el-input v-model="taskForm.name" :value="taskForm.name"
                                    type="textarea" :rows="2" autocomplete="off" placeholder="Mô tả công việc" clearable style="display: inline-block;" />
                                    <span class="name-btn">
                                        <el-button color="green" style="margin-right: 8px;">Cập nhật</el-button>
                                        <el-icon @click="CloseTaskName" class="name-icon-close close"><CloseBold /></el-icon>
                                    </span>
                                </el-col>
                            </el-row>
                        </el-row>
                        <p v-if="props.activity" class="ml-31" style="display: inline-block;"> {{ props.activity.name }} -> {{taskGroup.name}}</p>
                        <div class="flex description" style="margin: 16px 0;">
                            <el-icon :size="25"><EditPen /></el-icon>
                            <el-form-item label="Mô tả:" style="display: block; margin-bottom: 0; margin-left: 6px; ">
                            </el-form-item>
                        </div>
                        <span class="ml-31" v-if="!showInputDescription" @click="ShowInputDes">{{ taskForm.description }}</span>
                        <div v-if="showInputDescription" style="margin: 16px 0;">
                            <el-input v-model="taskForm.description" :value="taskForm.description"
                            type="textarea" :rows="2" autocomplete="off" placeholder="Mô tả công việc" clearable style="display: inline-block;" />
                            <span class="description-btn">
                                <el-button color="green" style="margin-right: 8px;">Cập nhật</el-button>
                                <el-icon @click="CloseInputDes" class="description-icon-close close"><CloseBold /></el-icon>
                            </span>
                        </div>
                        <el-row class="mb-2" style="display: block; margin-top: 16px;">
                            <SubTask :taskId="task.id"></SubTask>
                        </el-row>

                        <FileManagerOfTask :taskId="task.id"></FileManagerOfTask>
                        <TaskCommentSection :taskId="task.id"></TaskCommentSection>
                        <TaskActivity :taskId="task.id"></TaskActivity>
                    </el-col>
                    <el-col :span="5" class="ml-2">
                        <el-checkbox v-model="checked2" label="Hoàn thành việc" size="large" />
                        <span>Ngày thực hiện</span>
                        <el-form-item style="display: block;">
                            <div class="date">
                                <el-icon color="orange " class="date-icon">
                                <Delete />
                                </el-icon>
                                <span class="date-finish" style="display: inline-block; color: red;">31/10 - 31/10
                                </span>
                            </div>


                        </el-form-item>
                        <Participant :taskId="task.id"></Participant>
                        <div  style="width: 100%;">
                            <p>Đánh giá</p>
                            <div class="flex rate">
                                <el-rate
                                class="rate-item"
                                size="small"
                                v-model="value"
                                :show-score="true"
                                />
                                <span style="display: flex; align-items: center;">
                                    <el-icon style="margin-right: 4px;"><Pointer /></el-icon>
                                    <el-link href="#">0 đã vote</el-link>
                                </span>
                            </div>
                        </div>
                        <el-checkbox v-model="taskForm.is_quickly" id="is_quickly" @change="changeQuicklyStatus(task.id)" label="Việc Khẩn cấp" size="large" />
                        <el-checkbox v-model="taskForm.is_important" id="is_important" @change="changeImportantStatus(task.id)" label="Việc Quan trọng" size="large" />
                        <div class="btn-container">
                            <el-button :icon="DocumentAdd" class="btn-container">Cập nhật vào kế hoạch</el-button>
                            <el-button :icon="Link" class="btn-container" ref="buttonRef7" v-click-outside="onClickOutside7">Đính kèm tệp tin</el-button>
                                <el-popover
                                    :width="300"
                                    ref="popoverRef7"
                                    :virtual-ref="buttonRef7"
                                    trigger="click"
                                    virtual-triggering
                                >
                                    <div class="form-add-user">
                                            <p>Đính kèm từ tập tin</p>
                                            <el-icon class="close" @click="hidePopover7"><CloseBold /></el-icon>
                                    </div>
                                    <div class="btn-container">
                                        <el-button :icon="Folder" text class="btn-container1">Máy tính</el-button>
                                        <el-button :icon="ChromeFilled" text class="btn-container1">Google</el-button>
                                        <el-button :icon="Box" text class="btn-container1">Dropbox</el-button>
                                        <el-button :icon="Cloudy" text class="btn-container1">OneDrive</el-button>
                                    </div>
                                </el-popover>

                            <el-button :icon="DocumentCopy" class="btn-container">Sao chép việc</el-button>
                            <el-button :icon="Rank" class="btn-container">Di chuyển việc</el-button>
                            <el-button :icon="Bell" class="btn-container"  @click="dialogVisible = true">Tạo nhắc việc</el-button>
                                <el-dialog
                                    v-model="dialogVisible"
                                    title="Nhắc việc"
                                    width="60%"
                                    :before-close="handleClose"
                                >
                                <div >
                                    <span>Thời gian bắt đầu nhắc việc</span>
                                    <div>
                                        <p>Chu kỳ nhắc việc</p>
                                        <div style="width: 100%;">
                                            <el-select style="width: 100%; margin-left: -8px;" v-model="value" class="m-2" placeholder="Select">
                                                <el-option
                                                v-for="item in options"
                                                :key="item.value"
                                                :label="item.label"
                                                :value="item.value"
                                                />
                                            </el-select>
                                        </div>
                                    </div>
                                    <div>
                                        <p>Chu kỳ nhắc việc</p>
                                        <div>
                                            <el-checkbox v-model="checked1" label="Option 1" size="large" />
                                        </div>
                                        <div>
                                            <el-checkbox v-model="checked2" label="Option 2" size="large" />
                                        </div>
                                    </div>
                                    <p style="color: green;">Nhắc việc hàng ngày lúc 10:00</p>
                                </div>
                                    <template #footer>
                                        <span class="dialog-footer">
                                            <el-button type="success" @click="dialogVisible = false">
                                                Cài đặt
                                            </el-button>
                                            <el-button @click="dialogVisible = false"  style="margin-left: 8px;">Đóng</el-button>
                                        </span>
                                    </template>
                                </el-dialog>
                            <el-button :icon="Finished" class="btn-container">Đánh giá hoàn thành</el-button>
                            <el-button :icon="Lock" class="btn-container" ref="buttonRef8" v-click-outside="onClickOutside8">Khoá việc</el-button>
                                <el-popover
                                        :width="350"
                                        ref="popoverRef8"
                                        :virtual-ref="buttonRef8"
                                        trigger="click"
                                        virtual-triggering
                                    >
                                        <div class="form-add-user">
                                                <p>Khóa việc</p>
                                                <el-icon class="close" @click="hidePopover8"><CloseBold /></el-icon>
                                        </div>
                                        <p>
                                            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt inventore
                                            nostrum laudantium consequuntur doloremque accusantium autem nam sit culpa
                                            odit eligendi exercitationem provident error, dignissimos pariatur fugit id facere? Quae.
                                        </p>
                                        <el-button style="width: 100%; margin-top: 12px;" type="danger">Xác nhận</el-button>
                                </el-popover>
                            <el-button :icon="TakeawayBox" class="btn-container" ref="buttonRef9" v-click-outside="onClickOutside9">Lưu trữ việc</el-button>
                                <el-popover
                                    :width="350"
                                    ref="popoverRef9"
                                    :virtual-ref="buttonRef9"
                                    trigger="click"
                                    virtual-triggering
                                >
                                    <div class="form-add-user">
                                            <p>Lưu trữ</p>
                                            <el-icon class="close" @click="hidePopover9"><CloseBold /></el-icon>
                                    </div>
                                    <p>
                                        Bạn có chắc là lưu trữ công việc này không?
                                    </p>
                                    <p style="color: red;">
                                        Bạn có thể phục hồi lại khi cần.
                                    </p>
                                    <el-button style="width: 100%; margin-top: 12px;" type="danger">Xác nhận</el-button>
                                </el-popover>
                            <el-button :icon="Close" class="btn-container" ref="buttonRef10" v-click-outside="onClickOutside10">Xoá việc</el-button>
                                <el-popover
                                    :width="350"
                                    ref="popoverRef10"
                                    :virtual-ref="buttonRef10"
                                    trigger="click"
                                    virtual-triggering
                                >
                                    <div class="form-add-user">
                                        <p>Xóa công việc</p>
                                        <el-icon class="close" @click="hidePopover10"><CloseBold /></el-icon>
                                    </div>
                                    <p>
                                        Bạn có chắc là xoá công việc này không?
                                    </p>
                                    <p>
                                        Vui lòng nhập số 0 vào ô bên dưới để xác nhận xóa
                                    </p>
                                    <p style="color: red;">
                                        Nếu xoá bạn sẽ không thể phục hồi lại.
                                    </p>
                                    <el-input v-model="input" placeholder="Please input" />
                                    <el-button style="width: 100%; margin-top: 12px;" type="danger">Xóa</el-button>
                                </el-popover>
                        </div>
                    </el-col>
                </el-row>
            </el-form>
            <el-backtop target="#modal" visibility-height="100" :bottom="30">
                <div
                style="
                    height: 100%;
                    width: 100%;
                    background-color: var(--el-bg-color-overlay);
                    box-shadow: var(--el-box-shadow-lighter);
                    text-align: center;
                    line-height: 40px;
                    color: #1989fa;
                    border-radius: 50%;
                    border: 1px solid green;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                "
                >
                <el-icon color="green"><ArrowUpBold /></el-icon>
                </div>
            </el-backtop>
        </form>
        </Modal>
    </section>
</template>
<style scoped>
.modal-open {
  overflow: hidden;
}
.form-add-user{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.form-add-user,
.info {
    margin-bottom: 16px;
}
.btn-container {
    justify-content: flex-start;
    width: 105%;
    margin: 2px 0;
}
.btn-container1 {
    justify-content: flex-start;
    width: 99%;
}
.demo-image{
    display: flex;
    justify-content: center;
}
.task-progress .el-progress--line {
    margin: 16px 0;
    flex-direction: row-reverse;
}
.task-progress ::v-deep .el-progress__text{
    min-width: 28px;
}
.ml-4 {
    margin-left: 4px;
}
.ml-6 {
    margin-left: 6px;
}
.ml-8 {
    margin-left: 8px;
}
.ml-31 {
    margin-left: 31px;
}
.mt-8{
    margin-top: 8px;
}
.mb-8{
    margin-bottom: 8px;
}
.description{
    align-items: center;
}
.description-btn,
.name-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}
.task-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}
.description-icon-close:hover,
.task-icon-close:hover {
    cursor: pointer;
}
.task-option{
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.task-option span{
    margin-right: 16px;
}
.task-option-icon:hover{
    cursor: pointer;
}
.list-task{
    align-items: center;
}
.option-img{
    align-items: center;
}
.info-img{
    width: 100%;
    font-size: 14px;
}
.option-img:hover{
    background-color: #ccc;
}
.info-edit:hover{
    cursor: pointer;
}
.info-edit-icon{
    display: none;
}
.info-edit:hover .info-edit-icon{
    display: inline-block;
}
.info-img-item{
    padding: 4px 0;
}

.el-link {
  margin-right: 8px;
}
.el-link .el-icon--right.el-icon {
  vertical-align: text-bottom;
}
.image {
    object-fit: cover;
    width: 20%;
    display: block;
}
.comment{
    position: relative;
}
.comment-icon{
    position: absolute;
    left: 0;
    bottom: 50%;
}
.comment-input{
    margin-left: 0px;
}
.commented{
    width: 100%;
    margin-right: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 4px 4px;
}
.el-col{
    padding-left: 0;
}
.date {
    position: relative;
}

.date-icon {
    position: absolute;
    left: 0px;
    bottom: 10px;
    display: none;
}
.date:hover .date-icon{
    cursor: pointer;
    display: block;
}
.date:hover .date-finish{
    margin-left: 16px;
}

.user-icon-close{
    position: absolute;
    top: 0;
    right: 0;
}
.el-button+.el-button{
    margin-left: 0;
}
.activity-icon{
    justify-content: flex-start;
}
.rate ::v-deep .el-link__inner{
    width: 60px;
}
.rate span{
    margin-left: 8px;
}
.rate-item ::v-deep span i{
    margin-right: 0;
}
.task-child{
    justify-content: space-between;
}
.close:hover{
    cursor: pointer;
}
::v-deep .el-dialog__body{
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
}
</style>
