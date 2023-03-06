<script lang="ts" setup>
import { ref, defineEmits, unref, reactive, watch } from 'vue';
import { ClickOutside as vClickOutside } from 'element-plus'
import { EditPen, CloseBold, CirclePlusFilled, Calendar, MoreFilled, DocumentCopy, Rank, Bell, Share, List } from '@element-plus/icons-vue';

const props = defineProps({
    taskId: Number
})

const checked = ref([false])

const popoverRef  = ref([])

const onClickOutside = () => {
    unref(popoverRef).popperRef?.delayHide?.()
}

const hidePopoverSubTask = (index) => {
    popoverRef.value[index].hide()
}

function CloseInputTask(){
    checked.value = [false]
}

function editSubTask(item){
    if (item.name == ''){
        return;
    }
    CloseInputTask()
}

const subTasks = ref([
      { id: 1,
        name: 'Việc con 1',
        description: 'Mô tả thành phần' },
      { id: 2,
        name: 'Việc con 2',
        description: 'Mô tả thành phần' },
      { id: 3,
        name: 'Việc con 3',
        description: 'Mô tả thành phần' }
])

const checkedSubTask = ref(Array(subTasks.value.length).fill(false));

function deleteSubTask(idSubTask){
    subTasks.value.splice(idSubTask, 1);
    checkedSubTask.value.splice(idSubTask, 1);
    popoverRef.value[idSubTask].hide()
}

const showAddTask = ref(false)

function createFormAddTask(){
    showAddTask.value = true
    checked.value = [false]
}

const name = ref('')
const description = ref('')
const lineThrough = ref('')

function saveSubTask(){
    subTasks.value.push({
        name: name.value,
        description: description.value,
    })
    checkedSubTask.value.push('false')
    name.value = ''
    description.value = ''
    showAddTask.value = false
}

function closeAddTask(){
    showAddTask.value = false
}

function countCheckSubTask() {
    var count = 0

    checkedSubTask.value.filter(function (task) {
        if (task == true){
            count = count + 1
        }
        return count;
    });
    addClass(count)

    return count;
}

function addClass(count){
    if (count == subTasks.value.length && count!=0){
        return lineThrough.value = 'line-through'
    }

    return lineThrough.value = ''
}

function closeFormUpdate(index, item){
    if (!item.name.trim()) {
        item.name = item.name.trim();
    }
    checked.value[index] = false
}

function updateSubTask(subTask, value) {
    return subTask
}

watch(subTasks, (newVal, oldVal) => {
    alert(newVal)
});
</script>

<template>
    <el-row class="task-child">
            <div class="flex list-task">
                <el-icon style="padding-left: 0px;" :size="25"><List /></el-icon>
                <el-form-item :class="lineThrough" style="margin-bottom: 0; margin-left: 6px; " label="Danh sách việc con"></el-form-item>
                <span>({{ countCheckSubTask() + '/' + subTasks.length}})</span>
            </div>
            <el-button @click="createFormAddTask">Tạo việc con</el-button>
    </el-row>
    <div class="task-progress">
        <el-progress :percentage="(countCheckSubTask()/subTasks.length*100) ? (countCheckSubTask()/subTasks.length*100).toFixed(0) : 0" color="#00FF00"/>
    </div>
    <el-row v-if="showAddTask">
        <el-col :span="1" style="text-align: right;">
        </el-col>
        <el-col :span="23" style="text-align: right;">
            <el-input v-model="name" type="textarea" :rows="1" autocomplete="off" placeholder="Tạo mới tên việc"
                clearable style="display: block;" />
            <el-input v-model="description" type="textarea" :rows="1" autocomplete="off" placeholder="tạo mới mô tả"
                clearable style="display: block; margin-top: 8px;" />
                <span class="task-btn">
            <el-button color="green" style="margin-right: 8px;" @click="saveSubTask">Tạo việc</el-button>
            <el-icon @click="closeAddTask" class="task-icon-close close"><CloseBold /></el-icon>
        </span>
        </el-col>
    </el-row>
<div v-for="(item, index) in subTasks" :key="index">
    <div class="flex" style="margin: 16px 0">
        <div>
            <el-checkbox style="margin-right: 16px;" v-model="checkedSubTask[index]" size="large"/>
        </div>

        <div class="task-option" v-if="!checked[index]">
            <div  @click="checked = [false]; checked[index] = true">
                <span style=" font-size: 14px;" v-if="!checked[index]">{{ item.name }}</span>
                <p style="font-size: 14px;">{{ item.description }}</p>
            </div>
            <div class="task-option-icon">
                <span>
                    <el-icon style="margin: 0 2px;" size="20"><Calendar /></el-icon>
                    <el-icon style="margin: 0 2px;" size="20"><CirclePlusFilled /></el-icon>
                </span>
                    <el-icon size="20" v-popover="popoverRef[index]" v-click-outside="onClickOutside"><MoreFilled /></el-icon>
                <el-popover
                    :ref="ref => popoverRef[index] = ref"
                    :width="300"
                    trigger="click"
                    virtual-triggering
                    placement="right-start"
                >
                    <div style="display: flex; align-items: center; justify-content: space-between;">
                        <p>Chức năng</p>
                        <el-icon class="close" @click="hidePopoverSubTask(index)"><CloseBold /></el-icon>
                    </div>
                    <el-button class="activity-icon" size="medium" :icon="EditPen" style="width: 100%; border: none">Cập nhật mô tả</el-button>
                    <el-button class="activity-icon" size="medium" :icon="DocumentCopy" style="width: 100%; border: none">Sao chép</el-button>
                    <el-button class="activity-icon" size="medium" :icon="Rank" style="width: 100%; border: none">Di chuyển</el-button>
                    <el-button class="activity-icon" size="medium" :icon="Bell" style="width: 100%; border: none">Nhắc việc</el-button>
                    <el-button class="activity-icon" size="medium" :icon="Share" style="width: 100%; border: none">Lấy link chia sẻ</el-button>
                    <el-button class="activity-icon" size="medium" :icon="CloseBold" @click="deleteSubTask(index)" style="width: 100%; border: none">Xóa</el-button>
                </el-popover>
            </div>
        </div>

        <div v-if="checked[index]" style="display: flex; align-items: center; width: 110%;">
            <el-col :span="23" style="text-align: right;">
                <el-input @blur="updateSubTask(item, $event.target.value)" v-model.lazy="item.name" :value="item.name" type="textarea" :rows="1" autocomplete="off" placeholder="Chỉnh sửa tên việc"
                    clearable style="display: block;"/>
                <el-input v-model="item.description" :value="item.description" type="textarea" :rows="2" autocomplete="off" placeholder="Chỉnh sửa mô tả"
                    clearable style="display: block; margin-top: 8px;" />
                    <span class="task-btn">
                <el-button color="green" style="margin-right: 8px;" @click="editSubTask(item)">Cập nhật</el-button>
                <el-icon @click="closeFormUpdate(index, item)" class="task-icon-close close"><CloseBold /></el-icon>
            </span>
            </el-col>
        </div>
    </div>
