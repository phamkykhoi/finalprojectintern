<script setup>
import { ClickOutside as vClickOutside} from "element-plus";
const props = defineProps({
    icon: String,
    title: String,
});
</script>

<template>
    <el-button
        :icon="icon"
        class="btn-container"
    >
        {{ props.title }}
    </el-button>
</template>

<style scoped>
.form-add-user {
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
</style>
