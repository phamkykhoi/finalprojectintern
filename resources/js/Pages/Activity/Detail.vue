<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import TaskList from '@/Pages/Task/Index.vue';
import TaskGroupInfo from '@/Pages/TaskGroup/TaskGroupInfo.vue';
import SortTagGroup from '@/Pages/TaskGroup/SortTagGroup.vue';
import ActionTagGroup from '@/Pages/TaskGroup/ActionTagGroup.vue';
import MoveTaskGroupForm from '@/Pages/TaskGroup/MoveForm.vue';
import TaskGroupForm from '@/Pages/TaskGroup/Form.vue';
import { reactive, ref, onBeforeMount, watch, unref, markRaw } from 'vue';
import { 
    InfoFilled, DCaret, MoreFilled, Plus, EditPen, Files,
    CopyDocument, Switch, Rank, TakeawayBox, Delete, Folder,
    CaretTop, CaretBottom, Select, CircleClose 
} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox, ElMessage } from 'element-plus';
import axios from 'axios';
// import { ta } from 'element-plus/es/locale';

const props = defineProps({
    activity: Object,
    departments: Array,
    activityId: Number,
});

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

const taskGroups = ref();
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

// const deleteTaskGroup = ref()
const popoverDeleteTaskGroup= () => {
  unref(popoverDeleteTaskGroup).popperRef?.delayHide?.()
}

const dialog = reactive({
    //    dialogVisible: false,
        popoverAction: false,
        dialogCopy: false,
        dialogMove: false,
        dialogMoveAll: false,
        dialogStore: false,
        dialogStoreAllWork: false,
        dialogDelete: false,
        addTaskGroup: false,
        editNameTaskGroup: [false],
        input:'',
});

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
                                    <span @click="dialog.editNameTaskGroup[index] = true">
                                        {{ taskGroup.name }}
                                    </span>
                                    <div class="group-icons">
                                        <el-button v-popover="popoverRef[index]" v-click-outside="popoverInfoTaskGroup" :icon="InfoFilled" circle/>
                                        <el-button v-popover="popoverRef1[index]" v-click-outside="popoverSort" :icon="DCaret" circle/>
                                        <el-button v-popover="popoverRef2[index]" @click="dialog.popoverAction = !dialog.popoverAction"  v-click-outside="popoverOption" :icon="MoreFilled" circle/>
                                    </div>
                                </el-col>
                            </div>
                            <el-form v-if="dialog.editNameTaskGroup[index]">
                                <el-row>
                                    <el-input autosize
                                    v-model="taskGroup.name"
                                    type="textarea"
                                    />
                                </el-row>
                                <div style="margin: 10px 0" />
                                <div style="margin: 5px 0 10px 0" />
                                <el-row> 
                                    <el-button type="success">Lưu</el-button>
                                    <el-button @click="dialog.editNameTaskGroup[index] = false" style="margin-left: 10px;">x</el-button>
                                </el-row>
                            </el-form>
                        </template>

                        <TaskList :tasks="taskGroup.tasks" />
                        <el-button class="button"  @click="createTaskForm(taskGroup)" text>
                            <el-icon><Plus /></el-icon>Thêm mới công việc
                        </el-button>
                    </el-card> 
        
                    <div>
                        <el-popover 
                        :ref="ref => popoverRef[index] = ref"
                        title="taskGroup1"
                        virtual-triggering
                        persistent
                        width="300px"
                        >
                            <hr>
                            <TaskGroupInfo  />
                        </el-popover>
                    </div> 

                    <el-popover
                        :ref="ref => popoverRef1[index] = ref"
                        title="SẮP XẾP THEO"
                        virtual-triggering
                        persistent
                        width="300px"
                        trigger="click"
                    >
                        <SortTagGroup />
                    </el-popover>
        
                    <el-popover
                        :ref="ref => popoverRef2[index] = ref"
                        :visible="dialog.popoverAction"
                        virtual-triggering
                        persistent
                        width="300px"
                        trigger="click"
                    >
                        <ActionTagGroup :idTaskGroup="index" :taskGroup="taskGroup" 
                        :state="state" :popperRef="popoverRef"/>
                    </el-popover>
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
                        v-model="input"
                        type="textarea"
                        placeholder="Tạo nhóm công việc"
                        />
                    </el-row>
                    <div style="margin: 10px 0" />
                    <div style="margin: 5px 0 10px 0" />
                    <el-row> 
                        <el-button type="success">Tạo việc</el-button>
                        <el-button @click="dialog.addTaskGroup = false" style="margin-left: 10px;">x</el-button>
                    </el-row>
                </el-form>
            </section>
        </AuthenticatedLayout>

        <el-dialog
            v-model="dialog.dialogVisible"
            title="Tạo nhóm công việc"
            width="30%"
        >
            <input type="text" name="" placeholder="Nhập tên nhóm công việc" style="width: 100%; border-radius: 8px;">
            <template #footer>
            <span class="dialog-footer">
                <el-button style="margin-right: 10px;" @click="dialog.dialogVisible = false">Đóng</el-button>
                <el-button type="primary" @click="dialog.dialogVisible = false">Lưu</el-button>
            </span>
            </template>
        </el-dialog>
    </div>
    <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
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
