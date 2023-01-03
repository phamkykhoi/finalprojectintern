<script setup>

import SettingIcon from '@/Components/Icons/SettingIcon.vue';
import PlusIcon from '@/Components/Icons/PlusIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import { Link } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';

defineProps({
    tasks: Array,
});

</script>

<template>
    <ul class="list-items" :key="index" v-for="(task, index) in tasks">
        <li>{{  task.name }}</li>
    </ul>
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