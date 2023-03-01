<script setup lang="ts">
import { CloseBold } from "@element-plus/icons-vue";
import { ref } from "vue";
import FileUpload from '@/Components/FileUpload.vue';
import {ArrowDown} from '@element-plus/icons-vue';
import { ElMessage, ElMessageBox } from "element-plus";

defineProps({
    taskForm: {
        type: Object,
    },
});

const checkAll = ref(false);
const checkedFiles = ref([]);
const showInputEdit = ref(false);

let files = ref([
{
        id: 1,
        title: "cskc",
        user: "Vo Van Duc",
        created_at: "16:00:00",
        description: "Đây là một file ảnh",
        url:'http://127.0.0.1:8000/storage/attachments/nqhzMO8HiJpcALccJqFTHDuNRlkY1NoDDuvbFNuK.jpg'
    },
    {
        id:2,
        title: "vnascnakc",
        user: "Nguyen Dinh Manh",
        created_at: "16:00:00",
        description: "Đây là một file ảnh",
        url:'http://127.0.0.1:8000/storage/attachments/nqhzMO8HiJpcALccJqFTHDuNRlkY1NoDDuvbFNuK.jpg'
    },
]);

const fileList= files.value.map(a => a.id);

function handleShowEdit() {
    showInputEdit.value = true;
}

function handleCloseEdit() {
    showInputEdit.value = false;
}

const handleCheckAllClick = ()=>{
    checkedFiles.value = fileList;
    checkAll.value = true;
}

const handleRemoveCheckAllClick = ()=>{
    checkedFiles.value = [];
    checkAll.value = false;
}

const handleCheckAllChange = (val) => {
    checkedFiles.value = val ? fileList : [];
}

const handleCheckedFilesChange = (value) => {
    const checkedCount = value.length;
    checkAll.value = checkedCount === fileList .length;
}

const handleRemoveFile = (id) => {
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

const handleRemoveCheckedFile = () => {
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

            <div v-for="file in files" >
                <div class="option-img flex mt-8 mb-8">
                <div class="flex option-img-des align-items-center" >
                    <img
                        :src="file.url"
                        class="image rounded"
                    />
                    <div class="image-infor ml-8">
                        <span class="info-img-item image-infor-title">{{ file.title }}</span>
                        <span class="flex">
                            <span class="image-infor-name mr-2">{{ file.user }}</span>
                            <span class="font-weight-light">Đã thêm lúc {{ file.created_at }}</span>
                        </span>
                        <span
                            v-if="!showInputEdit"
                            @click="handleShowEdit"
                            class="info-edit"
                            >Bấm để cập nhật mô tả
                            <el-icon class="info-edit-icon"
                                ><EditPen
                            /></el-icon>
                        </span>
                        <span v-if="showInputEdit">
                            <el-input
                                v-model="taskForm.name"
                                :value="taskForm.name"
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
                            <el-link class="mr-2" href="#">Tải về</el-link>
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
                >
                    <el-checkbox :key="file.id" :label="file.id" size="large" class="file-checkbox"/>
                </el-checkbox-group>
            </div>
            </div>

            <div v-if="files.length" class="d-flex justify-content-end mr-4 w-[100%]">
                <el-button type="primary">Tải tất cả</el-button>
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
</style>
