<script lang="ts" setup>
import { ref, reactive, unref} from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus';
import request from '../../utils/request';

const props = defineProps({
    task_group_id: Number
})

const infoTaskGroup = ref([]);

async function getInfoTaskGroup() {
    await request.get(`/api/taskgroup/${props.task_group_id}`).then((res) => {
        infoTaskGroup.value = res.data.result.infoTaskGroup
    })
}

getInfoTaskGroup()
</script>
<template>
    <hr>
    <el-row>
        <el-col :span="18">Người tạo</el-col>
        <el-col :span="6">User01</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Tổng số việc</el-col>
        <el-col :span="6">{{ infoTaskGroup.totalTask }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Đang làm</el-col>
        <el-col :span="6">{{ infoTaskGroup.totalTasking }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Chưa lên lịch</el-col>
        <el-col :span="6">0</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Quá hạn</el-col>
        <el-col :span="6">{{ infoTaskGroup.totalOverDate }}</el-col>
    </el-row>
    <el-row>
        <el-col :span="18">Hoàn thành</el-col>
        <el-col :span="6">{{ infoTaskGroup.totalTaskFinish }}</el-col>
    </el-row>
</template>