</div>

</template>
<style scoped>
.modal-open {
  overflow: hidden;
}
.line-through{
    text-decoration: line-through;
}
.form-add-user{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 16px;
}
.form-add-user,
.info {
    margin-bottom: 16px;
}
.btn-container {
    justify-content: flex-start;
    width: 105%;
    margin: 2px 0;
}
.btn-container1 {
    justify-content: flex-start;
    width: 99%;
}
.btn-add-user{
    width: 100%;
}
.demo-image{
    display: flex;
    justify-content: center;
}
.task-progress .el-progress--line {
    margin: 16px 0;
    flex-direction: row-reverse;
}
.task-progress ::v-deep .el-progress__text{
    margin-right: 6px;
    min-width: 28px;
}
.ml-4 {
    margin-left: 4px;
}
.ml-6 {
    margin-left: 6px;
}
.ml-8 {
    margin-left: 8px;
}
.ml-31 {
    margin-left: 31px;
}
.mt-8{
    margin-top: 8px;
}
.mb-8{
    margin-bottom: 8px;
}
.description{
    align-items: center;
}
.description-btn,
.name-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}
.task-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}
.description-icon-close:hover,
.task-icon-close:hover {
    cursor: pointer;
}
.task-option{
    padding-right: 8px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
}
.task-option:hover{
    background-color: #dddddd;
}
.task-option span{
    margin-right: 16px;
}
.task-option-icon:hover{
    cursor: pointer;
}
.list-task{
    align-items: center;
}
.option-img{
    align-items: center;
}
.info-img{
    width: 100%;
    font-size: 14px;
}
.option-img:hover{
    background-color: #ccc;
}
.info-edit:hover{
    cursor: pointer;
}
.info-edit-icon{
    display: none;
}
.info-edit:hover .info-edit-icon{
    display: inline-block;
}
.info-img-item{
    padding: 4px 0;
}

.el-link {
  margin-right: 8px;
}
.el-link .el-icon--right.el-icon {
  vertical-align: text-bottom;
}
.image {
    object-fit: cover;
    width: 20%;
    display: block;
}
.comment{
    position: relative;
}
.comment-icon{
    position: absolute;
    left: 0;
    bottom: 50%;
}
.comment-input{
    margin-left: 0px;
}
.commented{
    width: 100%;
    margin-right: 8px;
    border: 1px solid #ccc;
    border-radius: 3px;
    padding: 4px 4px;
}
.el-col{
    padding-left: 0;
}
.date {
    position: relative;
}

.date-icon {
    position: absolute;
    left: 0px;
    bottom: 10px;
    display: none;
}
.date:hover .date-icon{
    cursor: pointer;
    display: block;
}
.date:hover .date-finish{
    margin-left: 16px;
}

.info{
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 3px;
}
.info-user{
    display: flex;
    align-items: center;
}
.info-user-item{
    margin-left: 6px;
}
.people-icon:hover,
.icon-plus {
    cursor: pointer;
}
.people-icon{
    position: relative;
}
.people-icon:hover .people-icon-remove{
    display: block;
    left: 50%;
    bottom: 70%;
}
.people-icon-remove{
    display: none;
    position: absolute;
    color: red;
}
.info-user-icon{
    position: relative;
}
.user-icon-star{
    position: absolute;
    left: 50%;
    bottom: 18%;
}
.user-team{
    margin-top: 16px;
    align-items: center;
    justify-content: space-between;
}
.user-add{
    display: flex;
    margin: 16px 0;
}
.user-add img{
    border-radius: 50%;
    margin-right: 8px;
}
.info-user-close{
    position: relative;
}
.user-icon-close{
    position: absolute;
    top: 0;
    right: 0;
}
.el-button+.el-button{
    margin-left: 0;
}
.activity-icon{
    justify-content: flex-start;
}
.rate ::v-deep .el-link__inner{
    width: 60px;
}
.rate span{
    margin-left: 8px;
}
.rate-item ::v-deep span i{
    margin-right: 0;
}
.task-child{
    justify-content: space-between;
}
.close:hover{
    cursor: pointer;
}
::v-deep .el-dialog__body{
    border-top: 1px solid #ccc;
    border-bottom: 1px solid #ccc;
}
</style>