<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import TaskList from '@/Pages/Task/Index.vue';
import MoveTaskGroupForm from '@/Pages/TaskGroup/MoveForm.vue';
import TaskGroupForm from '@/Pages/TaskGroup/Form.vue';
import { reactive, ref, onBeforeMount, watch, unref, markRaw } from 'vue';
import { 
    InfoFilled, DCaret, MoreFilled, Plus, EditPen, Files,
    CopyDocument, Switch, Rank, TakeawayBox, Delete, Folder,
    CaretTop, CaretBottom, Select, CircleClose 
} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox  } from 'element-plus';
import axios from 'axios';
import { ElMessage} from 'element-plus';

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
       dialogVisible: false,
       dialogCopy: false,
       dialogMove: false,
       dialogMoveAll: false,
       dialogStore: false,
       dialogStoreAllWork: false,
       dialogDelete: false,
       addTaskGroup: false,
       editNameTaskGroup: [false],
       showIconSort: [false],
       showIcon: [false],
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
                                    <span @click="dialog.editNameTaskGroup[index] = true">{{ taskGroup.name }}</span>
                                    <div class="group-icons">
                                        <el-button v-popover="popoverRef[index]" v-click-outside="popoverInfoTaskGroup" :icon="InfoFilled" circle/>
                                        <el-button v-popover="popoverRef1[index]" v-click-outside="popoverSort" :icon="DCaret" circle/>
                                        <el-button v-popover="popoverRef2[index]" v-click-outside="popoverOption" :icon="MoreFilled" circle/>
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

                    <el-popover 
                        :ref="ref => popoverRef[index] = ref"
                        title="taskGroup1"
                        virtual-triggering
                        persistent
                        width="300px"
                    >
                        <hr>
                        <el-row>
                            <el-col :span="18">Người tạo</el-col>
                            <el-col :span="6">User01</el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="18">Tổng số việc</el-col>
                            <el-col :span="6">0</el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="18">Đang làm</el-col>
                            <el-col :span="6">0</el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="18">Chưa lên lịch</el-col>
                            <el-col :span="6">0</el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="18">Quá hạn</el-col>
                            <el-col :span="6">0</el-col>
                        </el-row>
                        <el-row>
                            <el-col :span="18">Hoàn thành</el-col>
                            <el-col :span="6">0</el-col>
                        </el-row>
                    </el-popover>

                    <el-popover
                        :ref="ref => popoverRef1[index] = ref"
                        title="SẮP XẾP THEO"
                        virtual-triggering
                        persistent
                        width="300px"
                        trigger="click"
                    >
                        <div>
                            <el-row>
                                <el-col class="icon-sort-small" :span="12">
                                    <el-row v-if="dialog.showIcon[3]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[3] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày hòan thành</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[3] = !dialog.showIconSort[3]">
                                            <el-icon v-if="dialog.showIconSort[3]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[3]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="dialog.showIcon[5]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[5] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày thực hiện</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[5] = !dialog.showIconSort[5]">
                                            <el-icon v-if="dialog.showIconSort[5]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[5]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="dialog.showIcon[1]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[1] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày bắt đầu</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[1] = !dialog.showIconSort[1]">
                                            <el-icon v-if="dialog.showIconSort[1]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[1]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                </el-col>
                                <el-col class="icon-sort-small" :span="12">
                                    <el-row v-if="dialog.showIcon[3]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[4] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày tạo</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[4] = !dialog.showIconSort[4]">
                                            <el-icon v-if="dialog.showIconSort[4]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[4]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="dialog.showIcon[2]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[2] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày kết thúc</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[2] = !dialog.showIconSort[2]">
                                            <el-icon v-if="dialog.showIconSort[2]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[2]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="dialog.showIcon[0]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="dialog.showIcon[0] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Tên công việc</el-col>
                                        <el-col :span="3" class="icon-small" @click="dialog.showIconSort[0] = !dialog.showIconSort[0]">
                                            <el-icon v-if="dialog.showIconSort[0]"><CaretTop /></el-icon>
                                            <el-icon v-if="!dialog.showIconSort[0]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>

                            <el-col>
                                <el-button @click="dialog.showIcon[0] = true" v-if="!dialog.showIcon[0]">Tên công việc</el-button>
                                <el-row v-if="dialog.showIcon[0]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[0] = !dialog.showIconSort[0]">
                                        <el-icon v-if="dialog.showIconSort[0]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[0]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Tên công việc</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[0] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="dialog.showIcon[1] = true" v-if="!dialog.showIcon[1]">Ngày bắt đầu</el-button>
                                <el-row v-if="dialog.showIcon[1]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[1] = !dialog.showIconSort[1]">
                                        <el-icon v-if="dialog.showIconSort[1]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[1]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày bắt đầu</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[1] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="dialog.showIcon[2] = true" v-if="!dialog.showIcon[2]">Ngày kết thúc</el-button>
                                <el-row v-if="dialog.showIcon[2]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[2] = !dialog.showIconSort[2]">
                                        <el-icon v-if="dialog.showIconSort[2]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[2]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày kết thúc</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[2] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="dialog.showIcon[3] = true" v-if="!dialog.showIcon[3]">Ngày hoàn thành</el-button>
                                <el-row v-if="dialog.showIcon[3]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[3] = !dialog.showIconSort[3]">
                                        <el-icon v-if="dialog.showIconSort[3]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[3]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày hoàn thành</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[3] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="dialog.showIcon[4] = true" v-if="!dialog.showIcon[4]">Ngày tạo</el-button>
                                <el-row v-if="dialog.showIcon[4]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[4] = !dialog.showIconSort[4]">
                                        <el-icon v-if="dialog.showIconSort[4]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[4]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày tạo</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[4] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="dialog.showIcon[5] = true" v-if="!dialog.showIcon[5]">Ngày thực hiện</el-button>
                                <el-row v-if="dialog.showIcon[5]">
                                    <el-col :span="2" class="icon-sort" @click="dialog.showIconSort[5] = !dialog.showIconSort[5]">
                                        <el-icon v-if="dialog.showIconSort[5]"><CaretTop /></el-icon>
                                        <el-icon v-if="!dialog.showIconSort[5]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày thực hiện</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="dialog.showIcon[5] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col> 
                            <el-col>
                                <el-button style="place-content: center;" type="danger" round>Mặc định theo kế hoạch</el-button>
                            </el-col>
                        </div>
                    </el-popover>
        
                    <el-popover
                        :ref="ref => popoverRef2[index] = ref"
                        virtual-triggering
                        persistent
                        width="300px"
                        trigger="click"
                    >
                        <el-button @click="createTaskForm(taskGroup)"
                            v-click-outside="popover" :icon="Plus" circle > 
                            Thêm mới công việc
                        </el-button>
                        <el-button @click="dialog.editNameTaskGroup[index] = true"
                            v-click-outside="popover" :icon="EditPen" circle>
                            Hiệu chỉnh nhóm công việc
                        </el-button>
                        <hr>
                        <el-button @click="dialog.dialogVisible = true"
                            v-click-outside="popover" :icon="Plus" circle>
                            Tạo nhóm công việc
                        </el-button>
                        <el-button  v-popover="copyJobGroup" @click="dialog.dialogCopy = true"
                            v-click-outside="popoverCopy" :icon="CopyDocument" circle>
                            Sao chép nhóm công việc
                        </el-button>
                        <el-button v-popover="moveJobGroup" @click="dialog.dialogMove = true"
                            v-click-outside="popoverMove" :icon="Switch" circle>
                            Di chuyển nhóm công việc
                        </el-button>
                        <el-button  v-popover="moveAllTheWork" @click="dialog.dialogMoveAll = true"
                            v-click-outside="popover" :icon="Rank" circle>
                            Di chuyển toàn bộ công việc trong nhóm
                        </el-button>
                        <hr>
                        <el-button v-popover="storeTaskGroup"  @click="dialog.dialogStore = true"
                            v-click-outside="popover" :icon="TakeawayBox" circle>
                            Lưu trữ nhóm việc
                        </el-button>
                        <el-button v-popover="storeAllWorkInGroup" @click="dialog.dialogStoreAllWork = true"
                            v-click-outside="popover" :icon="TakeawayBox" circle>
                            Lưu trữ toàn bộ việc trong nhóm
                        </el-button>
                        <hr>
                        <el-button v-popover="deleteTaskGroup" @click="dialog.dialogDelete = true"
                            v-click-outside="popover" :icon="Delete" circle>
                            Xóa nhóm việc
                        </el-button>
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
                        placeholder="Tạo việc con"
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

            <el-popover
                :visible="dialog.dialogCopy"
                ref="copyJobGroup"
                trigger="click"
                virtual-triggering
                width="300px"
                persistent
                @mouseenter="showParentPopover"
                @mouseleave="hideParentPopover"
            >
                <el-row class="title-dialog">
                    <el-col :span="18" class="title">
                        <el-form-item label="Sao chép nhóm việc"></el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button class="close" @click="dialog.dialogCopy = false">x</el-button>
                    </el-col>
                </el-row>
                <div class="select">
                    <p>Team</p>
                    <el-select v-model="value" placeholder="Chọn">
                        <el-option key="" label="" value="Team 1"
                        />
                    </el-select>        
                </div>
                <div class="select">
                    <p>Kế hoạch</p>
                    <el-select v-model="value" placeholder="Chọn">
                        <el-option key="" label="Kế hoạch" value=""
                        />
                    </el-select>
                </div>
                <div class="select">
                    <el-button type="success" @click="copyTaskGroup(taskGroup.id)">Sao chép</el-button>
                </div>
            </el-popover>

            <el-popover
                :visible="dialog.dialogMove"
                ref="moveJobGroup"
                trigger="click"
                virtual-triggering
                width="300px"
                persistent
            >
                <el-row class="title-dialog">
                    <el-col :span="18" class="title">
                        <el-form-item label="Di chuyển nhóm việc"></el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button class="close" @click="dialog.dialogMove = false">x</el-button>
                    </el-col>
                </el-row>
                <div class="select">
                    <p>Team</p>
                    <el-select v-model="value" placeholder="Chọn">
                        <el-option key="" label="" value="Team 1"
                        />
                    </el-select>        
                </div>
                <div class="select">
                    <p>Kế hoạch</p>
                    <el-select v-model="value" placeholder="Chọn">
                        <el-option key="" label="Kế hoạch" value=""
                        />
                    </el-select>
                </div>
                <div class="select">
                    <el-button type="success">Sao chép</el-button>
                </div>
            </el-popover>

            <el-popover
                :visible="dialog.dialogMoveAll"
                ref="moveAllTheWork"
                trigger="click"
                virtual-triggering
                width="350px"
                persistent
            >
                <el-row class="title-dialog">
                    <el-col :span="17" class="title">
                        <p>Di chuyển toàn bộ công việc trong nhóm việc</p>
                    </el-col>
                    <el-col :span="5">
                        <el-button class="close" @click="dialog.dialogMoveAll = false">x</el-button>
                    </el-col>
                </el-row>
                <el-row>
                    <el-col>
                        <div>Team</div>
                        <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                            <el-option key="" label="Team 1" value="Team 1"
                            />
                        </el-select>  
                    </el-col>
                </el-row>
                <el-row>
                    <el-col>
                        <div>Kế hoạch</div>
                        <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                            <el-option key="" label="Kế hoạch" value="Kế hoạch"
                            />
                        </el-select>  
                    </el-col>
                </el-row>
                <el-row>
                    <el-col>
                        <div>Nhóm việc</div>
                        <el-select v-model="value" placeholder="Chọn" style="width: 315px;">
                            <el-option key="" label="Nhóm việc" value="Nhóm việc"
                            />
                        </el-select>  
                    </el-col>
                </el-row>
                <el-row>
                    <el-col>Thành viên theo dõi công việc</el-col>
                </el-row>
                <el-row>
                    <el-checkbox v-model="checked" size="large" label="Mời thành viên theo dõi công việc vào kế hoạch , nếu chưa được mời" />
                </el-row>
                <div class="select">
                    <el-button type="success">Sao chép</el-button>
                </div>
            </el-popover>

            <el-popover
                :visible="dialog.dialogStore"
                ref="storeTaskGroup"
                trigger="click"
                virtual-triggering
                width="303px"
                persistent
            >
                <el-row class="title-dialog">
                    <el-col :span="18" class="title">
                        <el-form-item label="Lưu trữ Nhóm việc"></el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button class="close" @click="dialog.dialogStore = false">x</el-button>
                    </el-col>
                </el-row>
                <el-row>
                    <p style="white-space: pre-line;">Thao tác này sẽ chuyển Nhóm công việc vào lưu trữ.
                        Bạn có thể vào danh sách công việc lưu trữ để phục hồi lại.
                        Bạn có muốn tiếp tục không?
                    </p>
                </el-row>
                <el-row>
                    <el-col :span="10"></el-col>
                    <el-col :span="8"><el-button type="success" round>Xác nhận</el-button></el-col>
                    <el-col :span="6"><el-button type="info" round @click="dialog.dialogStore = false">Hủy</el-button></el-col>
                </el-row>
            </el-popover>

            <el-popover
                :visible="dialog.dialogStoreAllWork"
                ref="storeAllWorkInGroup"
                trigger="click"
                virtual-triggering
                width="444px"
                persistent
            >
                <el-row class="title-dialog">
                    <el-col :span="18" class="title">
                        <el-form-item label="Lưu trữ toàn bộ việc trong nhóm"></el-form-item>
                    </el-col>
                    <el-col :span="2">
                        <el-button class="close" @click="dialog.dialogStoreAllWork = false">x</el-button>
                    </el-col>
                </el-row>
                <el-row>
                    <p style="white-space: pre-line;">Thao tác này sẽ chuyển toàn bộ Công việc trong Nhóm vào lưu trữ. 
                        Bạn có thể vào danh sách công việc lưu trữ để phục hồi lại. 
                        Bạn có muốn tiếp tục không?
                    </p>
                </el-row>
                <el-row>
                    <el-col :span="3"></el-col>
                    <el-col :span="6"><el-button type="success" round>Lưu tất cả</el-button></el-col>
                    <el-col :span="11"><el-button type="primary">Lưu việc đã hoàn thành</el-button></el-col>
                    <el-col :span="4"><el-button type="info" round @click="dialog.dialogStoreAllWork = false">Đóng</el-button></el-col>
                </el-row>
            </el-popover>

            <el-popover
                :visible="dialog.dialogDelete"
                ref="deleteTaskGroup"
                trigger="click"
                virtual-triggering
                width="350px"
                persistent
            >
                <el-row class="title-dialog">
                    <el-col :span="18" class="title">
                        <el-form-item label="Xóa nhóm việc"></el-form-item>
                    </el-col>
                    <el-col :span="2"> 
                        <el-button class="close" @click="dialog.dialogDelete = false">x</el-button>
                    </el-col>
                </el-row>
                <el-row>
                    <p style="white-space: pre-line;">Bạn có chắc là xoá nhóm việc này không?
                        Vui lòng nhập số <b>5</b> vào ô bên dưới để xác nhận
                        <b style="color: red;">Nếu xoá bạn sẽ không thể phục hồi lại.</b>
                    </p>
                </el-row>
                <el-row>
                    <el-input v-model="input" placeholder="5" />
                </el-row>
                <el-row>
                    <el-col><el-button style="place-content: center;" type="danger" round>Xóa</el-button></el-col>
                </el-row>
            </el-popover>
        </AuthenticatedLayout>

        <el-dialog
            v-model="dialog.dialogVisible"
            title="Tạo nhóm công việc"
            width="30%"
            :before-close="handleClose"
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
