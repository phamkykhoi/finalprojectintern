<script setup lang="ts">
import { CloseBold } from "@element-plus/icons-vue";
import { ref, watch} from "vue";
import FileUpload from '@/Components/FileUpload.vue';
import {ArrowDown} from '@element-plus/icons-vue';
import { ElMessage, ElMessageBox } from "element-plus";
import request from '../utils/request';
import axios from '../utils/axioService';
import TimeAgo from 'javascript-time-ago'
import vi from 'javascript-time-ago/locale/vi'

const props = defineProps({
    taskId: {
        type: Number,
    },
    isDisabled:{
        type: Boolean,
        default: false,
    },
    files:{
        type : Array,
    },
    getFiles:{
        type: Function,
    }
});

TimeAgo.addDefaultLocale(vi)

const timeAgo = new TimeAgo('vi')

const checkAll = ref(false);

const checkedFiles = ref([]);

const showInputEdit = ref(false);

const files = ref(props.files);

watch(() => props.files, (newVal) => {
	files.value = newVal
})

async function getFiles() {
    await request.post(`/get-attachments-by-task/${props.taskId}`, {responseType: 'blob'}).then((res) => {
        files.value = res.data.result.attachment_list;
    })
}

getFiles()

const fileList = ref([])

function handleShowEdit(){
    showInputEdit.value = true;
}

function handleCloseEdit(){
    showInputEdit.value = false;
}

const handleCheckAllClick = ()=>{
    checkAll.value = true
    fileList.value = files.value.map(file => file.id);
    checkedFiles.value =  fileList.value ;
}

const handleRemoveCheckAllClick = () =>{
    checkedFiles.value = [];
    checkAll.value = false;
}

const handleCheckAllChange = (val) =>{
    fileList.value = files.value.map(file => file.id);
    checkedFiles.value = val ? fileList.value : [];
}

const handleCheckedFilesChange = () =>{
    checkAll.value = checkedFiles.value.length === files.value.length;
}

