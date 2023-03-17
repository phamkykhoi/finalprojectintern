<script setup>
import { ref, unref} from 'vue'
import { ClickOutside as vClickOutside, ElMessage} from "element-plus";
import request from '../../utils/request';
const props = defineProps({
    icon: String,
    title: String,
    task: Object,
});

const unlockButton = ref()
const unlockPopover = ref()
const loading = ref(false)
const emit = defineEmits(['is-task-unlocked']);

const clickOutsideUnlock = () => {
  unref(unlockPopover).popperRef8?.delayHide?.()
}
const hideUnlockPopover = () => {
    unlockPopover.value.hide()
}

const handleUnlockTask = () =>{
    loading.value = true
    request.post(`/unlock-task-by-id/${props.task.id}`)
    .then(res => {
        ElMessage({
            showClose: true,
            message: "You have unlocked this task!",
            type: "success",
        });
        emit('is-task-unlocked');
        loading.value = false
    })
    .catch(err => {
        loading.value = false
    });

    hideUnlockPopover();
}
</script>

<template>
     <el-button :icon="icon" class="btn-container" ref="unlockButton" v-click-outside="clickOutsideUnlock" :loading="loading">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="350"
        ref="unlockPopover"
        :virtual-ref="unlockButton"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
                <p>Mở khóa việc</p>
        </div>
        <p>
            Tất cả thành viên sẽ có thể thay đổi nội dung, người theo dõi, bình luận, đính kèm file.. và kế hoạch sẽ về trạng thái public
        </p>
        <div class="flex mt-6" >
        <el-button class="unlock-btn" type="danger" @click="hideUnlockPopover" >Hủy bỏ</el-button>
        <el-button class="unlock-btn" style="margin-left:80px"  type="success" @click="handleUnlockTask">Xác nhận</el-button>
        </div>
    </el-popover>
</template>

<style scoped>
.form-add-user {
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
.unlock-btn{
     width: 40% !important;
     border-radius:5px !important;
     place-content: center !important;
}
</style>
