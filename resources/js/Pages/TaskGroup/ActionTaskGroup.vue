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
import { reactive, ref, unref, defineProps } from 'vue';
import { Plus, EditPen, CopyDocument, Switch, Rank, TakeawayBox, Delete} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox, ElMessage } from 'element-plus';
import request from '../../utils/request';

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

function openDialogAddTask() {
    dialog.addNewTask = true
}

function openDialogAddTaskGroup() {
    dialog.addTaskGroup = true
}

function openAction() {
    dialog.addNewTask = true
}

function showParentPopover() {
    popoverVisible.value = true
    console.log(popoverVisible.value)
}
</script>
<template>
    <el-popover
        :ref="ref => popoverRef2[props.idTaskGroup] = ref"
        visible="popoverVisible"
        virtual-triggering
        persistent
        width="320px"
        trigger="click"
    >
        <AddTask :icon="Plus" :title="title.addTask"  @open-dialog-add-task="openDialogAddTask"/>
        <EditName :icon="EditPen" :title="title.editName" :editNameTaskGroup="props.editNameTaskGroup" :idTaskGroup="props.idTaskGroup"/>
        <hr>
        <AddGroup :icon="Plus" :title="title.addTaskGroup" @open-dialog-add-task-group="openDialogAddTaskGroup"/>
        <Copy :icon="CopyDocument" :title="title.copy" @show-parent-popover="showParentPopover"/>
        <Move :icon="Switch" :title="title.move"/>
        <MoveAll :icon="Rank" :title="title.moveAll"/>
        <hr/>
        <Save :icon="TakeawayBox" :title="title.save"/>
        <SaveAll :icon="TakeawayBox" :title="title.saveAll"/>
        <hr/>
        <DeleteTaskGroup :icon="Delete" :title="title.delete"/>

        <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
    </el-popover>

    <el-dialog
        v-model="dialog.addTaskGroup"
        title="Tạo nhóm công việc"
        width="30%"
    >
        <input type="text" name="" placeholder="Nhập tên nhóm công việc" style="width: 100%; border-radius: 8px;">
        <template #footer>
        <span class="dialog-footer">
            <el-button style="margin-right: 10px;" @click="dialog.addTaskGroup = false">Đóng</el-button>
            <el-button type="primary" @click="dialog.addTaskGroup = false">Lưu</el-button>
        </span>
        </template>
    </el-dialog>
    <el-dialog
        v-model="dialog.addNewTask"
        title="Thêm mới công việc"
        width="50%"
    >
        <el-row>
            <el-col>Tên công việc</el-col>
            <el-input v-model="input" placeholder="Nhập tên công việc" />
        </el-row>
        <el-row>
            <el-col>Mô tả</el-col>
            <el-input v-model="input" :rows="3" type="textarea" placeholder="Nhập mô tả"/>
        </el-row>
        
        <template #footer>
        <span class="dialog-footer">
            <el-button style="margin-right: 10px;" @click="dialog.addNewTask = false">Đóng</el-button>
            <el-button type="primary" @click="dialog.addNewTask = false">Lưu</el-button>
        </span>
        </template>
    </el-dialog>
</template>
<style>
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