<script lang="ts" setup>
import { ref, defineEmits, unref, reactive } from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus'
import { Clock, Avatar } from '@element-plus/icons-vue';

const props = defineProps({
    taskId: Number
})
const activities = ref([
    { 
        id: 1,
        content: 'Thành viên đã thêm hoạt động'
    },
    {   
        id: 2,
        content: 'Thành viên đã xóa hoạt động'
    },
    {   
        id: 3,
        content: 'Thành viên đã sửa hoạt động'
    },
    { 
        id: 4,
        content: 'Thành viên đã đánh giá'
    },
    {   
        id: 5,
        content: 'Thành viên đã bỏ đánh dấu'
    },
    {   
        id: 6,
        content: 'Thành viên đã tắt tính năng'
    }
])

const limitItem = ref(3);

const showHistory = ref(false)

function ShowHistory(){
    showHistory.value = true
}

function CloseHistory(){
    limitItem.value = 3;
    showHistory.value = false
}

function showMore(){
    limitItem.value = limitItem.value + 2
}
</script>

<template>
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
            <template v-for="(activity, index) in activities" :key="index" >
                <div v-if="index < limitItem" class="flex" style="padding: 4px 0; align-items: center;">
                    <el-icon :size="25" style="margin-right: 12px;"><Avatar /></el-icon>
                    <div style="display: flex; flex-direction: column; justify-content: space-between; line-height: 140%;">
                        <p> {{ activity.content }} </p>
                        <p>03/03 16:00</p>
                    </div>
                </div>
            </template>
            <div style="text-align: center;">
                <el-link v-if="limitItem < activities.length" @click="showMore">Xem thêm</el-link>
            </div>
        </div>
    </el-form-item>
</template>
<style scoped>
.task-child{
    justify-content: space-between;
}
.btn-add-user{
    width: 100%;
}
.demo-image{
    display: flex;
    justify-content: center;
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
</style>