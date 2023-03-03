<script lang="ts" setup>
import TaskForm from '@/Pages/Task/Form.vue';
import { reactive, ref, unref, defineProps } from 'vue';
import { Plus, EditPen, CopyDocument, Switch, Rank, TakeawayBox, Delete} from '@element-plus/icons-vue';
import { ClickOutside as vClickOutside } from 'element-plus';
import { ElMessageBox } from 'element-plus'

const props = defineProps({
    idTaskGroup: Number,
    state: Object,
    taskGroup: Object,
    popperRef: {
      type: Object, 
      required: true
    }
});

const dialogVisible = ref(false)
// console.log(props.taskGroup)
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
    input:'',
});

const showFormTask = ref(false);

const closeFormTask = (value) => {
    showFormTask.value = value;
}
const createTaskForm = (currentTask) => {
    showFormTask.value = true;
    props.state.task = currentTask
}

const popoverRef2 = ref([])

</script>
<template>
    <!-- <el-popover
        :ref="ref => popoverRef2[props.idTaskGroup] = ref"
        virtual-triggering
        persistent
        width="300px"
        trigger="click"
    > -->
        <el-button @click="createTaskForm(props.taskGroup)"
            v-click-outside="false" :icon="Plus" circle > 
            Thêm mới công việc
        </el-button>
        <el-button @click="dialog.editNameTaskGroup[props.idTaskGroup] = true"
            :icon="EditPen" circle>
            Hiệu chỉnh nhóm công việc
        </el-button>
        <hr>
        <el-button @click="dialog.dialogVisible = true"
            :icon="Plus" circle>
            Tạo nhóm công việc
        </el-button>
        <el-button  v-popover="copyJobGroup" @click="dialog.dialogCopy = true" 
            :icon="CopyDocument" circle>
            Sao chép nhóm công việc
        </el-button>
        <el-button v-popover="moveJobGroup" @click="dialog.dialogMove = true"
            :icon="Switch" circle>
            Di chuyển nhóm công việc
        </el-button>
        <el-button  v-popover="moveAllTheWork" @click="dialog.dialogMoveAll = true"
            :icon="Rank" circle>
            Di chuyển toàn bộ công việc trong nhóm
        </el-button>
        <hr>
        <el-button v-popover="storeTaskGroup"  @click="dialog.dialogStore = true"
            :icon="TakeawayBox" circle>
            Lưu trữ nhóm việc
        </el-button>
        <el-button v-popover="storeAllWorkInGroup" @click="dialog.dialogStoreAllWork = true"
            :icon="TakeawayBox" circle>
            Lưu trữ toàn bộ việc trong nhóm
        </el-button>
        <hr>
        <el-button v-popover="deleteTaskGroup" @click="dialog.dialogDelete = true"
            :icon="Delete" circle>
            Xóa nhóm việc
        </el-button>

        <!-- sub popover -->
        <el-popover
            :visible="dialog.dialogCopy"
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

        <TaskForm v-if="showFormTask" :task="state.task" :isShowModal="showFormTask" v-on:closeModal="closeFormTask" />
    <!-- </el-popover> -->
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