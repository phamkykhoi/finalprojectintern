<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import FileManagerOfTask from '@/Components/FileManagerOfTask.vue';
import { reactive, ref, defineEmits, inject, unref  } from 'vue';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import request from '../../utils/request';
import { ClickOutside as vClickOutside } from 'element-plus'
import { ElMessageBox } from 'element-plus'
import {
Document, EditPen,
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
console.log(props.activity)
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

const showInputTask = ref(false)

function ShowInputTask(){
    showInputTask.value = true
}

function CloseInputTask(){
    showInputTask.value = false
}

const showTask = ref(false)

function ShowTaskName(){
    showTask.value = true
}

function CloseTaskName(){
    showTask.value = false
}

const showAddTask = ref(false)

function createFormAddTask(){
    showAddTask.value = true
}

function closeAddTask(){
    showAddTask.value = false
}

const showEditCmt = ref(false)

function handleEditCmt(){
    showEditCmt.value = true
}

function closeEditCmt() {
    showEditCmt.value = false
}

const buttonRef = ref()
const popoverRef = ref()
const onClickOutside = () => {
    unref(popoverRef).popperRef?.delayHide?.()
}
const hidePopover = () => {
    isPopoverVisible.value = !isPopoverVisible.value;
    popoverRef.value.hide()
}


const buttonRef2 = ref()
const popoverRef2 = ref()
const onClickOutside2 = () => {
  unref(popoverRef2).popperRef2?.delayHide?.()
}
const hidePopover2 = () => {
    popoverRef2.value.hide()
}

const buttonRef3 = ref()
const popoverRef3 = ref()
const onClickOutside3 = () => {
  unref(popoverRef3).popperRef3?.delayHide?.()
}
const hidePopover3 = () => {
    popoverRef3.value.hide()
}

const buttonRef4 = ref()
const popoverRef4 = ref()
const onClickOutside4 = () => {
  unref(popoverRef4).popperRef4?.delayHide?.()
}
const hidePopover4 = () => {
    popoverRef4.value.hide()
}

const buttonRef5 = ref()
const popoverRef5 = ref()
const onClickOutside5 = () => {
  unref(popoverRef5).popperRef5?.delayHide?.()
}
const hidePopover5 = () => {
    popoverRef5.value.hide()
}

const buttonRef6 = ref()
const popoverRef6 = ref()
const onClickOutside6 = () => {
  unref(popoverRef6).popperRef6?.delayHide?.()
}
const hidePopover6 = () => {
    popoverRef6.value.hide()
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
const checked1 = ref(false)
const value = ref()

const isPopoverVisible = ref(false)
function showNguoiThucHien(){
    isPopoverVisible.value = !isPopoverVisible.value;
    popoverRef.value.show();
}

const dialogVisible = ref(false)

const handleClose = (done: () => void) => {
  ElMessageBox.confirm('Are you sure to close this dialog?')
    .then(() => {
      done()
    })
    .catch(() => {
      // catch error
    })
}
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
                        <el-row class="mb-2" style="display: block; margin-top: 16px; margin-right: 8px;">
                            <el-row class="task-child">
                                    <div class="flex list-task">
                                        <el-icon style="padding-left: 0px;" :size="25"><List /></el-icon>
                                        <el-form-item style="margin-bottom: 0; margin-left: 6px;" label="Danh sách việc con: (1/2)"></el-form-item>
                                    </div>
                                    <el-button @click="createFormAddTask">Tạo việc con</el-button>
                            </el-row>
                            <div class="task-progress">
                                <el-progress :percentage="0"/>
                            </div>
                            <el-row v-if="showAddTask">
                                    <el-col :span="1" style="text-align: right;">
                                    </el-col>
                                    <el-col :span="23" style="text-align: right;">
                                        <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Tạo mới tên việc"
                                            clearable style="display: block;" />
                                        <el-input type="textarea" :rows="1" autocomplete="off" placeholder="tạo mới mô tả"
                                            clearable style="display: block; margin-top: 8px;" />
                                            <span class="task-btn">
                                        <el-button color="green" style="margin-right: 8px;">Tạo việc</el-button>
                                        <el-icon @click="closeAddTask" class="task-icon-close close"><CloseBold /></el-icon>
                                    </span>
                                    </el-col>
                            </el-row>
                            <div class="task-option" v-if="!showInputTask">
                                <div>
                                    <el-checkbox v-model="checked1" label="Tên việc 1" size="large"/>
                                    <p @click="ShowInputTask"  class="ml-31" style="font-size: 14px;">Mô tả việc con 1</p>
                                </div>
                                <div class="task-option-icon">
                                    <span>
                                        <el-icon style="margin: 0 2px;" size="20" ref="buttonRef6" v-click-outside="onClickOutside6"><Calendar /></el-icon>
                                        <el-popover
                                            :width="400"
                                            ref="popoverRef6"
                                            :virtual-ref="buttonRef6"
                                            trigger="click"
                                            virtual-triggering
                                            placement="left-start"
                                        >
                                            <div class="form-add-user">
                                                    <p>Ngày thực hiện</p>
                                                    <el-icon class="close" @click="hidePopover6"><CloseBold /></el-icon>
                                            </div>
                                            <el-button color="green" style="margin-right: 8px; width: 100%;">Cập nhật</el-button>


                                        </el-popover>
                                        <el-icon style="margin: 0 2px;" size="20"><CirclePlusFilled /></el-icon>
                                    </span>
                                    <el-icon size="20"><MoreFilled /></el-icon>


                                </div>
                            </div>
                                <el-row v-if="showInputTask">
                                    <el-col :span="1">
                                        <el-checkbox v-model="checked1" size="large" />
                                    </el-col>
                                    <el-col :span="23" style="text-align: right;">
                                        <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Chỉnh sửa tên việc"
                                            clearable style="display: block;" />
                                        <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Chỉnh sửa mô tả"
                                            clearable style="display: block; margin-top: 8px;" />
                                            <span class="task-btn">
                                        <el-button color="green" style="margin-right: 8px;">Cập nhật</el-button>
                                        <el-icon @click="CloseInputTask" class="task-icon-close close"><CloseBold /></el-icon>
                                    </span>
                                    </el-col>
                                </el-row>
                            <div class="task-option">
                                <div>
                                    <el-checkbox v-model="checked2" label="Tên việc 2" size="large"/>
                                    <p class="ml-31" style="font-size: 14px;">Mô tả việc con 2</p>
                                </div>
                                <div class="task-option-icon">
                                    <span>
                                        <el-icon style="margin: 0 2px;" size="20"><Calendar /></el-icon>
                                        <el-icon style="margin: 0 2px;" size="20"><CirclePlusFilled /></el-icon>
                                    </span>
                                    <el-icon size="20" ref="buttonRef5" v-click-outside="onClickOutside5"><MoreFilled /></el-icon>
                                    <el-popover
                                        :width="300"
                                        ref="popoverRef5"
                                        :virtual-ref="buttonRef5"
                                        trigger="click"
                                        virtual-triggering
                                        placement="right-start"
                                    >
                                        <div style="display: flex; align-items: center; justify-content: space-between;">
                                            <p>Chức năng</p>
                                            <el-icon class="close" @click="hidePopover5"><CloseBold /></el-icon>
                                        </div>
                                        <el-button class="activity-icon" size="medium" :icon="EditPen" style="width: 100%; border: none">Cập nhật mô tả</el-button>
                                        <el-button class="activity-icon" size="medium" :icon="DocumentCopy" style="width: 100%; border: none">Sao chép</el-button>
                                        <el-button class="activity-icon" size="medium" :icon="Rank" style="width: 100%; border: none">Di chuyển</el-button>
                                        <el-button class="activity-icon" size="medium" :icon="Bell" style="width: 100%; border: none">Nhắc việc</el-button>
                                        <el-button class="activity-icon" size="medium" :icon="Share" style="width: 100%; border: none">Lấy link chia sẻ</el-button>
                                        <el-button class="activity-icon" size="medium" :icon="CloseBold" style="width: 100%; border: none">Xóa</el-button>
                                    </el-popover>
                                </div>
                            </div>


                        </el-row>
                        <FileManagerOfTask :taskId="task.id"></FileManagerOfTask>
                        <div class="flex comment" style="margin-right: 8px;">
                            <el-icon style="margin-right: 6px;" :size="25"><Comment /></el-icon>
                            <el-form-item label="Bình luận:" style="display: block; width: 100%;">
                                <el-input type="textarea" :rows="2" autocomplete="off" placeholder="Nhập bình luận" clearable
                                style="display: inline-block;" />
                                <el-button class="mt-2" style="margin-left: auto;">Gửi bình luận</el-button>
                            </el-form-item>
                            <el-icon class="comment-icon" :size="25"><Avatar /></el-icon>
                        </div>

                        <div class="flex" style="margin-right: 8px; margin-top: 16px;">
                            <el-icon style="margin-right: 6px;" :size="25"><Avatar /></el-icon>
                            <div style="width: 100%;">
                                <div v-if="!showEditCmt">
                                    <span>Tên tác giả bình luận</span>
                                    <div class="commented">Bình luận của tác giả</div>
                                    <div>
                                        <el-link href="#">Thích</el-link>
                                        <el-link href="#">Trả lời</el-link>
                                        <el-link @click="handleEditCmt">Sửa</el-link>
                                        <el-link href="#">Xóa</el-link>
                                        <el-link href="#">Hôm nay 16:00</el-link>
                                    </div>
                                </div>
                                <el-form-item v-if="showEditCmt" style="display: block; width: 100%;">
                                    <el-input value="Bình luận của tác giả" type="textarea" :rows="2" autocomplete="off" clearable
                                        style="display: inline-block;" />
                                        <div class="flex" style="justify-content: space-between; align-items: center; width: 100%; margin-top: 8px;">
                                            <span>Nhấn Shift + Enter để gửi</span>
                                            <div>
                                                <el-button type="success">Cập nhật</el-button>
                                                <el-icon class="close" style="margin-left: 4px;" @click="closeEditCmt" size="15"><Close></Close></el-icon>
                                            </div>
                                        </div>
                                </el-form-item>


                            </div>
                        </div>

                        <el-row class="mt-4" style="display: block; margin-bottom: 0; margin-right: 8px;">
                            <el-row class="task-child">
                                <div class="flex">
                                    <el-icon :size="25"><Clock /></el-icon>
                                    <el-form-item label="Nhật ký việc:" style="margin-left: 6px;"></el-form-item>
                                </div>
                                <div v-if="!showHistory">
                                    <el-button @click="ShowHistory">Xem chi tiết</el-button>
                                </div>
                                <div v-else="!showHistory">
                                    <el-button @click="CloseHistory">Ẩn chi tiết</el-button>
                                </div>
                            </el-row>
                        </el-row>
                        <el-form-item label="Thành viên đã xem việc này:" style="display: block; margin-left: 31px; width: 100%;">
                            <el-icon v-if="!showHistory" :size="25"><Avatar /></el-icon>
                            <div v-if="showHistory" style="width: 100%;">
                                <div class="flex" style="padding: 4px 0;">
                                    <el-icon :size="25"><Avatar /></el-icon>
                                    <p>Nguyễn Văn A đã sửa ... </p>
                                </div>
                                <div class="flex" style="padding: 4px 0;">
                                    <el-icon :size="25"><Avatar /></el-icon>
                                    <p>Nguyễn Văn B đã sửa ... </p>
                                </div>
                                <div style="text-align: center;">
                                    <el-link href="#">Xem thêm</el-link>
                                </div>
                            </div>
                        </el-form-item>


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



                        <div>Người thực hiện:</div>
                        <div class="people-handle" style="display: flex;">
                            <div class="people-icon">
                                <el-icon size="25" class="people-icon-avatar">
                                    <Avatar />
                                </el-icon>
                                <el-icon size="15" class="people-icon-remove close" >
                                    <CircleCloseFilled />
                                </el-icon>
                            </div>

                            <el-icon size="25" class="icon-plus" @click="showNguoiThucHien" ref="buttonRef" v-click-outside="onClickOutside">
                                <CirclePlusFilled />
                            </el-icon>
                            <el-popover
                                :width="400"
                                ref="popoverRef"
                                :virtual-ref="buttonRef"
                                :trigger="'click'"
                                virtual-triggering
                                :visible="isPopoverVisible"
                            >
                                <div class="form-add-user">
                                        <p>Chọn người thực hiện</p>
                                        <el-icon class="close" @click="hidePopover"><CloseBold /></el-icon>
                                </div>
                                    <el-input
                                    v-model="input3"
                                    placeholder="Please Input"
                                    :suffix-icon="Search"
                                    />
                                    <p style="margin-top: 16px;">THÀNH VIÊN TRONG KẾ HOẠCH</p>
                                    <div class="info">
                                        <div class="info-user">
                                            <el-icon :size="25"><Avatar /></el-icon>
                                            <div>
                                                <p class="info-user-item">User.email</p>
                                                <p class="info-user-item">User.name</p>
                                            </div>
                                        </div>
                                        <el-icon color="green" class="icon-circle-check" size="25"><CircleCheck /></el-icon>
                                    </div>

                                    <el-button ref="buttonRef3" v-click-outside="onClickOutside3" class="btn-add-user" :icon="Search">Thêm từ team</el-button>
                                        <el-popover
                                            :width="400"
                                            ref="popoverRef3"
                                            :virtual-ref="buttonRef3"
                                            trigger="click"
                                            virtual-triggering
                                            placement="right-start"
                                        >
                                        <div>
                                            <div class="form-add-user">
                                                    <p>Mời thành viên</p>
                                                    <el-icon class="close" @click="hidePopover3"><CloseBold /></el-icon>
                                            </div>
                                                <el-input
                                                v-model="input3"
                                                placeholder="Please Input"
                                                :suffix-icon="Search"
                                                />
                                                <div class="flex user-team">
                                                    <p>THÀNH VIÊN TEAM</p>
                                                    <span>
                                                        <el-button size="small">Bỏ chọn tất cả</el-button>
                                                        <el-button size="small" color="green">Chọn tất cả</el-button>
                                                    </span>
                                                </div>
                                                <div class="user-add">
                                                    <img
                                                        src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg"
                                                        class="image"
                                                    />
                                                    <div>
                                                        <el-checkbox v-model="checked1" label="Cho phép theo dõi công việc đã có?" size="large" />
                                                        <el-button color="green" class="btn-add-user">Cập nhật</el-button>
                                                    </div>
                                                </div>
                                                <span style="color:red;">* Nếu thành viên chưa có trong Team, vui lòng vào Quản lý thành viên kế hoạch hoặc Quản lý thành viên team mời vào trước</span>
                                        </div>
                                        </el-popover>
                            </el-popover>
                        </div>

                        <div>Người theo dõi (1):</div>
                        <div class="people-handle" style="display: flex;">
                            <div class="people-icon">
                                <el-icon size="25" class="people-icon-avatar" ref="buttonRef4" v-click-outside="onClickOutside4">
                                    <Avatar />
                                </el-icon>

                                    <el-popover
                                        :width="250"
                                        ref="popoverRef4"
                                        :virtual-ref="buttonRef4"
                                        trigger="click"
                                        virtual-triggering
                                    >
                                        <div class="info-user info-user-close">

                                            <img
                                            src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg"
                                            class="image"
                                            />
                                            <div>
                                                <p class="info-user-item">User.email</p>
                                                <p class="info-user-item">User.name</p>
                                            </div>
                                            <el-icon class="user-icon-close close" @click="hidePopover4"><CloseBold /></el-icon>

                                        </div>

                                    </el-popover>
                                <el-icon size="15" class="people-icon-remove close">
                                    <CircleCloseFilled />
                                </el-icon>
                            </div>

                            <el-icon size="25" class="icon-plus" ref="buttonRef2" v-click-outside="onClickOutside2">
                                <CirclePlusFilled />
                            </el-icon>
                            <el-popover
                                :width="400"
                                ref="popoverRef2"
                                :virtual-ref="buttonRef2"
                                trigger="click"
                                virtual-triggering
                            >
                                <div class="form-add-user">
                                        <p>Chọn người theo dõi</p>
                                        <el-icon class="close" @click="hidePopover2"><CloseBold /></el-icon>
                                </div>
                                    <el-input
                                    v-model="input3"
                                    placeholder="Please Input"
                                    :suffix-icon="Search"
                                    />
                                    <div class="flex" style="margin-top: 16px; align-items: center; justify-content: space-between;">
                                        <p>THÀNH VIÊN TRONG KẾ HOẠCH</p>
                                        <el-checkbox v-model="checked1" label="Chọn tất cả" size="large" />
                                    </div>
                                    <div class="info">
                                        <div class="info-user">
                                            <div class="info-user-icon">
                                                <el-icon class="user-icon-avatar" :size="25"><Avatar /></el-icon>
                                                <el-icon class="user-icon-star" :size="18" color="blue"><StarFilled /></el-icon>
                                            </div>
                                            <div>
                                                <p class="info-user-item">User.email</p>
                                                <p class="info-user-item">User.name</p>
                                            </div>
                                        </div>
                                        <el-icon color="orange" class="icon-circle-check" size="25"><CircleCheck /></el-icon>
                                    </div>
                                    <el-button color="green" class="btn-add-user">Cập nhật</el-button>
                                    <el-button style="margin: 6px 0px;" class="btn-add-user" :icon="Search">Thêm từ team</el-button>

                            </el-popover>
                        </div>
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
.btn-add-user{
    width: 100%;
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

.info{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 3px;
}
.info-user{
    display: flex;
    align-items: center;
}
.info-user-item{
    margin-left: 6px;
}
.people-icon:hover,
.icon-plus {
    cursor: pointer;
}
.people-icon{
    position: relative;
}
.people-icon:hover .people-icon-remove{
    display: block;
    left: 50%;
    bottom: 70%;
}
.people-icon-remove{
    display: none;
    position: absolute;
    color: red;
}
.info-user-icon{
    position: relative;
}
.user-icon-star{
    position: absolute;
    left: 50%;
    bottom: 18%;
}
.user-team{
    margin-top: 16px;
    align-items: center;
    justify-content: space-between;
}
.user-add{
    display: flex;
    margin: 16px 0;
}
.user-add img{
    border-radius: 50%;
    margin-right: 8px;
}
.info-user-close{
    position: relative;
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
