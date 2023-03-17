<script setup>
import { ElMessage } from 'element-plus';
import { ref } from 'vue'
import request from "../../utils/request";

const props = defineProps({
    icon: String,
    title: String,
    task: Object,
    closeModal: Function,
    isDisabled: Boolean,
});

const loading = ref(false)
const handleCopyTask = ()=>{
    loading.value = true
    request.post(`/clone-task-by-id/${props.task.id}`).then((res) => {
        ElMessage({
            showClose: true,
            message: "Copy task thành công",
            type: "success",
        });
        props.closeModal();
        loading.value = false
    }).catch(err => {
        loading.value = false
    });
}
</script>

<template>
    <el-button :disabled="isDisabled" class="btn-container" :icon="icon" @click="handleCopyTask" :loading="loading">
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
