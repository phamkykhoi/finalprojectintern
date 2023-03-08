<script setup>

const props = defineProps({
    icon: String,
    title: String
});

const emit = defineEmits([
    'openDialogAddTask', 
]);

const openDialogAddTask = () => {
    emit('openDialogAddTask');
};

</script>

<template>
    <el-button @click="openDialogAddTask" v-popover="poppveraddNewTask"
        v-click-outside="false" :icon="icon"> 
        {{ props.title }}
    </el-button>
</template>