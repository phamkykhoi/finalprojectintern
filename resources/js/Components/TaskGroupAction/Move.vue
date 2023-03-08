<script setup>
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'

const props = defineProps({
    icon: String,
    title: String
});
const dialogMove = ref(false)
const moveJobGroup = ref()
const onClickOutside = () => {
  unref(moveJobGroup).popperRef?.delayHide?.()
}
</script>

<template>
    <el-button v-popover="moveJobGroup" @click="dialogMove = true" :icon="icon" v-click-outsite="onClickOutside">
        {{ props.title }}
    </el-button>
    <el-popover
            :visible="dialogMove"
            ref="moveJobGroup"
            trigger="click"
            virtual-triggering
            width="300px"
            persistent
    >
        <el-row class="title-dialog">
            <el-col :span="18" class="title">
                <el-form-item label="Di chuyển nhóm việc"></el-form-item>
            </el-col>
            <el-col :span="2">
                <a class="close" @click="dialogMove = false">x</a>
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
            <el-button type="success">Sao chép</el-button>
        </div>
    </el-popover>
</template>