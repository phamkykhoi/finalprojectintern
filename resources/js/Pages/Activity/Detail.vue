<script setup>

import SettingIcon from '@/Components/Icons/SettingIcon.vue';
import PlusIcon from '@/Components/Icons/PlusIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskList from '@/Pages/Task/Index.vue';

defineProps({
    departments: Array,
    taskGroups: Array,
    activityId: Number,
});


</script>

<template>
    <div>
        <Head title="Activity" />

        <AuthenticatedLayout>
            <template #departen>
                <DepartenList :departments="departments" :activityId="activityId" />
            </template>
            <!-- Lists container -->
            <section class="lists-container">
                <div class="list" :key="index" v-for="(taskGroup, index) in taskGroups">
                    <h3 class="list-title">{{ taskGroup.name }}</h3>
                    <TaskList :tasks="taskGroup.tasks" />
                </div>
                <button class="add-list-btn btn">Thêm nhóm công việc</button>
            </section>
            <!-- End of lists container -->
        </AuthenticatedLayout>
    </div>
</template>

<style scoped>
/* Lists */
.lists-container::-webkit-scrollbar {
    height: .4rem;
}

.lists-container::-webkit-scrollbar-thumb {
    background-color: #66a3c7;
    border-top-width: 0;
}

.lists-container {
    display: flex;
    align-items: start;
    padding: 0.8rem;
    overflow-x: auto;
    height: calc(100vh - 6rem);
}

.list {
    flex: 0 0 27rem;
    display: flex;
    flex-direction: column;
    background-color: #e2e4e6;
    max-height: calc(100vh - .8rem);
    border-radius: 0.3rem;
    margin-right: 1rem;
}

.list:last-of-type {
    margin-right: 0;
}

.list-title {
    font-size: 1.2rem;
    font-weight: 700;
    color: #333;
    padding: 1rem;
}

.add-card-btn {
    display: block;
    font-size: 1.4rem;
    font-weight: 400;
    color: #838c91;
    padding: 1rem;
    text-align: left;
    cursor: pointer;
}

.add-card-btn:hover {
    background-color: #cdd2d4;
    color: #4d4d4d;
    text-decoration: underline;
}

.add-list-btn {
    flex: 0 0 27rem;
    display: block;
    font-size: 1rem;
    font-weight: 400;
    background-color: #a5cae0;
    padding: 0.5rem;
    border-radius: 0.3rem;
    cursor: pointer;
    transition: background-color 150ms;
    text-align: left;
    max-width: 200px;
}

.add-list-btn:hover {
    font-weight: bold;
}

.add-card-btn::after,
.add-list-btn::after {
    content: '...';
}

@supports (display: grid) {
    .lists-container {
        display: grid;
        grid-auto-columns: 27rem;
        grid-auto-flow: column;
        grid-column-gap: 1rem;
    }

    .list {
        display: grid;
        grid-template-rows: auto minmax(auto, 1fr) auto;
    }

    .list-items {
        display: grid;
        grid-row-gap: 0.6rem;
    }

    .logo,
    .list,
    .list-items li,
    .boards-btn,
    .board-info-bar,
    .board-controls .btn,
    .user-settings-btn {
        margin: 0;
    }
}
</style>