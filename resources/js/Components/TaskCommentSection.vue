<script setup lang="ts">
import { ref } from "vue";
import { Comment } from "@element-plus/icons-vue";
const showEditCmt = ref(false);

function handleEditCmt() {
    showEditCmt.value = true;
}

function closeEditCmt() {
    showEditCmt.value = false;
}
</script>
<template>
    <div class="flex comment" style="margin-right: 8px">
        <el-icon style="margin-right: 6px" :size="25"><Comment /></el-icon>
        <el-form-item label="Bình luận:" style="display: block; width: 100%">
            <el-input
                type="textarea"
                :rows="2"
                autocomplete="off"
                placeholder="Nhập bình luận"
                clearable
                style="display: inline-block"
            />
            <el-button class="mt-2" style="margin-left: auto"
                >Gửi bình luận</el-button
            >
        </el-form-item>
        <el-icon class="comment-icon" :size="25"><Avatar /></el-icon>
    </div>

    <div class="flex" style="margin-right: 8px; margin-top: 16px">
        <el-icon style="margin-right: 6px" :size="25"><Avatar /></el-icon>
        <div style="width: 100%">
            <div v-if="!showEditCmt">
                <span>Tên tác giả bình luận</span>
                <div class="commented">Bình luận của tác giả</div>
                <div>
                    <el-link href="#">Thích</el-link>
                    <el-link href="#">Trả lời</el-link>
                    <el-link @click="handleEditCmt">Sửa</el-link>
                    <el-link href="#">Xóa</el-link>
                    <el-link href="#">Hôm nay 16:00</el-link>
                </div>
            </div>
            <el-form-item
                v-if="showEditCmt"
                style="display: block; width: 100%"
            >
                <el-input
                    value="Bình luận của tác giả"
                    type="textarea"
                    :rows="2"
                    autocomplete="off"
                    clearable
                    style="display: inline-block"
                />
                <div
                    class="flex"
                    style="
                        justify-content: space-between;
                        align-items: center;
                        width: 100%;
                        margin-top: 8px;
                    "
                >
                    <span>Nhấn Shift + Enter để gửi</span>
                    <div>
                        <el-button type="success">Cập nhật</el-button>
                        <el-icon
                            class="close"
                            style="margin-left: 4px"
                            @click="closeEditCmt"
                            size="15"
                            ><Close></Close
                        ></el-icon>
                    </div>
                </div>
            </el-form-item>
        </div>
    </div>
</template>
