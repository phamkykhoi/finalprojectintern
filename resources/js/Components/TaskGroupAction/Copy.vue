<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'

const props = defineProps({
    icon: String,
    title: String
});

const dialogCopy = ref(false)
const copyJobGroup = ref()
const onClickOutside2 = () => {
  unref(copyJobGroup).popperRef?.delayHide?.()
}

</script>

<template>
    <el-button  v-popover="copyJobGroup" @click="dialogCopy = true" :icon="icon" v-click-outside="onClickOutside2">
        {{ props.title }}
    </el-button>

    <el-popover
        :visible="dialogCopy"
        ref="copyJobGroup"
        trigger="click"
        virtual-triggering
        width="300px"
        persistent
    >
        <el-row class="title-dialog">
            <el-col :span="18" class="title">
                <el-form-item label="Sao chép nhóm việc"></el-form-item>
            </el-col>
            <el-col :span="2">
                <a class="close" @click="dialogCopy = false">x</a>
            </el-col>
        </el-row>
        <div class="select">
            <p>Team</p>
            <el-select v-model="value" placeholder="Chọn">
                <el-option key="" label="" value="Team 1"
                />
            </el-select>        
        </div>
        <div class="select">
            <p>Kế hoạch</p>
            <el-select v-model="value" placeholder="Chọn">
                <el-option key="" label="Kế hoạch" value=""
                />
            </el-select>
        </div>
        <div class="select">
            <el-button type="success" @click="copyTaskGroup(taskGroup.id)">Sao chép</el-button>
        </div>
    </el-popover>
</template>