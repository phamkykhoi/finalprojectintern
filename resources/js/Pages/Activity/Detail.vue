<script setup>

import SettingIcon from '@/Components/Icons/SettingIcon.vue';
import DepartenUserForm from '@/Pages/Departen/User.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import PlusIcon from '@/Components/Icons/PlusIcon.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskList from '@/Pages/Task/Index.vue';
import { reactive, ref } from 'vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

defineProps({
    departments: Array,
    taskGroups: Array,
    activityId: Number,
});

const ValidateForm = reactive({
    name: '',
    description: '',
    task_id: 1,
})

const showFormTask = ref(false);
const state  = reactive({
    task: null
})

const createTaskForm = (currentTask) => {
    showFormTask.value = true;
    state.task = currentTask
}

const closeFormTask = (value) => {
    showFormTask.value = value;
}
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
                    <div class="list-group-title">
                        <h3 class="list-title">{{ taskGroup.name }}</h3>
                        <a @click="createTaskForm(task)" class="btn-add block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                            <i>Thêm</i>
                        </a>
                    </div>
                    <TaskList :tasks="taskGroup.tasks" />
                </div>
                <button class="add-list-btn btn">Thêm nhóm công việc</button>
            </section>
            <!-- End of lists container -->

        </AuthenticatedLayout>
    </div>
    <TaskForm v-if="showFormTask" :taskId="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask">
        <template v-slot:taskForm>
            <form @submit.prevent="saveTask()" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Tạo công việc
                    </h5>
                </div>
                
                <div class="modal-body relative p-4">
                    <div>
                        <el-form
                            ref="formRef"
                            :model="ValidateForm"
                            label-width="110px"
                            class="demo-ruleForm"
>
                            <el-form-item
                                label="Tên công việc"
                                prop="name"
                                :rules="[
                                    { required: true, message: 'name is required' },
                                ]"
                                >
                                <el-input
                                    v-model="ValidateForm.name"
                                    type="text"
                                    autocomplete="off"
                                />
                            </el-form-item>
                            <el-form-item
                                label="Mô tả công việc"
                                prop="description"
                                >
                                <el-input
                                    v-model="ValidateForm.description"
                                    type="text"
                                    autocomplete="off"
                                />
                            </el-form-item>
                        </el-form>
                    </div>
                </div>
            </form>
        </template>
    </TaskForm>
</template>

<style scoped>
/* Lists */
.list-group-title{
    display: flex;
    align-items: center;
}
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
.btn-add {
    max-width: 100px;
    height: fit-content;
    margin-left: 125px;
    background-color: #cdd2d4;
}

.btn-add:hover {
    background-color: white;
    cursor: pointer;
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