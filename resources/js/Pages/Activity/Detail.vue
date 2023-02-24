<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import TaskList from '@/Pages/Task/Index.vue';
import MoveTaskGroupForm from '@/Pages/TaskGroup/MoveForm.vue';
import { reactive, ref, onBeforeMount, watch, markRaw } from 'vue';
import TaskGroupForm from '@/Pages/TaskGroup/Form.vue';
import axios from 'axios';
import { ElMessage} from 'element-plus';
import { ElMessageBox } from 'element-plus';
import {
  Delete,
  CopyDocument,
  Files,
  Folder,
  Switch,
  Rank,
MoreFilled,
} from '@element-plus/icons-vue';


const props = defineProps({
    activity: Object,
    departments: Array,
    activityId: Number,
});
console.log(props.activity.name)
const showFormTask = ref(false);
const showFormTaskGroup = ref(false);
const showFormMoveTaskGroup=ref(false);

const state  = reactive({
    activityId: props.activityId,
    task: {
        name: "",
        description: "",
        task_group_id: ""
    },
    moveTaskGroupId:0,
})

const taskGroups = ref(props.taskGroups);
const loading = ref(true);

const createTaskForm = (currentTask) => {
    showFormTask.value = true;
    state.task = currentTask
}

const closeFormTask = (value) => {
    showFormTask.value = value;
}

const createTaskGroupForm = (currentActivityId) => {
    showFormTaskGroup.value = true;
    state.activityId = currentActivityId;
}
const closeFormTaskGroup = (value) => {
    showFormTaskGroup.value = value;
}

const createMoveTaskGroupForm = (currentActivityId,moveTaskGroupId) => {
    showFormMoveTaskGroup.value = true;
    state.activityId = currentActivityId;
    state.moveTaskGroupId = moveTaskGroupId;
}

const closeFormMoveTaskGroup = (value) => {
    showFormMoveTaskGroup.value = value;
}

watch(showFormTask, () => {
    getGroupsTask()
})

//Handle TaskGroup
function getTaskGroups(id)
{
  axios.get(`/taskgroup/list/${id}`).then(res => {
          taskGroups.value = res.data;
        }).catch(err => {
           ElMessage({
                showClose: true,
                message: err.response.data.message,
                type: 'error',
                })
            })
            loading.value=false;
}

async function editTaskGroup(id){
    loading.value=true;
     await axios.patch(`/taskgroup/${id}`,{'name':event.target.innerText}).then(res => {
        if (res.data.status) {
                    ElMessage({
                        showClose: true,
                        message: 'Sửa tên taskgroup thành công',
                        type: 'success',
                    })
                }
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
            getTaskGroups(state.activityId);
}

async function deleteTaskGroup(id)
{
    ElMessageBox.confirm(
    'It will permanently delete this task group . Continue?',
    'Warning',
    {
      type: 'warning',
      icon: markRaw(Delete),
      confirmButtonText: 'Confirm',
      cancelButtonText: 'Cancel',
    }
  )
  .then(() => {
    loading.value=true;
    axios.delete(`/taskgroup/${id}`).then(res => {
        if (res.data.status) {
              ElMessage({
                        showClose: true,
                        message: 'Delete taskgroup successfully',
                        type: 'success',
                    })
        }
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
            getTaskGroups(state.activityId);
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

async function copyTaskGroup(id)
{
    loading.value=true;
    await axios.get(`/taskgroup/copy/${id}`).then(res => {
        if (res.data.status) {
             ElMessage({
                        showClose: true,
                        message: 'Copy taskgroup successfully',
                        type: 'success',
                    })
                }
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
            getTaskGroups(state.activityId);
}

onBeforeMount(async () => {
    getTaskGroups(props.activityId);
});
</script>

<template>
    <div>
        <Head title="Activity" />

        <AuthenticatedLayout>
            <template #departen>
                <DepartenList :departments="departments" :activityId="activityId" />
            </template>
            <section class="lists-container" v-loading="loading">
                <div class="list" :key="index" v-for="(taskGroup, index) in taskGroups" >
                    <div class="list-group-title">
                        <h3 class="list-title" @focusout="editTaskGroup(taskGroup.id)" contenteditable >{{ taskGroup.name }}</h3>
                        <a @click="createTaskForm(taskGroup)" class="btn-add block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                            <i>Thêm</i>
                        </a>
                    </div>
                        <el-dropdown trigger="click">
                            <span class="el-dropdown-link ml-auto">
                                <el-icon class="position-absolute float-right mr-7  cursor-pointer" size="25"><MoreFilled /></el-icon>
                            </span>
                            <template #dropdown>
                            <el-dropdown-menu>
                                <el-dropdown-item :icon="CopyDocument" @click="copyTaskGroup(taskGroup.id)">Copy</el-dropdown-item>
                                <el-dropdown-item :icon="Rank" @click="createMoveTaskGroupForm(activityId, taskGroup.id)">Move</el-dropdown-item>
                                <el-dropdown-item :icon="Switch"> Move All Tasks</el-dropdown-item>
                                <el-dropdown-item :icon="Folder">Archive</el-dropdown-item>
                                <el-dropdown-item :icon="Files">Archive All Tasks</el-dropdown-item>
                                <el-dropdown-item :icon="Delete" @click="deleteTaskGroup(taskGroup.id)">Delete</el-dropdown-item>
                            </el-dropdown-menu>
                            </template>
                        </el-dropdown>
                    <TaskList :tasks="taskGroup.tasks" />
                </div>
                <button class="add-list-btn btn" @click="createTaskGroupForm(activityId)">Thêm nhóm công việc </button>
            </section>
        </AuthenticatedLayout>
    </div>
    <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
    <TaskGroupForm  v-if="showFormTaskGroup" :getTaskGroups="getTaskGroups" :activityId="activityId" :isShowModal="showFormTaskGroup" v-on:closeModal="closeFormTaskGroup" />
    <MoveTaskGroupForm v-if="showFormMoveTaskGroup" :getTaskGroups="getTaskGroups" :activityId="activityId" :moveTaskGroupId="state.moveTaskGroupId" :taskGroups="taskGroups" :isShowModal="showFormMoveTaskGroup" v-on:closeModal="closeFormMoveTaskGroup" />
</template>

<style scoped>
/* Lists */
.list-group-title{
    display: flex;
    align-items: center;
}
.list-group-title a{
    margin-right: 26px;
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
    margin-left: auto;
    background-color: #cdd2d4;
}

.btn-add:hover {
    background-color: white;
    cursor: pointer;
}

@supports (display: grid) {
    .lists-container {
        display: grid;
        grid-auto-columns: 18rem;
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
