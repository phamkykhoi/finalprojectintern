<script setup>
import { ref, unref } from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus';

const props = defineProps({
    icon: String,
    title: String
});
const dialogMoveAll = ref(false)
const moveAllTheWork = ref()
const onClickOutside = () => {
  unref(moveAllTheWork).popperRef?.delayHide?.()
}
</script>

<template>
    <el-button v-popover="moveAllTheWork" :icon="icon" @click="dialogMoveAll=true" v-click-outside="onClickOutside"> 
        {{ props.title }}
    </el-button>
    <el-popover
        :visible="dialogMoveAll"
        ref="moveAllTheWork"
        trigger="click"
        virtual-triggering
        width="350px"
        persistent
    >
        <el-row class="title-dialog">
            <el-col :span="17" class="title">
                <p>Di chuyển toàn bộ công việc trong nhóm việc</p>
            </el-col>
            <el-col :span="5">
                <a class="close" @click="dialogMoveAll=false">x</a>
            </el-col>
        </el-row>
        <el-row>
            <el-col>
                <div>Team</div>
                <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                    <el-option key="" label="Team 1" value="Team 1"
                    />
                </el-select>  
            </el-col>
        </el-row>
        <el-row>
            <el-col>
                <div>Kế hoạch</div>
                <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                    <el-option key="" label="Kế hoạch" value="Kế hoạch"
                    />
                </el-select>  
            </el-col>
        </el-row>
        <el-row>
            <el-col>
                <div>Nhóm việc</div>
                <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                    <el-option key="" label="Nhóm việc" value="Nhóm việc"
                    />
                </el-select>  
            </el-col>
        </el-row>
        <el-row>
            <el-col>Thành viên theo dõi công việc</el-col>
        </el-row>
        <el-row>
            <el-checkbox v-model="checked" size="large" label="Mời thành viên theo dõi công việc vào kế hoạch , nếu chưa được mời" />
        </el-row>
        <div class="select">
            <el-button type="success">Sao chép</el-button>
        </div>
    </el-popover>
</template>