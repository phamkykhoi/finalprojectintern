<script setup>

const dialogVisible = ref(false)
const props = defineProps({
    icon: String,
    title: String
});
</script>

<template>
    <el-button  class="btn-container"  @click="dialogVisible = true" :icon="icon">
        {{ props.title }}
    </el-button>
    <el-dialog
        v-model="dialogVisible"
        title="Nhắc việc"
        width="60%"
    >
    <div >
        <span>Thời gian bắt đầu nhắc việc</span>
        <div>
            <p>Chu kỳ nhắc việc</p>
            <div style="width: 100%;">
                <el-select style="width: 100%; margin-left: -8px;" v-model="value" class="m-2" placeholder="Select">
                    <el-option
                    v-for="item in options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                    />
                </el-select>
            </div>
        </div>
        <div>
            <p>Chu kỳ nhắc việc</p>
            <div>
                <el-checkbox v-model="checked1" label="Option 1" size="large" />
            </div>
            <div>
                <el-checkbox v-model="checked2" label="Option 2" size="large" />
            </div>
        </div>
        <p style="color: green;">Nhắc việc hàng ngày lúc 10:00</p>
    </div>
        <template #footer>
            <span class="dialog-footer">
                <el-button type="success" @click="dialogVisible = false">
                    Cài đặt
                </el-button>
                <el-button @click="dialogVisible = false"  style="margin-left: 8px;">Đóng</el-button>
            </span>
        </template>
    </el-dialog>
</template>