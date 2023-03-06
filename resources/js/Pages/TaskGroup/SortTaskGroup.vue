<script lang="ts" setup>
import { CaretTop, CaretBottom, Select, CircleClose } from '@element-plus/icons-vue';
import { reactive, ref } from 'vue';

    const icon = reactive({
       showIconSort: [false],
       showIcon: [false],
       input:'',
    });

    const sortList=ref([
        "Tên công việc", 
        "Ngày bắt đầu", 
        "Ngày kết thúc",
        "Ngày hòan thành", 
        "Ngày tạo", 
        "Ngày thực hiện"
    ])

    function iconShow(index) {
        icon.showIcon[index] = true;
    }

    function iconClose(index) {
        icon.showIcon[index] = false;
    }

    function showIconSort(index) {
        icon.showIconSort[index] = !icon.showIconSort[index];
    }
</script>

<template>
    <div>
    <el-row>
        <el-col v-for="(list, index) in sortList" :key="index" :span="12" class="icon-sort-small">
            <el-row v-if="icon.showIcon[index]" :span="24">
                <el-col :span="3" class="icon-small"  @click="iconClose(index)">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">{{ list }}</el-col>
                <el-col :span="3" class="icon-small" @click="showIconSort(index)">
                    <el-icon v-if="icon.showIconSort[index]"><CaretTop /></el-icon>
                    <el-icon v-if="!icon.showIconSort[index]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
        </el-col>
    </el-row>

    <el-col v-for="(list, index) in sortList" :key="index">
        <el-button @click="iconShow(index)" v-if="!icon.showIcon[index]">{{ list }}</el-button>
        <el-row v-if="icon.showIcon[index]">
            <el-col :span="2" class="icon-sort" @click="showIconSort(index)">
                <el-icon v-if="icon.showIconSort[index]"><CaretTop /></el-icon>
                <el-icon v-if="!icon.showIconSort[index]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">{{ list }}</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="iconClose(index)"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button style="place-content: center;" type="danger" round>Mặc định theo kế hoạch</el-button>
    </el-col>
    </div>
</template>

<style scoped>
.icon-sort {
    line-height: 1.5rem;
}

.icon-sort .el-icon{
    color: green;
}

.icon-sort-small {
    font-size: 10px;
    line-height: 1.1rem;
    color: green;
    font-weight: bold;
}

.el-popover .el-button {
    width: 100%;
    place-content: normal;
    border: none;
    border-radius: 0;
}

</style>