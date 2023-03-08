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