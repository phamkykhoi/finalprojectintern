<script setup>

const props = defineProps({
    icon: String,
    title: String
});

const emit = defineEmits([
    'openDialogAddTaskGroup', 
]);

const openDialogAddTaskGroup = () => {
    emit('openDialogAddTaskGroup');
};

</script>

<template>
    <el-button @click="openDialogAddTaskGroup" :icon="icon">
        {{ props.title }}
    </el-button>
</template>
<style scoped>
    .el-button .is-circle {
        padding: 8px 15px;
    }
</style>