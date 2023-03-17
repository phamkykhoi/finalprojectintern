<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import TaskList from '@/Pages/Task/Index.vue';
import TaskGroupInfo from '@/Pages/TaskGroup/TaskGroupInfo.vue';
import SortTaskGroup from '@/Pages/TaskGroup/SortTaskGroup.vue';
import ActionTaskGroup from '@/Pages/TaskGroup/ActionTaskGroup.vue';
import { reactive, ref, onBeforeMount, watch, unref, markRaw, provide } from 'vue';
import {
    InfoFilled, DCaret, MoreFilled, Plus, EditPen, Files,
    CopyDocument, Switch, Rank, TakeawayBox, Delete, Folder,
    CaretTop, CaretBottom, Select, CircleClose
} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox, ElMessage } from 'element-plus';
import request from '../../utils/request';
import TaskGroupAction from '@/Components/TaskGroupAction.vue';

const props = defineProps({
    activity: Object,
    activityId: Number,
});

const departments = ref([]);

async function getDepartment() {
    await request.get(`/api/department`).then((res) => {
        departments.value = res.data.result.departments
    })
}

getDepartment()

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

const taskGroups = ref([]);

const loading = ref(true);

async function getGroupsTask() {
    await request.get(`/api/activity/${props.activityId}`).then((res) => {
        taskGroups.value = res.data.result.taskGroups
    })
}

provide('getGroupsTask', getGroupsTask)
provide('getDepartment', getDepartment)

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

const popoverRef = ref([])
const popoverInfoTaskGroup = () => {
    unref(popoverRef).popperRef?.delayHide?.()
}

const popoverRef1 = ref([])
const popoverSort = () => {
    unref(popoverRef1).popperRef1?.delayHide?.()
}

const popoverRef2 = ref([])
const popoverOption = () => {
    unref(popoverRef2).popperRef?.delayHide?.()
}

const copyJobGroup = ref()
const popoverCopy = () => {
  unref(copyJobGroup).popperRef?.delayHide?.()
}

const moveJobGroup = ref()
const popoverMove= () => {
  unref(moveJobGroup).popperRef?.delayHide?.()
}

const moveAllTheWork = ref()
const popoverMoveAll= () => {
  unref(moveAllTheWork).popperRef?.delayHide?.()
}

const storeTaskGroup = ref()
const popoverstoreTaskGroup= () => {
  unref(popoverstoreTaskGroup).popperRef?.delayHide?.()
}

const storeAllWorkInGroup = ref()
const popoverstoreAllWorkInGroup= () => {
  unref(popoverstoreAllWorkInGroup).popperRef?.delayHide?.()
}

const popoverDeleteTaskGroup= () => {
  unref(popoverDeleteTaskGroup).popperRef?.delayHide?.()
}

const dialog = reactive({
        popoverAction: false,
        dialogCopy: false,
        dialogMove: false,
        dialogMoveAll: false,
        dialogStore: false,
        dialogStoreAllWork: false,
        dialogDelete: false,
        addNewTask: false,
        addTaskGroup: false,
        editNameTaskGroup: [false],
        input:'',
});

const temp = reactive({
    editTaskGroupName:[''],
    addTaskGroup:'',
})

const taskGroupForm = reactive({
    name: '',
    description:'abc',
    activity_id: props.activityId,
    type:1,
})

const toggleChildPopover = () => {
    copyJobGroup.value = !copyJobGroup.value;
};

const showParentPopover = () => {
    if (!copyJobGroup.value) {
        popoverRef2.value.doShow();
    }
};

const hideParentPopover = () => {
    if (!childPopoverVisible.value) {
        popoverRef2.value.doClose();
    }
};

//Handle TaskGroup
function createTaskGroup(){
    request.post('/taskgroup/', taskGroupForm).then(res => {
                ElMessage({
                    showClose: true,
                    message: 'Add taskgroup successfully',
                    type: 'success',
                })
                getTaskGroups(state.activityId);
                dialog.addTaskGroup = false;
                taskGroupForm.name = "";
            }).catch(err => {
                ElMessage({
                    showClose: true,
                    message: err.response.data.message,
                    type: 'error',
                })
            })
}

