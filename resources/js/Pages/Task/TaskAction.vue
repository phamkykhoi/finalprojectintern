<script setup>
import { reactive, ref, defineEmits, inject, unref  } from 'vue';
import {
CloseBold, DocumentCopy, Rank, Bell, Finished, 
Lock, TakeawayBox, Close, DocumentAdd, Link, 
ChromeFilled, Box, Cloudy, Folder,
}from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside } from 'element-plus';
import { ElMessageBox } from 'element-plus';

const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    task_group_id: Number,
})

const taskForm = reactive({
    name: props.task.name,
    description: props.task.description,
    task_group_id: props.task_group_id,
    is_important: props.task.is_important,
    is_quickly: props.task.is_quickly
})

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

const dialogVisible = ref(false)

</script>

<template>
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
</template>

<style scoped>
.form-add-user{
    display: flex;
    align-items: center;
    justify-content: space-between;
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

.task-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}

.close:hover{
    cursor: pointer;
}

.el-col{
    padding-left: 0;
}

.el-button+.el-button{
    margin-left: 0;
}

</style>