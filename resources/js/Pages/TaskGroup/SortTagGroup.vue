<script lang="ts" setup>
import { CaretTop, CaretBottom, Select, CircleClose } from '@element-plus/icons-vue';
import { reactive, ref } from 'vue';

    const dialog = reactive({
       showIconSort: [false],
       showIcon: [false],
       input:'',
    });
</script>

<template>
    <div>
    <el-row>
        <el-col class="icon-sort-small" :span="12">
            <el-row v-if="dialog.showIcon[3]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[3] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Ngày hòan thành</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[3] = !dialog.showIconSort[3]">
                    <el-icon v-if="dialog.showIconSort[3]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[3]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
            <el-row v-if="dialog.showIcon[5]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[5] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Ngày thực hiện</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[5] = !dialog.showIconSort[5]">
                    <el-icon v-if="dialog.showIconSort[5]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[5]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
            <el-row v-if="dialog.showIcon[1]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[1] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Ngày bắt đầu</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[1] = !dialog.showIconSort[1]">
                    <el-icon v-if="dialog.showIconSort[1]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[1]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
        </el-col>
        <el-col class="icon-sort-small" :span="12">
            <el-row v-if="dialog.showIcon[3]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[4] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Ngày tạo</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[4] = !dialog.showIconSort[4]">
                    <el-icon v-if="dialog.showIconSort[4]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[4]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
            <el-row v-if="dialog.showIcon[2]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[2] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Ngày kết thúc</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[2] = !dialog.showIconSort[2]">
                    <el-icon v-if="dialog.showIconSort[2]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[2]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
            <el-row v-if="dialog.showIcon[0]" :span="24">
                <el-col :span="3" class="icon-small"  @click="dialog.showIcon[0] = false">
                    <el-icon><CircleClose /></el-icon>
                </el-col>
                <el-col :span="18">Tên công việc</el-col>
                <el-col :span="3" class="icon-small" @click="dialog.showIconSort[0] = !dialog.showIconSort[0]">
                    <el-icon v-if="dialog.showIconSort[0]"><CaretTop /></el-icon>
                    <el-icon v-if="!dialog.showIconSort[0]"><CaretBottom /></el-icon>
                </el-col>
            </el-row>
        </el-col>
    </el-row>

    <el-col>
        <el-button @click="dialog.showIcon[0] = true" v-if="!dialog.showIcon[0]">Tên công việc</el-button>
        <el-row v-if="dialog.showIcon[0]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[0] = !dialog.showIconSort[0]">
                <el-icon v-if="dialog.showIconSort[0]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[0]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Tên công việc</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[0] = false"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button @click="dialog.showIcon[1] = true" v-if="!dialog.showIcon[1]">Ngày bắt đầu</el-button>
        <el-row v-if="dialog.showIcon[1]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[1] = !dialog.showIconSort[1]">
                <el-icon v-if="dialog.showIconSort[1]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[1]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Ngày bắt đầu</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[1] = false"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button @click="dialog.showIcon[2] = true" v-if="!dialog.showIcon[2]">Ngày kết thúc</el-button>
        <el-row v-if="dialog.showIcon[2]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[2] = !dialog.showIconSort[2]">
                <el-icon v-if="dialog.showIconSort[2]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[2]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Ngày kết thúc</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[2] = false"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button @click="dialog.showIcon[3] = true" v-if="!dialog.showIcon[3]">Ngày hoàn thành</el-button>
        <el-row v-if="dialog.showIcon[3]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[3] = !dialog.showIconSort[3]">
                <el-icon v-if="dialog.showIconSort[3]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[3]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Ngày hoàn thành</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[3] = false"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button @click="dialog.showIcon[4] = true" v-if="!dialog.showIcon[4]">Ngày tạo</el-button>
        <el-row v-if="dialog.showIcon[4]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[4] = !dialog.showIconSort[4]">
                <el-icon v-if="dialog.showIconSort[4]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[4]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Ngày tạo</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[4] = false"><Select /></el-icon>
            </el-col>
        </el-row>
    </el-col>
    <el-col>
        <el-button @click="dialog.showIcon[5] = true" v-if="!dialog.showIcon[5]">Ngày thực hiện</el-button>
        <el-row v-if="dialog.showIcon[5]">
            <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[5] = !dialog.showIconSort[5]">
                <el-icon v-if="dialog.showIconSort[5]"><CaretTop /></el-icon>
                <el-icon v-if="!dialog.showIconSort[5]"><CaretBottom /></el-icon>
            </el-col>
            <el-col :span="18">Ngày thực hiện</el-col>
            <el-col :span="4" class="icon-sort">
                <el-icon  @click="dialog.showIcon[5] = false"><Select /></el-icon>
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