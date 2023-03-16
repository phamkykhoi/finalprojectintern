<script lang="ts" setup>

import TaskForm from '@/Pages/Task/Form.vue';
import AddTask from '@/Components/TaskGroupAction/AddTask.vue';
import EditName from '@/Components/TaskGroupAction/EditName.vue';
import AddGroup from '@/Components/TaskGroupAction/AddGroup.vue';
import Copy from '@/Components/TaskGroupAction/Copy.vue';
import DeleteTaskGroup from '@/Components/TaskGroupAction/Delete.vue';
import Move from '@/Components/TaskGroupAction/Move.vue';
import MoveAll from '@/Components/TaskGroupAction/MoveAll.vue';
import Save from '@/Components/TaskGroupAction/Save.vue';
import SaveAll from '@/Components/TaskGroupAction/SaveAll.vue';
import { reactive, ref, unref, defineProps, defineEmits } from 'vue';
import { Plus, EditPen, CopyDocument, Switch, Rank, TakeawayBox, Delete, MoreFilled} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox, ElMessage } from 'element-plus';
import request from '../utils/request';

const props = defineProps({
    idTaskGroup: Number,
    state: Object,
    taskGroup: Object,
    taskGroups: Object,
    editNameTaskGroup: Array,
    popoverAction: Array,
    dialogAddTaskGroup: Boolean,
    popperRef: {
      type: Object, 
      required: true
    },
    visible: Boolean,
    popoverRef2: Object,

});

const indexTaskGroup = props.idTaskGroup
const dialogVisible = ref(false)
const poppveraddNewTask = ref()
const popoveraddNewTask = () => {
  unref(poppveraddNewTask).popperRef?.delayHide?.()
}

const dialog = reactive({
    popoverAction: false,
    dialogVisible: false,
    dialogCopy: false,
    dialogMove: false,
    dialogMoveAll: false,
    dialogStore: false,
    dialogStoreAllWork: false,
    dialogDelete: false,
    addTaskGroup: false,
    addNewTask: false,
    input:'',
});

const title = reactive({
    addTask: 'Thêm mới công việc',
    editName: 'Hiệu chỉnh nhóm việc',
    addTaskGroup: 'Tạo nhóm công việc',
    copy: 'Sao chép nhóm công việc',
    move: 'Di chuyển nhóm công việc',
    moveAll: 'Di chuyển toàn bộ công việc trong nhóm',
    save: 'Lưu trữ nhóm việc',
    saveAll: 'Lưu trữ toàn bộ việc trong nhóm',
    delete: 'Xóa nhóm việc',
});

const showFormTask = ref(false);

const closeFormTask = (value) => {
    showFormTask.value = value;
}
const createTaskForm = (currentTask) => {
    showFormTask.value = true;
    props.state.task = currentTask
}

const popoverVisible = ref(false);
const openPopoverAction = (index) => {
    popoverVisible.value[index] = !popoverVisible.value[index];
};

function visibleAction(idTaskGroup) {
    popoverVisible.value[idTaskGroup] = true;
   
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
const emit = defineEmits(['open-dialog-add-task', 'refreshTaskGroups'])
function openDialogAddTask() {
    emit('open-dialog-add-task');
}

function openDialogAddTaskGroup() {
    dialog.addTaskGroup = true
}

function openAction() {
    dialog.addNewTask = true
}

function showParentPopover() {
    popoverVisible.value = true
}
function handleTaskGroupName(){
    emit('refreshTaskGroups');
}
</script>
<template>
    <el-dropdown size="small" trigger="click">
        <el-button :icon="MoreFilled" circle/>
        <template #dropdown>
            <el-dropdown-menu>
                <el-dropdown-item >
                    <AddTask :icon="Plus" :title="title.addTask" @click="openDialogAddTask"/>
                </el-dropdown-item>
                <el-dropdown-item>
                    <EditName :icon="EditPen" @click="handleTaskGroupName()" :title="title.editName" :editNameTaskGroup="props.editNameTaskGroup" :idTaskGroup="props.idTaskGroup"/>
                </el-dropdown-item>
                <el-dropdown-item divided>
                    <AddGroup :icon="Plus" :title="title.addTaskGroup" @open-dialog-add-task-group="openDialogAddTaskGroup"/>
                </el-dropdown-item>
                <el-dropdown-item>
                    <Copy :icon="CopyDocument" :title="title.copy" @show-parent-popover="showParentPopover"/>
                </el-dropdown-item>
                <el-dropdown-item>
                    <Move :icon="Switch" :title="title.move"/>
                </el-dropdown-item>
                <el-dropdown-item>
                    <MoveAll :icon="Rank" :title="title.moveAll"/>
                </el-dropdown-item>
                <el-dropdown-item divided>
                    <Save :icon="TakeawayBox" :title="title.save"/>
                </el-dropdown-item>
                <el-dropdown-item>
                    <SaveAll :icon="TakeawayBox" :title="title.saveAll"/>
                </el-dropdown-item>
                <el-dropdown-item divided>
                    <DeleteTaskGroup :icon="Delete" :title="title.delete"/>
                </el-dropdown-item>
            </el-dropdown-menu>
        </template>
    </el-dropdown>
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

.el-button.is-circle,
.btn-item {
    border: none;
}

.el-button {
    width: 100%;
    place-content: normal;
    border: none;
    border-radius: 0;
}

.select .el-select {
    width: 270px;
    margin-bottom: 20px;
}

.select .el-button {
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
