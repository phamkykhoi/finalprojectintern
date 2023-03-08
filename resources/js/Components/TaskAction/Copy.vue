<script setup>

const props = defineProps({
    icon: String,
    title: String
});
</script>

<template>
    <el-button class="btn-container" :icon="icon">
        {{ props.title }}
    </el-button>
</template>