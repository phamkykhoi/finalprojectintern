<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import TaskForm from '@/Pages/Task/Form.vue';
import TaskList from '@/Pages/Task/Index.vue';
import { reactive, ref, onBeforeMount, watch, unref } from 'vue';
import { 
    InfoFilled, DCaret, MoreFilled, Plus, EditPen, 
    CopyDocument, Switch, Rank, TakeawayBox, Delete, 
    CaretTop, CaretBottom, Select, CircleClose 
} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside, ElMessageBox  } from 'element-plus';

const props = defineProps({
    departments: Array,
    taskGroups: Array,
    activityId: Number,
});

const showFormTask = ref(false);
const state  = reactive({
    task: {
        name: "",
        description: "",
        task_group_id: ""
}
})

const createTaskForm = (currentTask) => {
    showFormTask.value = true;
    state.task = currentTask
}

const closeFormTask = (value) => {
    showFormTask.value = value;
}

const groupsTask = ref([])

onBeforeMount(async () => {
    getGroupsTask()
});

async function getGroupsTask() {
    await axios.get(`/api/activity/${props.activityId}`).then((res) => {
        groupsTask.value = res.data.taskGroups
    })
}

watch(showFormTask, () => {
    getGroupsTask()
})

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
const  popoverMove= () => {
  unref(moveJobGroup).popperRef?.delayHide?.()
}

const moveAllTheWork = ref()
const  popoverMoveAll= () => {
  unref(moveAllTheWork).popperRef?.delayHide?.()
}

const storeTaskGroup = ref()
const  popoverstoreTaskGroup= () => {
  unref(popoverstoreTaskGroup).popperRef?.delayHide?.()
}

const storeAllWorkInGroup = ref()
const  popoverstoreAllWorkInGroup= () => {
  unref(popoverstoreAllWorkInGroup).popperRef?.delayHide?.()
}

const deleteTaskGroup = ref()
const  popoverDeleteTaskGroup= () => {
  unref(popoverDeleteTaskGroup).popperRef?.delayHide?.()
}

const dialogVisible = ref(false)
const dialogCopy = ref(false)
const dialogMove = ref(false)
const dialogMoveAll = ref(false)
const dialogStore = ref(false)
const dialogStoreAllWork = ref(false)
const dialogDelete = ref(false)

const addTaskGroup = ref(false)
const editNameTaskGroup = ref([false])
const showIconSort = ref([false])
const showIcon = ref([false])
const input = ref('')

</script>

