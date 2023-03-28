<script lang="ts" setup>
import { ref, reactive, unref} from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus';
import request from '../../utils/request';

const props = defineProps({
    task_group_id: Number,
    task_group_created_by: String
})

const infoTaskGroup = ref([]);

async function getInfoTaskGroup() {
    await request.get(`/api/taskgroup/${props.task_group_id}`).then((res) => {
        infoTaskGroup.value = res.data.result
    })
}

getInfoTaskGroup()
</script>
<template>
    <hr>
    <el-row>
        <el-col :span="18">Người tạo</el-col>
        <el-col :span="6">{{ infoTaskGroup.author }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Tổng số việc</el-col>
        <el-col :span="6">{{ infoTaskGroup.total_task }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Đang làm</el-col>
        <el-col :span="6">{{ infoTaskGroup.total_task_doing }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Chưa lên lịch</el-col>
        <el-col :span="6">0</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Quá hạn</el-col>
        <el-col :span="6">{{ infoTaskGroup.total_task_not_schedule }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Hoàn thành</el-col>
        <el-col :span="6">{{ infoTaskGroup.total_task_done }}</el-col>
    </el-row>
</template>