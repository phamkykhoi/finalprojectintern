<script setup lang="ts">
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'

const props = defineProps({
    icon: String,
    title: String
});
const dialogStore = ref(false)
const storeTaskGroup = ref()
const onClickOutside = () => {
    unref(storeTaskGroup).popperRef?.delayHide?.()
}
</script>

<template>
    <el-button style="border: none;" v-popover="storeTaskGroup"  @click="dialogStore = !dialogStore" :icon="icon" v-click-outsite="onClickOutside">
        {{ props.title }}
    </el-button>
    <el-popover
        ref="storeTaskGroup"
        :visible="dialogStore"
        trigger="click"
        virtual-triggering
        width="303px"
        persistent
    >
        <el-row class="title-dialog">
            <el-col :span="18" class="title">
                <el-form-item label="Lưu trữ Nhóm việc"></el-form-item>
            </el-col>
            <el-col :span="2">
                <a class="close" @click="dialogStore = false">x</a>
            </el-col>
        </el-row>
        <el-row>
            <p style="white-space: pre-line;">Thao tác này sẽ chuyển Nhóm công việc vào lưu trữ.
                Bạn có thể vào danh sách công việc lưu trữ để phục hồi lại.
                Bạn có muốn tiếp tục không?
            </p>
        </el-row>
        <el-row>
            <el-col :span="10"></el-col>
            <el-col :span="8"><el-button type="success" round>Xác nhận</el-button></el-col>
            <el-col :span="6"><el-button type="info" round @click="dialogStore = false">Hủy</el-button></el-col>
        </el-row>
    </el-popover>
</template>