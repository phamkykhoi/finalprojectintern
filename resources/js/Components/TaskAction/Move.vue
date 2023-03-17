<script setup>

const props = defineProps({
    icon: String,
    title: String,
    isDisabled: Boolean,
});
</script>

<template>
    <el-button :disabled="isDisabled" class="btn-container" :icon="icon">
        {{ props.title }}
    </el-button>
</template>

<style scoped>
.btn-container {
    justify-content: flex-start;
    width: 105%;
    margin: 2px 0;
}
</style>