<template>
    <div>
        <Head title="Activity"/>
        
        <AuthenticatedLayout>
            <template #departen>
                <DepartenList :departments="departments" :activityId="activityId" />
            </template>

            <section class="lists-container">
                <div :key="index" v-for="(taskGroup, index) in groupsTask">
                    <el-card class="box-card">
                        <template #header>
                            <div class="card-header" v-if="!editNameTaskGroup[index]">
                                <el-col>
                                    <span @click="editNameTaskGroup[index] = true">{{ taskGroup.name }}</span>
                                    <div class="group-icons">
                                        <el-button v-popover="popoverRef[index]" v-click-outside="popoverInfoTaskGroup" :icon="InfoFilled" circle/>
                                        <el-button v-popover="popoverRef1[index]" v-click-outside="popoverSort" :icon="DCaret" circle/>
                                        <el-button v-popover="popoverRef2[index]" v-click-outside="popoverOption" :icon="MoreFilled" circle/>
                                    </div>
                                </el-col>
                            </div>
                            <el-form v-if="editNameTaskGroup[index]">
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
                                    <el-button @click="editNameTaskGroup[index] = false" style="margin-left: 10px;">x</el-button>
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
                                    <el-row v-if="showIcon[3]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[3] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày hòan thành</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[3] = !showIconSort[3]">
                                            <el-icon v-if="showIconSort[3]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[3]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="showIcon[5]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[5] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày thực hiện</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[5] = !showIconSort[5]">
                                            <el-icon v-if="showIconSort[5]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[5]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="showIcon[1]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[1] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày bắt đầu</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[1] = !showIconSort[1]">
                                            <el-icon v-if="showIconSort[1]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[1]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                </el-col>
                                <el-col class="icon-sort-small" :span="12">
                                    <el-row v-if="showIcon[3]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[4] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày tạo</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[4] = !showIconSort[4]">
                                            <el-icon v-if="showIconSort[4]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[4]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="showIcon[2]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[2] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Ngày kết thúc</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[2] = !showIconSort[2]">
                                            <el-icon v-if="showIconSort[2]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[2]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                    <el-row v-if="showIcon[0]" :span="24">
                                        <el-col :span="3" class="icon-small"  @click="showIcon[0] = false">
                                            <el-icon><CircleClose /></el-icon>
                                        </el-col>
                                        <el-col :span="18">Tên công việc</el-col>
                                        <el-col :span="3" class="icon-small" @click="showIconSort[0] = !showIconSort[0]">
                                            <el-icon v-if="showIconSort[0]"><CaretTop /></el-icon>
                                            <el-icon v-if="!showIconSort[0]"><CaretBottom /></el-icon>
                                        </el-col>
                                    </el-row>
                                </el-col>
                            </el-row>

                            <el-col>
                                <el-button @click="showIcon[0] = true" v-if="!showIcon[0]">Tên công việc</el-button>
                                <el-row v-if="showIcon[0]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[0] = !showIconSort[0]">
                                        <el-icon v-if="showIconSort[0]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[0]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Tên công việc</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[0] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="showIcon[1] = true" v-if="!showIcon[1]">Ngày bắt đầu</el-button>
                                <el-row v-if="showIcon[1]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[1] = !showIconSort[1]">
                                        <el-icon v-if="showIconSort[1]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[1]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày bắt đầu</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[1] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="showIcon[2] = true" v-if="!showIcon[2]">Ngày kết thúc</el-button>
                                <el-row v-if="showIcon[2]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[2] = !showIconSort[2]">
                                        <el-icon v-if="showIconSort[2]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[2]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày kết thúc</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[2] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="showIcon[3] = true" v-if="!showIcon[3]">Ngày hoàn thành</el-button>
                                <el-row v-if="showIcon[3]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[3] = !showIconSort[3]">
                                        <el-icon v-if="showIconSort[3]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[3]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày hoàn thành</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[3] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="showIcon[4] = true" v-if="!showIcon[4]">Ngày tạo</el-button>
                                <el-row v-if="showIcon[4]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[4] = !showIconSort[4]">
                                        <el-icon v-if="showIconSort[4]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[4]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày tạo</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[4] = false"><Select /></el-icon>
                                    </el-col>
                                </el-row>
                            </el-col>
                            <el-col>
                                <el-button @click="showIcon[5] = true" v-if="!showIcon[5]">Ngày thực hiện</el-button>
                                <el-row v-if="showIcon[5]">
                                    <el-col :span="2" class="icon-sort" @click="showIconSort[5] = !showIconSort[5]">
                                        <el-icon v-if="showIconSort[5]"><CaretTop /></el-icon>
                                        <el-icon v-if="!showIconSort[5]"><CaretBottom /></el-icon>
                                    </el-col>
                                    <el-col :span="18">Ngày thực hiện</el-col>
                                    <el-col :span="4" class="icon-sort">
                                        <el-icon  @click="showIcon[5] = false"><Select /></el-icon>
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
                        <el-button @click="editNameTaskGroup[index] = true"
                            v-click-outside="popover" :icon="EditPen" circle>
                            Hiệu chỉnh nhóm công việc
                        </el-button>
                        <hr>
                        <el-button @click="dialogVisible = true"
                            v-click-outside="popover" :icon="Plus" circle>
                            Tạo nhóm công việc
                        </el-button>
                        <el-button v-popover="copyJobGroup" @click="dialogCopy = true"
                            v-click-outside="popoverCopy" :icon="CopyDocument" circle>
                            Sao chép nhóm công việc
                        </el-button>
                        <el-button v-popover="moveJobGroup" @click="dialogMove = true"
                            v-click-outside="popoverMove" :icon="Switch" circle>
                            Di chuyển nhóm công việc
                        </el-button>
                        <el-button  v-popover="moveAllTheWork" @click="dialogMoveAll = true"
                            v-click-outside="popover" :icon="Rank" circle>
                            Di chuyển toàn bộ công việc trong nhóm
                        </el-button>
                        <hr>
                        <el-button v-popover="storeTaskGroup"  @click="dialogStore = true"
                            v-click-outside="popover" :icon="TakeawayBox" circle>
                            Lưu trữ nhóm việc
                        </el-button>
                        <el-button v-popover="storeAllWorkInGroup" @click="dialogStoreAllWork = true"
                            v-click-outside="popover" :icon="TakeawayBox" circle>
                            Lưu trữ toàn bộ việc trong nhóm
                        </el-button>
                        <hr>
                        <el-button v-popover="deleteTaskGroup" @click="dialogDelete = true"
                            v-click-outside="popover" :icon="Delete" circle>
                            Xóa nhóm việc
                        </el-button>
                    </el-popover>
                </div>
                
                <el-button 
                    class="add-list-btn btn" 
                    style="place-content: baseline; background: gainsboro;"
                    @click="addTaskGroup = true" v-if="!addTaskGroup"
                >
                    <el-icon><Plus /></el-icon>Tạo nhóm công việc
                </el-button>
                <el-form v-if="addTaskGroup">
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
                        <el-button @click="addTaskGroup = false" style="margin-left: 10px;">x</el-button>
                    </el-row>
                </el-form>
            </section>
        </AuthenticatedLayout>

        <el-popover
            :visible="dialogCopy"
            ref="copyJobGroup"
            trigger="click"
            virtual-triggering
            width="300px"
            persistent
        >
            <el-row class="title-dialog">
                <el-col :span="18" class="title">
                    <el-form-item label="Sao chép nhóm việc"></el-form-item>
                </el-col>
                <el-col :span="2">
                    <el-button class="close" @click="dialogCopy = false">x</el-button>
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
            :visible="dialogMove"
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
                    <el-button class="close" @click="dialogMove = false">x</el-button>
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
            :visible="dialogMoveAll"
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
                    <el-button class="close" @click="dialogMoveAll = false">x</el-button>
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
            :visible="dialogStore"
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
                    <el-button class="close" @click="dialogStore = false">x</el-button>
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
                <el-col :span="6"><el-button type="info" round>Hủy</el-button></el-col>
            </el-row>
        </el-popover>

        
        <el-popover
            :visible="dialogStoreAllWork"
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
                    <el-button class="close" @click="dialogStoreAllWork = false">x</el-button>
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
                <el-col :span="4"><el-button type="info" round>Đóng</el-button></el-col>
            </el-row>
        </el-popover>

        <el-popover
            :visible="dialogDelete"
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
                    <el-button class="close" @click="dialogDelete = false">x</el-button>
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

        <el-dialog
            v-model="dialogVisible"
            title="Tạo nhóm công việc"
            width="30%"
            :before-close="handleClose"
        >
            <input type="text" name="" placeholder="Nhập tên nhóm công việc" style="width: 100%; border-radius: 8px;">
            <template #footer>
            <span class="dialog-footer">
                <el-button @click="dialogVisible = false">Đóng</el-button>
                <el-button type="primary" @click="dialogVisible = false">Lưu</el-button>
            </span>
            </template>
        </el-dialog>
    </div>
    <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
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
