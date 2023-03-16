<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside, ElMessage } from 'element-plus'
import { CloseBold } from '@element-plus/icons-vue';
import request from '../../utils/request';
const props = defineProps({
    icon: String,
    title: String,
    task: Object,
});

const confirmButton = ref()
const lockPopover = ref()
const loading = ref(false)
const clickOutsideLockPopover = () => {
  unref(lockPopover).popperRef8?.delayHide?.()
}
const hideLockPopover = () => {
    lockPopover.value.hide()
}

const handleLockTask = () =>{
    loading.value = true
    request.put(`/task/${props.task.id}`, {...props.task,
    is_locked: true,
    })
    .then(res => {
        ElMessage({
            showClose: true,
            message: "You have locked this task!",
            type: "success",
        });
        loading.value = false
    })
    .catch(err => {
        loading.value = false
    });

    hideLockPopover();
}
</script>

<template>
    <el-button :icon="icon" class="btn-container" ref="confirmButton" v-click-outside="clickOutsideLockPopover" :loading="loading">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="350"
        ref="lockPopover"
        :virtual-ref="confirmButton"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
                <p>Khóa việc</p>
                <el-icon class="close" @click="hideLockPopover" color="red"><CloseBold /></el-icon>
        </div>
        <p>
            Tất cả thành viên không thể thay đổi nội dung, người theo dõi, bình luận, đính kèm file..., không hiển thị nếu kế hoạch public
        </p>
        <el-button style="width: 100%; margin-top: 12px; place-content: center;" type="danger" @click = "handleLockTask">Xác nhận</el-button>
    </el-popover>
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
</style>
