<script setup>

const props = defineProps({
    icon: String,
    title: String
});
</script>

<template>
    <el-button :icon="icon" class="btn-container">
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