<script setup lang="ts">
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'

const props = defineProps({
    icon: String,
    title: String,
});
const dialogDelete = ref(false)

const deleteTaskGroup = ref()
const onClickOutside = () => {
  unref(deleteTaskGroup).popperRef?.delayHide?.()
}
 function closePopover() {
    dialogDelete.value = false
 }
</script>

<template>
    <el-button v-popover="deleteTaskGroup" @click="dialogDelete = true" :icon="icon" v-click-outsite="onClickOutside">
       {{ props.title }}
    </el-button>
    <el-popover
        ref="deleteTaskGroup"
        :visible="dialogDelete"
        trigger="click"
        virtual-triggering
        width="350px"
        persistent
    >
        <el-row class="title-dialog">
            <el-col :span="18" class="title">
                <el-form-item label="Xóa nhóm việc"></el-form-item>
            </el-col>
            <el-col :span="2"> 
                <a class="close" @click="dialogDelete = false">x</a>
            </el-col>
        </el-row>
        <el-row>
            <p style="white-space: pre-line;">Bạn có chắc là xoá nhóm việc này không?
                Vui lòng nhập số <b>5</b> vào ô bên dưới để xác nhận
                <b style="color: red;">Nếu xoá bạn sẽ không thể phục hồi lại.</b>
            </p>
        </el-row>
        <el-row>
            <el-input v-model="input" placeholder="5" />
        </el-row>
        <el-row>
            <el-col><el-button style="place-content: center;" type="danger" round>Xóa</el-button></el-col>
        </el-row>
    </el-popover>
</template>