const handleRemoveFile = (attachmentId) =>{
  ElMessageBox.confirm(
    'The file will be permanently deleted, continue to delete the file?',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(async () => {
        await request.delete(`/delete-attachment`, {checkedFiles: attachmentId }).then((res) => {
            props.getFiles()
        })
        ElMessage({
            type: "success",
            message: "Delete completed",
        });
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

const handleRemoveCheckedFile = (taskId) =>{
    ElMessageBox.confirm(
    'All selected files will be permanently deleted, keep deleting ?',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        request.delete(`/delete-attachment`, {checkedFiles: checkedFiles.value }).then((res) => {
            props.getFiles()
        })
        ElMessage({
            type: "success",
            message: "Delete completed",
        });
        checkedFiles.value = []
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

const handleGetLink = (url)=>{
    navigator.clipboard.writeText(url);
    ElMessage({
        showClose: true,
        message: 'Đã copy url vào clipboard',
        type: 'success',
    })
}

const handleDownloadFile=(file)=>{
    if (isImageFormat(file.extension)) {
        const link = document.createElement('a');
        link.href = '../storage/attachments/' + file.file_name;
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        return
    }

    const link = document.createElement('a');
    link.href = '../storage/attachments/' + file.file_name;
    link.download = file.title;
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

const handleDownloadAllFiles = ()=>{
    files.value.map(function(file){
      const link = document.createElement('a');
      link.href = file.url;
      link.download = file.title.concat('.'+file.extention);
      document.body.appendChild(link);
      link.click();
      document.body.removeChild(link);
    })
}

function isImageFormat(fileExtention) {
  return (/(gif|jpe?g|png|bmp|webp)$/i).test(fileExtention);
}

</script>
<template>
    <div>
        <el-row class="my-4">
            <el-form-item label="Tệp đính kèm:"></el-form-item>
            <FileUpload @data-updated="getFiles" :params="{task_id : taskId}" :isDisabled="isDisabled"></FileUpload>
            <el-dropdown>
                <el-button class="ml-2 mr-2" :disabled="isDisabled">
                    Sắp xếp theo
                    <el-icon class="el-icon--right">
                        <ArrowDown />
                    </el-icon>
                </el-button>
                <template #dropdown>
                    <el-dropdown-menu>
                        <el-dropdown-item>Tên tập tin</el-dropdown-item>
                        <el-dropdown-item>Ngày tạo</el-dropdown-item>
                        <el-dropdown-item>Loại tập tin</el-dropdown-item>
                        <el-dropdown-item>Kích thước</el-dropdown-item>
                    </el-dropdown-menu>
                </template>
            </el-dropdown>
            <el-checkbox
                v-if="files.length"
                v-model="checkAll"
                @change="handleCheckAllChange"
                >Check all</el-checkbox
            >

            <div v-for="file in files" class="w-[100%]">
                <div class="option-img flex" style="margin-top: 0.5rem; margin-bottom: 0.5rem;">
                <div class=" flex option-img-des ml-5 align-items-center " >
                    <img v-if="isImageFormat(file.extension)" :src="'/storage/attachments/' + file.file_name" class="file-image image rounded"/>
                    <img v-else src="https://cdn-icons-png.flaticon.com/512/3767/3767084.png" class="file-image image rounded"/>
                    <div class="image-infor ml-8">
                        <span class="info-img-item image-infor-title">{{ file.title }}</span>
                        <span class="flex">
                            <span class="image-infor-name mr-2">{{ file.user }}</span>
                            <span class="font-weight-light">Đã thêm lúc {{ timeAgo.format((new Date(file.created_at))) }}</span>
                        </span>
                        <span
                            v-if="!showInputEdit"
                            @click="handleShowEdit"
                            class="info-edit cursor-pointer"
                            >Bấm để cập nhật mô tả
                            <el-icon class="info-edit-icon"
                                ><EditPen
                            /></el-icon>
                        </span>
                        <span v-if="showInputEdit">
                            <el-input
                                v-model="file.description"
                                :value="file.description"
                                type="textarea"
                                :rows="2"
                                autocomplete="off"
                                placeholder="Mô tả công việc"
                                clearable
                                class="pr-4"
                            />
                            <span class="name-btn">
                                <el-button
                                    color="green"
                                    class="mr-4"
                                    >Cập nhật</el-button
                                >
                                <el-icon
                                    @click="handleCloseEdit"
                                    class="name-icon-close close cursor-pointer"
                                    ><CloseBold
                                /></el-icon>
                            </span>
                        </span>

                        <div>
                            <el-link class="mr-2" href="#">Bình luận</el-link>
                            <el-link class="mr-2" @click="handleDownloadFile(file)">Tải về</el-link>
                            <el-link class="mr-2" @click="handleGetLink(file.url)">Lấy link</el-link>
                            <el-link class="mr-2" href="#">Bỏ ảnh bìa</el-link>
                            <el-link class="mr-2" @click="handleRemoveFile(file.id)">Xóa</el-link>
                        </div>
                    </div>
                </div>
                <el-checkbox-group
                    hide-labels
                    v-model="checkedFiles"
                    @change="handleCheckedFilesChange"
                    class="ml-auto"
                >
                    <el-checkbox :key="file.id" :label="file.id" size="large" class="file-checkbox "/>
                </el-checkbox-group>
            </div>
            </div>

            <div v-if="files.length" class="d-flex justify-content-end mr-4 w-[100%]">
                <el-button type="primary" @click="handleDownloadAllFiles">Tải tất cả</el-button>
                <el-button  v-if="checkedFiles.length" type="danger" class="ml-2" @click="handleRemoveCheckedFile(props.taskId)" >Xóa tập tin đã chọn</el-button
                >
                <el-button class="ml-2" @click=" handleCheckAllClick">Chọn tất cả</el-button>
                <el-button  v-if="checkedFiles.length" class="ml-2" @click="handleRemoveCheckAllClick">Bỏ chọn tất cả</el-button>
            </div>
        </el-row>
    </div>
</template>
<style>
.image-infor {
    font-weight: 400;
    font-size: 14px;
    color: #666;
}
.file-checkbox>.el-checkbox__label{
    display: none;
}
.image-infor-title {
    font-weight: 800;
    color: #000;
}
.image-infor-name {
    color: #000;
}
.image {
    object-fit: cover;
    width: 20%;
    display: block;
}
.name-btn {
    display: flex;
    align-items: center;
    margin-top: 8px;
}
.file-image{
    width: 100px;
    height: 100px;
    object-fit: cover;
}
</style>
