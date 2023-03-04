<script lang="ts" setup>
import { ref, reactive, unref} from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus'

// const props = defineProps({
//     id: Number,
// });

// const popoverRef = ref([])
// const onClickOutside = () => {
//   unref(popoverRef).popperRef?.delayHide?.()
// }

</script>
<template>
    <!-- <el-popover 
        :ref="ref => popoverRef[props.id] = ref"
        title="taskGroup1"
        virtual-triggering
        persistent
        width="300px"
    > -->
        <hr>
        <el-row>
            <el-col :span="18">Người tạo</el-col>
            <el-col :span="6">User01</el-col>
        </el-row>
        <el-row>
            <el-col :span="18">Tổng số việc</el-col>
            <el-col :span="6">0</el-col>
        </el-row>
        <el-row>
            <el-col :span="18">Đang làm</el-col>
            <el-col :span="6">0</el-col>
        </el-row>
        <el-row>
            <el-col :span="18">Chưa lên lịch</el-col>
            <el-col :span="6">0</el-col>
        </el-row>
        <el-row>
            <el-col :span="18">Quá hạn</el-col>
            <el-col :span="6">0</el-col>
        </el-row>
        <el-row>
            <el-col :span="18">Hoàn thành</el-col>
            <el-col :span="6">0</el-col>
        </el-row>
    <!-- </el-popover> -->
</template>