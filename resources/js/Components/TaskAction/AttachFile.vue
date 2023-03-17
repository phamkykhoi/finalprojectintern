<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'
import { CloseBold, ChromeFilled, Box, Cloudy, Folder }from '@element-plus/icons-vue';
const props = defineProps({
    icon: String,
    title: String,
    isDisabled: Boolean,
});

const buttonRef7 = ref()
const popoverRef7 = ref()
const onClickOutside7 = () => {
  unref(popoverRef7).popperRef7?.delayHide?.()
}
const hidePopover7 = () => {
    popoverRef7.value.hide()
}
</script>

<template>
    <el-button :disabled="isDisabled" :icon="icon" class="btn-container" ref="buttonRef7" v-click-outside="onClickOutside7">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="300"
        ref="popoverRef7"
        :virtual-ref="buttonRef7"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
                <p>Đính kèm từ tập tin</p>
                <el-icon class="close" @click="hidePopover7"><CloseBold /></el-icon>
        </div>
        <div class="btn-container">
            <el-button :icon="Folder" text class="btn-container1">Máy tính</el-button>
            <el-button :icon="ChromeFilled" text class="btn-container1">Google</el-button>
            <el-button :icon="Box" text class="btn-container1">Dropbox</el-button>
            <el-button :icon="Cloudy" text class="btn-container1">OneDrive</el-button>
        </div>
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
.btn-container1 {
    justify-content: flex-start;
    width: 99%;
}
</style>
