<script setup>
import AttachFile from '@/Components/TaskAction/AttachFile.vue';
import Copy from '@/Components/TaskAction/Copy.vue';
import Move from '@/Components/TaskAction/Move.vue';
import Delete from '@/Components/TaskAction/Delete.vue';
import Save from '@/Components/TaskAction/Save.vue';
import Evaluation from '@/Components/TaskAction/Evaluation.vue';
import JobLock from '@/Components/TaskAction/JobLock.vue';
import CreateReminder from '@/Components/TaskAction/CreateReminder.vue';
import UpdateThePlan from '@/Components/TaskAction/UpdateThePlan.vue';
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

const title = reactive({
    updateThePlan: 'Cập nhật vào kế hoạch',
    attachFile: 'Đính kèm tệp tin',
    copy: 'Sao chép việc',
    move: 'Di chuyển việc',
    reminder: 'Tạo nhắc việc',
    evaluation: 'Đánh giá hoàn thành',
    lock: 'Khoá việc',
    save: 'Lưu trữ việc',
    delete: 'Xóa việc',
});

</script>

<template>
        <el-checkbox v-model="taskForm.is_quickly" id="is_quickly" @change="changeQuicklyStatus(task.id)" label="Việc Khẩn cấp" size="large" />
        <el-checkbox v-model="taskForm.is_important" id="is_important" @change="changeImportantStatus(task.id)" label="Việc Quan trọng" size="large" />
        <div class="btn-container">
            <UpdateThePlan :icon="DocumentAdd" :title="title.updateThePlan"/>
            <AttachFile :icon="DocumentAdd" :title="title.attachFile"/>
            <Copy :icon="DocumentCopy" :title="title.copy" />
            <Move :icon="Rank" :title="title.move" />
            <CreateReminder :icon="Bell" :title="title.reminder"/>
            <Evaluation :icon="Finished" :title="title.evaluation" />
            <JobLock :icon="Lock" :title="title.lock"/>
            <Save :icon="TakeawayBox" :title="title.save"/>
            <Delete :icon="Close" :title="title.delete" />
        </div>
</template>

<style>
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