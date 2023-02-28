<script setup >
import {CloseBold} from '@element-plus/icons-vue';
import { ref } from 'vue';

const props = defineProps({
    taskForm: {
        type:Object,
    },
});

const checkAll = ref(false)
const isIndeterminate = ref(true)
const checkedFiles = ref([])
const files = ['']
const showInputEdit = ref(false)

function handleShowEdit() {
    showInputEdit.value = true
}

function closeEdit() {
    showInputEdit.value = false
}
const handleCheckAllChange = (val) => {
  checkedFiles.value = val ? files : []
  isIndeterminate.value = false
}
const handleCheckedFilesChange = (value) => {
  const checkedCount = value.length
  checkAll.value = checkedCount === files.length
  isIndeterminate.value = checkedCount > 0 && checkedCount < files.length
}
</script>
<template>
      <div>
        <el-row style="margin: 16px 0;">
            <el-form-item label="Tệp đính kèm:"></el-form-item>
            <FileUpload></FileUpload>
            <el-dropdown>
                <el-button class="ml-2 mr-2">
                    Sắp xếp theo <el-icon class="el-icon--right">
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
                v-model="checkAll"
                :indeterminate="isIndeterminate"
                @change="handleCheckAllChange"
                >Check all</el-checkbox
            >

<div class="option-img flex mt-8 mb-8">
    <div class="flex option-img-des" style="align-items: center;">
        <img
            src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg"
            class="image rounded"
        />
        <div class="image-infor ml-8">
            <span class="info-img-item image-infor-title">Tên tệp .jpg</span>
            <span class="flex ">
                <span class="image-infor-name mr-2">Mazir</span>
                <span class="font-weight-light" >  Đã thêm hôm nay 16:00</span>
            </span>
            <span v-if="!showInputEdit" @click="handleShowEdit" class="info-edit">Bấm để cập nhật mô tả
                <el-icon class="info-edit-icon"><EditPen /></el-icon>
            </span>
            <span v-if="showInputEdit">
                <el-input v-model="taskForm.name" :value="taskForm.name"
                type="textarea" :rows="2" autocomplete="off" placeholder="Mô tả công việc" clearable style="display: inline-block; padding-right: 8px;" />
                <span class="name-btn">
                    <el-button color="green" style="margin-right: 8px;">Cập nhật</el-button>
                    <el-icon @click="closeEdit" class="name-icon-close close cursor-pointer"><CloseBold /></el-icon>
                </span>
            </span>

            <div>
                <el-link class="mr-2" href="#">Bình luận</el-link>
                <el-link class="mr-2" href="#">Tải về</el-link>
                <el-link class="mr-2" href="#">Lấy link</el-link>
                <el-link class="mr-2" href="#">Bỏ ảnh bìa</el-link>
                <el-link class="mr-2" href="#">Xóa</el-link>
            </div>
        </div>
    </div>
    <el-checkbox-group
        v-model="checkedFiles"
        @change="handleCheckedFilesChange"
    >
    <el-checkbox label="" size="large" />
    </el-checkbox-group>
</div>
<div v-if="!checkAll" style="display: flex; justify-content: flex-end; margin-right: 8px;">
    <el-button type="primary">Tải tất cả</el-button>
    <el-button class="ml-2"  >Chọn tất cả</el-button>
</div>
<div v-if="checkAll" style="display: flex; justify-content: flex-end; margin-right: 8px;">
    <el-button type="primary">Tải tất cả</el-button>
    <el-button type="danger" class="ml-2" >Xóa tập tin đã chọn</el-button>
    <el-button class="ml-2" >Chọn tất cả</el-button>
    <el-button class="ml-2" >Bỏ chọn tất cả</el-button>
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
.image-infor-title{
    font-weight: 800;
    color: #000;
}
.image-infor-name{
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
