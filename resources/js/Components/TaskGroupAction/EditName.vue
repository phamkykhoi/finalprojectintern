<script setup>

const props = defineProps({
    icon: String,
    title: String,
    idTaskGroup: Number,
    editNameTaskGroup:Array,
});

</script>

<template>
    <el-button :icon="icon">
        {{ props.title }}
    </el-button>
</template>