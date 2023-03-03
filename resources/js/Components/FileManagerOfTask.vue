<script setup lang="ts">
import { CloseBold } from "@element-plus/icons-vue";
import { ref } from "vue";
import FileUpload from '@/Components/FileUpload.vue';
import {ArrowDown} from '@element-plus/icons-vue';
import { ElMessage, ElMessageBox } from "element-plus";

defineProps({
    taskId: {
        type: Number,
    },
});

const checkAll = ref(false);
const checkedFiles = ref([]);
const showInputEdit = ref(false);

let files = ref([
{
        id: 1,
        title: "Laravel.rar",
        extention: "rar",
        user: "Admin",
        created_at: "16:00:00",
        description: "Framework Laravel",
        url:'abc.rar'
    },
    {
        id:2,
        title: "Vuejs",
        extention: "jpg",
        user: "Admin",
        created_at: "16:00:00",
        description: "Framework Vuejs",
        url:'data:image/png;base64,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'
        },
]);

const fileList= files.value.map(a => a.id);

function handleShowEdit(){
    showInputEdit.value = true;
}

function handleCloseEdit(){
    showInputEdit.value = false;
}

const handleCheckAllClick = ()=>{
    checkedFiles.value = fileList;
    checkAll.value = true;
}

const handleRemoveCheckAllClick = () =>{
    checkedFiles.value = [];
    checkAll.value = false;
}

const handleCheckAllChange = (val) =>{
    checkedFiles.value = val ? fileList : [];
}

const handleCheckedFilesChange = () =>{
    checkAll.value = checkedFiles.value.length === files.value.length;
}

const handleRemoveFile = (id) =>{
  ElMessageBox.confirm(
    'The file will be permanently deleted, continue to delete the file?',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
      files.value = files.value.filter(obj => obj.id !== id);
      checkedFiles.value = checkedFiles.value.filter(item => item !== id);
      ElMessage({
        type: 'success',
        message: 'Delete completed',
      })
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

const handleRemoveCheckedFile = () =>{
    ElMessageBox.confirm(
    'All selected files will be permanently deleted, keep deleting ?',
    {
      confirmButtonText: 'OK',
      cancelButtonText: 'Cancel',
      type: 'warning',
    }
  )
    .then(() => {
        if(files.value.length){
        files.value = files.value.filter(obj => !checkedFiles.value.includes(obj.id));
        }
        handleRemoveCheckAllClick();
      ElMessage({
        type: 'success',
        message: 'Delete completed',
      })
    })
    .catch(() => {
      ElMessage({
        type: 'info',
        message: 'Delete canceled',
      })
    })
}

const handleGetLink = (url)=>{
    console.log(url);
    navigator.clipboard.writeText(url);
    ElMessage({
        showClose: true,
        message: 'Đã copy url vào clipboard',
        type: 'success',
    })
}

const handleDownloadFile=(file)=>{
      const link = document.createElement('a');
      link.href = file.url;
      link.download =file.title.concat('.'+file.extention);
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
  return (/(gif|jpe?g|png|bmp)$/i).test(fileExtention);
}

</script>
<template>
    <div>
        <el-row class="my-4">
            <el-form-item label="Tệp đính kèm:"></el-form-item>
            <FileUpload></FileUpload>
            <el-dropdown>
                <el-button class="ml-2 mr-2">
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
                <div class="option-img flex mt-8 mb-8 ">
                <div class=" flex option-img-des ml-5 align-items-center " >
                    <img v-if="isImageFormat(file.extention)" :src="file.url" class="file-image image rounded"/>
                    <img v-if="!isImageFormat(file.extention)" src="https://cdn-icons-png.flaticon.com/512/3767/3767084.png" class="file-image image rounded"/>
                    <div class="image-infor ml-8">
                        <span class="info-img-item image-infor-title">{{ file.title }}</span>
                        <span class="flex">
                            <span class="image-infor-name mr-2">{{ file.user }}</span>
                            <span class="font-weight-light">Đã thêm lúc {{ file.created_at }}</span>
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
                <el-button  v-if="checkedFiles.length" type="danger" class="ml-2" @click="handleRemoveCheckedFile" >Xóa tập tin đã chọn</el-button
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