function getTaskGroups(id)
{
    request.get(`/taskgroup/list/${id}`)
        .then((res) => {
            taskGroups.value = res.data.result.taskGroups;
        }).catch(err => {
           ElMessage({
                showClose: true,
                message: err.response.data.message,
                type: 'error',
                })
            })
            loading.value=false;
}
async function editTaskGroup(id, newTaskGroupName, index){
    loading.value = true;
     await request.put(`/taskgroup/${id}`,{'name':newTaskGroupName}).then(res => {
        if (res.data.status) {
            ElMessage({
                showClose: true,
                message: 'Sửa tên taskgroup thành công',
                type: 'success',
            })
        }
        getTaskGroups(state.activityId);
        dialog.editNameTaskGroup[index] = false;
    }).catch(err => {
        ElMessage({
            showClose: true,
            message: err.response.data.message,
            type: 'error',
        })
    })
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
    request.delete(`/taskgroup/${id}`).then(res => {
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
    await request.get(`/taskgroup/copy/${id}`).then(res => {
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

const popoverVisible = ref([false]);
const openPopoverAction = (index) => {
    popoverVisible.value[index] = !popoverVisible.value[index];
};

function closePopoverAction() {
    popoverVisible.value = false
}
 function clickEditNameTaskGroup(index, taskGroupName) {
    temp.editTaskGroupName[index] = taskGroupName;
    dialog.editNameTaskGroup[index] = true
};

function openDialogAddTask(currentTask){
    showFormTask.value = true;
    state.task = currentTask
}

function closeTaskGroupName(index){
    dialog.editNameTaskGroup[index] = false
}
</script>

<template>
    <div>
        <Head title="Activity"/>

        <AuthenticatedLayout>
            <template #departen>
                <DepartenList :departments="departments" :activityId="activityId" />
            </template>
            <section class="lists-container">
                 <div :key="index" v-for="(taskGroup, index) in taskGroups">
                    <el-card class="box-card">
                        <template #header>
                            <div class="card-header" v-if="!dialog.editNameTaskGroup[index]">
                                <el-col>
                                    <span @click="clickEditNameTaskGroup(index, taskGroup.name)">
                                        {{ taskGroup.name }}
                                    </span>
                                    <div class="group-icons">
                                        <el-button v-popover="popoverRef[index]" v-click-outside="popoverInfoTaskGroup" :icon="InfoFilled" circle/>
                                        <el-button v-popover="popoverRef1[index]" v-click-outside="popoverSort" :icon="DCaret" circle/>
                                        <TaskGroupAction @open-dialog-add-task="openDialogAddTask(taskGroup)"
                                        @refreshTaskGroups="clickEditNameTaskGroup(index, taskGroup.name)"
                                        />
                                        <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
                                        <el-button @click="hidePopoverAction(index)" style="display: none;"/>
                                    </div>
                                </el-col>
                            </div>
                            <el-form v-if="dialog.editNameTaskGroup[index]">
                                <el-row>
                                    <el-input
                                    clearable
                                    v-model="temp.editTaskGroupName[index] "
                                    type="text"
                                    />
                                </el-row>
                                <div style="margin: 10px 0" />
                                <div style="margin: 5px 0 10px 0" />
                                <el-row>
                                    <el-button type="success" @click="editTaskGroup(taskGroup.id, temp.editTaskGroupName[index], index)">Lưu</el-button>
                                    <el-button @click="closeTaskGroupName(index)" style="margin-left: 10px;">x</el-button>

                                </el-row>
                            </el-form>
                        </template>
                        <TaskList :tasks="taskGroup.tasks"  :task_group_id="taskGroup.id" :taskGroup="taskGroup" :activity="props.activity" :getGroupsTask="getGroupsTask"/>
                        <el-button class="button"  @click="createTaskForm(taskGroup)" text>
                            <el-icon><Plus /></el-icon>Thêm mới công việc
                        </el-button>
                    </el-card>

                    <el-popover
                        :ref="ref => popoverRef[index] = ref"
                        :title="taskGroup.name"
                        virtual-triggering
                        persistent
                        width="300px"
                    >
                        <hr>
                        <TaskGroupInfo :task_group_id="taskGroup.id" :task_group_created_by="taskGroup.created_by"/>
                    </el-popover>
                    <el-popover
                        :ref="ref => popoverRef1[index] = ref"
                        title="SẮP XẾP THEO"
                        virtual-triggering
                        persistent
                        width="300px"
                        trigger="click"
                    >
                        <SortTaskGroup />
                    </el-popover>
                        <ActionTaskGroup :idTaskGroup="index" :taskGroup="taskGroup" :visible="dialog.popoverAction"
                            :state="state" :popperRef="popoverRef" :popoverRef2="popoverRef2" :editNameTaskGroup="dialog.editNameTaskGroup"
                            @open-dialog-add-task-group="openDialogAddTaskGroup" @open-dialog-add-task="openDialogAddTask(taskGroup)"
                            @refreshTaskGroups="clickEditNameTaskGroup(index, taskGroup.name)"
                            @close-popover-action="closePopoverAction" :popoverAction="dialog.popoverAction"
                        />
                </div>

                <el-button
                    class="add-list-btn btn"
                    style="place-content: baseline; background: gainsboro;"
                    @click="dialog.addTaskGroup = true" v-if="!dialog.addTaskGroup"
                >
                    <el-icon><Plus /></el-icon>Tạo nhóm công việc
                </el-button>
                <el-form v-if="dialog.addTaskGroup">
                    <el-row>
                        <el-input autosize
                        v-model="taskGroupForm.name"
                        type="textarea"
                        placeholder="Tạo nhóm công việc"
                        />
                    </el-row>
                    <div style="margin: 10px 0" />
                    <div style="margin: 5px 0 10px 0" />
                    <el-row>
                        <el-button type="success" @click="createTaskGroup">Tạo việc</el-button>
                        <el-button @click="dialog.addTaskGroup = false" style="margin-left: 10px;">x</el-button>
                    </el-row>
                </el-form>
            </section>
        </AuthenticatedLayout>
    </div>
    <TaskForm v-if="showFormTask" :getGroupsTask="getGroupsTask" :activityId="activityId" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
    <TaskGroupForm  v-if="showFormTaskGroup" :getTaskGroups="getTaskGroups" :activityId="activityId" :isShowModal="showFormTaskGroup" v-on:closeModal="closeFormTaskGroup" />
    <MoveTaskGroupForm v-if="showFormMoveTaskGroup" :getTaskGroups="getTaskGroups" :activityId="activityId" :moveTaskGroupId="state.moveTaskGroupId" :taskGroups="taskGroups" :isShowModal="showFormMoveTaskGroup" v-on:closeModal="closeFormMoveTaskGroup" />
</template>

<style scoped>
.card-header {
   position: relative;
}

.group-icons {
    position: absolute;
    right: 0px;
    top: 0px;
}

.group-icons .icon {
    margin-left: 0.2rem;
}

.el-button+.el-button {
    margin: 0;
}

.el-button.is-circle {
    border: none;
}

.el-popover .el-button {
    width: 100%;
    place-content: normal;
    border: none;
    border-radius: 0;
}

.select .el-select {
    width: 270px;
    margin-bottom: 20px;
}

.el-popover .select .el-button {
    place-content: center;
}

.title-dialog {
    font-size: 1.1rem;
}

.title-dialog .close {
    position: absolute;
    right: 15px;
    place-content: center;
    width: 20px;
    font-size: 1.1rem;
}

.el-checkbox {
    white-space: normal;
    overflow-wrap: break-word;
}

.icon-sort {
    line-height: 1.5rem;
}

.icon-sort .el-icon{
    color: green;
}

.icon-sort-small {
    font-size: 10px;
    line-height: 1.1rem;
    color: green;
    font-weight: bold;
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
