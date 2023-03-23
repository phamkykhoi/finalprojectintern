<script lang="ts" setup>
import { ref, defineEmits, unref, reactive, onBeforeMount, computed, provide } from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus'
import { Clock, Avatar } from '@element-plus/icons-vue';
import TimeAgo from 'javascript-time-ago';
import vi from 'javascript-time-ago/locale/vi';
import { ElMessage } from "element-plus";
import request from "../../utils/request";

const props = defineProps({
    taskId: Number
})

const logs = ref();

const loading = ref(false);

const limitItem = ref(5);

const showHistory = ref(false)

TimeAgo.addDefaultLocale(vi)

const timeAgo = new TimeAgo('vi')

function ShowHistory(){
    showHistory.value = true
    getLogs()
}

function CloseHistory(){
    limitItem.value = 3;
    showHistory.value = false
}

function showMore(){
    limitItem.value = limitItem.value + 2
}

function getLogs()
{
    loading.value=true
    request.get(`/activity-log/${props.taskId}`)
        .then((res) => {
            logs.value = res.data.result.listLogs
            loading.value=false
        })
        .catch(err => {
            ElMessage({
                showClose: true,
                message: err.response.data.message,
                type: 'error',
            })
            loading.value=false;
        })
}

onBeforeMount(async () => {
    getLogs();
});

provide('logsProvider', { getLogs })
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
        <el-icon v-if="!showHistory" :size="25">
            <img class="comment-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU" />
        </el-icon>
        <div v-if="showHistory" style="width: 100%;" v-loading="loading"> 
            <template v-for="(log, index) in logs" :key="index" >
                <div v-if="index < limitItem" class="flex" style="padding: 4px 0; align-items: center;">
                    <img class="comment-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU" />
                    <div style="display: flex; flex-direction: column; justify-content: space-between; line-height: 140%;">
                        <p> {{ log.description }} </p>
                        <p>{{ timeAgo.format((new Date(log.created_at))) }}</p>
                    </div>
                </div>
            </template>
            <div style="text-align: center;">
                <el-link v-if="limitItem < logs.length" @click="showMore">Xem thêm</el-link>
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