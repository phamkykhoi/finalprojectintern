<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'
const props = defineProps({
    icon: String,
    title: String,
    isDisabled: Boolean,
});

const buttonRef10 = ref()
const popoverRef10 = ref()
const onClickOutside10 = () => {
  unref(popoverRef10).popperRef10?.delayHide?.()
}
const hidePopover10 = () => {
    popoverRef10.value.hide()
}
</script>

<template>
    <el-button :disabled="isDisabled" :icon="icon" ref="buttonRef10" v-click-outside="onClickOutside10" class="btn-container">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="350"
        ref="popoverRef10"
        :virtual-ref="buttonRef10"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
            <p>Xóa công việc</p>
            <el-icon class="close" @click="hidePopover10"><CloseBold /></el-icon>
        </div>
        <p>
            Bạn có chắc là xoá công việc này không?
        </p>
        <p>
            Vui lòng nhập số 0 vào ô bên dưới để xác nhận xóa
        </p>
        <p style="color: red;">
            Nếu xoá bạn sẽ không thể phục hồi lại.
        </p>
        <el-input v-model="input" placeholder="Please input" />
        <el-button style="width: 100%; margin-top: 12px; place-content: center;" type="danger">Xóa</el-button>
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
