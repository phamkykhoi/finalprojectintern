<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'
const props = defineProps({
    icon: String,
    title: String,
    isDisabled: Boolean,
});

const buttonRef9 = ref()
const popoverRef9 = ref()
const onClickOutside9 = () => {
  unref(popoverRef9).popperRef9?.delayHide?.()
}
const hidePopover9 = () => {
    popoverRef9.value.hide()
}
</script>

<template>
    <el-button :disabled="isDisabled" :icon="icon" ref="buttonRef9" v-click-outside="onClickOutside9" class="btn-container">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="350"
        ref="popoverRef9"
        :virtual-ref="buttonRef9"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
                <p>Lưu trữ</p>
                <el-icon class="close" @click="hidePopover9"><CloseBold /></el-icon>
        </div>
        <p>
            Bạn có chắc là lưu trữ công việc này không?
        </p>
        <p style="color: red;">
            Bạn có thể phục hồi lại khi cần.
        </p>
        <el-button style="width: 100%; margin-top: 12px; place-content: center;" type="danger">Xác nhận</el-button>
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
