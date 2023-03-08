<script setup>

const props = defineProps({
    icon: String,
    title: String,
    idTaskGroup: Number,
    editNameTaskGroup:Array,
});

function editNameTaskGroup(index) {
    props.editNameTaskGroup[index] = !props.editNameTaskGroup[index]
}
</script>

<template>
    <el-button @click="editNameTaskGroup(idTaskGroup)" :icon="icon">
        {{ props.title }}
    </el-button>
</template>