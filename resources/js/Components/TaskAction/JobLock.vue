<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'
const props = defineProps({
    icon: String,
    title: String
});

const buttonRef8 = ref()
const popoverRef8 = ref()
const onClickOutside8 = () => {
  unref(popoverRef8).popperRef8?.delayHide?.()
}
const hidePopover8 = () => {
    popoverRef8.value.hide()
}
</script>

<template>
    <el-button :icon="icon" class="btn-container" ref="buttonRef8" v-click-outside="onClickOutside8">
        {{ props.title }}
    </el-button>
    <el-popover
        :width="350"
        ref="popoverRef8"
        :virtual-ref="buttonRef8"
        trigger="click"
        virtual-triggering
    >
        <div class="form-add-user">
                <p>Khóa việc</p>
                <el-icon class="close" @click="hidePopover8"><CloseBold /></el-icon>
        </div>
        <p>
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Incidunt inventore
            nostrum laudantium consequuntur doloremque accusantium autem nam sit culpa
            odit eligendi exercitationem provident error, dignissimos pariatur fugit id facere? Quae.
        </p>
        <el-button style="width: 100%; margin-top: 12px; place-content: center;" type="danger">Xác nhận</el-button>
    </el-popover>
</template>