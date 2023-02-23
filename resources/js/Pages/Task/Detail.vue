<script lang="ts" setup>
import Modal from '@/Components/Modal.vue';
import FileUpload from '@/Components/FileUpload.vue';
import { reactive, ref, defineEmits, inject, computed, unref  } from 'vue';
import type { FormInstance } from 'element-plus';
import { ElMessage } from 'element-plus';
import axios from 'axios';
import request from '../../utils/request';
import { ClickOutside as vClickOutside } from 'element-plus'
import { 
ArrowDown, Document, EditPen, 
List, Comment , Avatar, Clock,
Delete, CloseBold, Search, CircleCheck,
CirclePlusFilled, CircleCloseFilled,
StarFilled, Calendar, MoreFilled,
DocumentCopy, Rank, Bell, Share
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
    taskGroup: Object,
    activity: Object,
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
const buttonRef = ref()

const popoverRef = ref()

const onClickOutside = () => {
  unref(popoverRef).popperRef?.delayHide?.()
}

const buttonRef2 = ref()

const popoverRef2 = ref()

const onClickOutside2 = () => {
  unref(popoverRef2).popperRef2?.delayHide?.()
}

const buttonRef3 = ref()

const popoverRef3 = ref()

const onClickOutside3 = () => {
  unref(popoverRef3).popperRef3?.delayHide?.()
}

const buttonRef4 = ref()

const popoverRef4 = ref()

const onClickOutside4 = () => {
  unref(popoverRef4).popperRef4?.delayHide?.()
}

const buttonRef5 = ref()

const popoverRef5 = ref()

const onClickOutside5 = () => {
  unref(popoverRef5).popperRef5?.delayHide?.()
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
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal" v-bind:max-width="'3xl'">
            <form class="space-y-6 m-3">
                <el-form enctype="multipart/form-data" ref="ruleFormRef" :model="taskForm" class="demo-ruleForm" :rules="rules">
                
                <el-row>
                    <el-col :span="18">
                        <div class="demo-image">
                            <div class="block">
                            <el-image style="width: 100px; height: 100px" src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg" />
                            </div>
                        </div>
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
                                        <el-icon @click="CloseTaskName" class="name-icon-close"><CloseBold /></el-icon>
                                    </span>
                                </el-col>
                            </el-row>
                        </el-row>
                        <p class="ml-31" style="display: inline-block;"> {{ props.activity.name }} -> {{taskGroup.name}}</p>
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
                                <el-icon @click="CloseInputDes" class="description-icon-close"><CloseBold /></el-icon>
                            </span>
                        </div>
                        <el-row class="mb-2" style="display: block; margin-top: 16px">
                            <el-row>
                                <el-col :span="18">
                                    <div class="flex list-task">
                                        <el-icon style="padding-left: 0px;" :size="25"><List /></el-icon>
                                        <el-form-item style="margin-bottom: 0; margin-left: 6px;" label="Danh sách việc con: (1/2)"></el-form-item>
                                    </div>
                                </el-col>
                                <el-col :span="2" style="text-align: right;">
                                    <el-button @click="createFormAddTask">Tạo việc con</el-button>
                                </el-col>
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
                                        <el-icon @click="closeAddTask" class="task-icon-close"><CloseBold /></el-icon>
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
                                        <el-icon size="20"><Calendar /></el-icon>
                                        <el-icon size="20"><CirclePlusFilled /></el-icon>
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
                                        <el-icon @click="CloseInputTask" class="task-icon-close"><CloseBold /></el-icon>
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
                                        <el-icon size="20"><Calendar /></el-icon>
                                        <el-icon size="20"><CirclePlusFilled /></el-icon>
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
                                            <el-icon><CloseBold /></el-icon>
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
                        
                        <div>
                            <el-row style="margin: 16px 0;">
                                <el-form-item label="Tệp đính kèm:"></el-form-item>
                                <FileUpload></FileUpload>
                                <el-dropdown>
                                    <el-button class="ml-2 mr-2">
                                        Sắp xếp theo <el-icon class="el-icon--right">
                                            <ArrowDown />
                                        </el-icon>
                                    </el-button>
                                    <template #dropdown>
                                        <el-dropdown-menu>
                                            <el-dropdown-item>Tên tập tin</el-dropdown-item>
                                            <el-dropdown-item>Ngày tạo</el-dropdown-item>
                                            <el-dropdown-item>Loại tập tin</el-dropdown-item>
                                            <el-dropdown-item>Kích thước</el-dropdown-item>
                                        </el-dropdown-menu>
                                    </template>
                                </el-dropdown>
                                <el-checkbox
                                    v-model="checkAll"
                                    :indeterminate="isIndeterminate"
                                    @change="handleCheckAllChange"
                                    >Check all</el-checkbox
                                >
                            </el-row>
                                <div class="option-img flex mt-8 mb-8">
                                    <div class="flex">
                                    <img
                                        src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg"
                                        class="image"
                                    />
                                    <div class="info-img ml-8">
                                        <span class="info-img-item">Tên tệp .jpg</span>
                                        <span class="flex info-img-item">
                                            <h6 style="margin-right: 8px;">Mazir</h6>
                                            <span>  Đã thêm hôm nay 16:00</span>
                                        </span>
                                        <span info-img-item>Bấm để cập nhật mô tả</span>

                                        <div>
                                            <el-link href="#">Bình luận</el-link>
                                            <el-link href="#">Tải về</el-link>
                                            <el-link href="#">Lấy link</el-link>
                                            <el-link href="#">Bỏ ảnh bìa</el-link>
                                            <el-link href="#">Xóa</el-link>
                                        </div>
                                    </div>
                                    </div>
                                    <el-checkbox-group
                                        v-model="checkedFiles"
                                        @change="handlecheckedFilesChange"
                                    >
                                    <el-checkbox label="" size="large" />
                                    </el-checkbox-group>
                                </div>
                            <div v-if="!checkAll" style="display: flex; justify-content: flex-end;">
                                <el-button type="primary">Tải tất cả</el-button>
                                <el-button style="margin-left: 8px;">Chọn tất cả</el-button>
                            </div>
                            <div v-if="checkAll" style="display: flex; justify-content: flex-end;">
                                <el-button type="primary">Tải tất cả</el-button>
                                <el-button type="danger" style="margin-left: 6px;">Xóa tập tin đã chọn</el-button>
                                <el-button style="margin-left: 6px;">Chọn tất cả</el-button>
                                <el-button style="margin-left: 6px;">Bỏ chọn tất cả</el-button>
                            </div>
                            <el-form-item label="Nhật ký việc:" style="display: block;">
                                <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Nhật ký task"
                                style="display: block;" />
                            </el-form-item>
                        </div>
                        <div class="comment">
                            <el-icon class="comment-icon" :size="25"><Comment /></el-icon>
                            <div>
                                <el-form-item label="Bình luận:" style="display: block;">
                                    <el-input class="comment-input" type="textarea" :rows="2" autocomplete="off" placeholder="Nhập bình luận" clearable
                                    style="display: inline-block;" />
                                    <el-button class="mt-2">Gửi bình luận</el-button>
                                </el-form-item>
                            </div>
                            
                        </div>
                            
                        
                        <el-form-item label="Tên tác giả bình luận" style="display: block;">
                            <el-input value="Bình luận của tác giả" type="textarea" :rows="2" disabled autocomplete="off" placeholder="Nhập bình luận" clearable
                                style="display: inline-block;" />
                            <div>
                                <el-link href="#">Thích</el-link>
                                <el-link href="#">Trả lời</el-link>
                                <el-link href="#">Sửa</el-link>
                                <el-link href="#">Xóa</el-link>
                                <el-link href="#">Hôm nay 16:00</el-link>
                            </div>
                        </el-form-item>
                        <el-row class="mt-4" style="display: block; margin-bottom: 0;">
                            <el-row>
                                <el-col :span="18" class="flex">
                                    <el-icon :size="25"><Clock /></el-icon>
                                    <el-form-item label="Nhật ký việc:" style="margin-left: 6px;"></el-form-item>
                                </el-col>
                                <el-col v-if="!showHistory" :span="2" style="text-align: right;">
                                    <el-button @click="ShowHistory">Xem chi tiết</el-button>
                                </el-col>
                                <el-col v-else="!showHistory" :span="2" style="text-align: right;">
                                    <el-button @click="CloseHistory">Ẩn chi tiết</el-button>
                                </el-col>
                            </el-row>
                        </el-row>
                        <el-form-item label="Thành viên đã xem việc này:" style="display: block; margin-left: 31px;">
                            <el-icon v-if="!showHistory" :size="25"><Avatar /></el-icon>
                            <div v-if="showHistory">
                                <div class="flex" style="padding: 4px 0;">
                                    <el-icon :size="25"><Avatar /></el-icon>
                                    <p>Nguyễn Văn A đã sửa ... </p>
                                </div>
                                <div class="flex" style="padding: 4px 0;">
                                    <el-icon :size="25"><Avatar /></el-icon>
                                    <p>Nguyễn Văn B đã sửa ... </p>
                                </div>
                            </div>
                        </el-form-item>
                        
                            
                    </el-col>
                    <el-col :span="5" class="ml-2">
                        <el-checkbox v-model="checked2" label="Hoàn thành việc" size="large" />
                        <span>Ngày thực hiện</span>
                        <el-form-item style="display: block;">
                            <div class="date">
                                <el-icon class="date-icon">
                                <Delete />
                                </el-icon>
                                <span class="date-finish" style="display: inline-block;">31/10 - 31/10
                                </span>
                            </div>
                                
                            
                        </el-form-item>

                      

                        <div>Người thực hiện:</div>
                        <div class="people-handle" style="display: flex;">
                            <div class="people-icon">
                                <el-icon size="25" class="people-icon-avatar">
                                    <Avatar />
                                </el-icon>
                                <el-icon size="15" class="people-icon-remove">
                                    <CircleCloseFilled />
                                </el-icon>
                            </div>
                                
                            <el-icon size="25" class="icon-plus" ref="buttonRef" v-click-outside="onClickOutside">
                                <CirclePlusFilled />
                            </el-icon>
                            <el-popover
                                :width="400"
                                ref="popoverRef"
                                :virtual-ref="buttonRef"
                                trigger="click"
                                virtual-triggering
                            >
                                <div class="form-add-user">
                                        <p>Chọn người thực hiện</p>
                                        <el-icon><CloseBold /></el-icon>
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
                                            <div class="form-add-user">
                                                    <p>Mời thành viên</p>
                                                    <el-icon><CloseBold /></el-icon>
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
                                            <el-icon class="user-icon-close"><CloseBold /></el-icon>
                                            
                                        </div>
                                            
                                    </el-popover>
                                <el-icon size="15" class="people-icon-remove">
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
                                        <el-icon><CloseBold /></el-icon>
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

                        <el-checkbox v-model="taskForm.is_quickly" id="is_quickly" @change="changeQuicklyStatus(task.id)" label="Việc Khẩn cấp" size="large" />
                        <el-checkbox v-model="taskForm.is_important" id="is_important" @change="changeImportantStatus(task.id)" label="Việc Quan trọng" size="large" />
                        <div class="btn-container">
                            <el-button class="btn-container">Cập nhật vào kế hoạch</el-button>

                            <!-- chưa đưa được dropdow vào trong button  -->
                            
                            <el-button class="btn-container">Đính kèm tệp tin
                            </el-button>
                            <el-button class="btn-container">Sao chép việc</el-button>
                            <el-button class="btn-container">Di chuyển việc</el-button>
                            <el-button class="btn-container">Tạo nhắc việc</el-button>
                            <el-button class="btn-container">Đánh giá hoàn thành</el-button>
                            <el-button class="btn-container">Khoá việc</el-button>
                            <el-button class="btn-container">Lưu trữ việc</el-button>
                            <el-button class="btn-container">Xoá việc</el-button>
                        </div>
                    </el-col>
                </el-row>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <div>
                        <el-button type="primary" @click="closeModal">
                            Đóng
                        </el-button>
                    </div>
                </div>
            </el-form>
              
        </form>
       
        </Modal>
    </section>
</template>
<style scoped>

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
    width: 105%;
    margin: 2px 0;
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
    margin: 8px 8px 0;
    font-size: 14px;
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
}
.comment ::v-deep .el-form-item__label{
    margin-left: 26px !important;
}
.comment-input{
    margin-left: 0px;
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
</style>