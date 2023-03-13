<script setup>

import TaskDetail from './Detail.vue'
import { ref, reactive} from 'vue';

const props = defineProps({
    tasks: Array,
    task_group_id: Number,
    taskGroup: Object,
    activity: Object
});

const isShowTaskDetail = ref(false);

const state  = reactive({
    task: {
        name: "",
        description: "",
    },
    task_group_id: props.task_group_id,
})

function taskDetail(task) {
    isShowTaskDetail.value = true;
    state.task = task;
}

function closeTaskDetail(value) {
    isShowTaskDetail.value = value
}
</script>

<template>
    <ul class="list-items" :key="index" v-for="(task, index) in tasks">
        <li @click="taskDetail(task)">{{  task.name }}</li>
    </ul>

    <TaskDetail :activity="props.activity" v-if="isShowTaskDetail" v-on:closeModal="closeTaskDetail" :taskGroup="taskGroup" :isShowModal="isShowTaskDetail" :task="state.task" :task_group_id="props.task_group_id"/>
</template>

<style scoped>
.list-items {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-content: start;
    padding: 0 0.6rem 0.5rem;
    overflow-y: scroll;
    scrollbar-width: thin;
}

.list-items::-webkit-scrollbar {
    width: 1rem;
}

.list-items::-webkit-scrollbar-thumb {
    background-color: #c4c9cc;
    border-right: 0.6rem solid #e2e4e6;
}

.list-items li {
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.3;
    background-color: #fff;
    padding: 0.65rem 0.6rem;
    color: #4d4d4d;
    border-bottom: 0.1rem solid #ccc;
    border-radius: 0.3rem;
    margin-bottom: 0.6rem;
    word-wrap: break-word;
    cursor: pointer;
}

.list-items li:last-of-type {
    margin-bottom: 0;
}

.list-items li:hover {
    background-color: #eee;
}

</style>
