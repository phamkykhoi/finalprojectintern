<script setup>
import { ref, unref } from 'vue'
const props = defineProps({
    icon: String,
    title: String,
    isDisabled: Boolean,
});
</script>

<template>
    <el-button :disabled="isDisabled" :icon="icon" class="btn-container">
        {{ props.title }}
    </el-button>
</template>
<style scoped>
.form-add-user{
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
