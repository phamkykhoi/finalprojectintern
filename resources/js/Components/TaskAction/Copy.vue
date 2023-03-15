<script setup>
import { ElMessage } from 'element-plus';
import { reactive, ref, unref } from 'vue'
import request from "../../utils/request";
const props = defineProps({
    icon: String,
    title: String,
    task: Object,
    closeModal: Function,
});

const handleCopyTask = ()=>{
    console.log(props.task);
    request.post(`/clone-task-by-id/${props.task.id}`).then((res) => {
                ElMessage({
                    showClose: true,
                    message: "Copy task thành công",
                    type: "success",
                });
                props.closeModal();
            });
}
</script>

<template>
    <el-button class="btn-container" :icon="icon" @click="handleCopyTask">
        {{ props.title }}
    </el-button>
</template>

<style scoped>
.btn-container {
    justify-content: flex-start;
    width: 105%;
    margin: 2px 0;
}
</style>
