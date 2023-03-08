<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { ElMessage, ElMessageBox } from "element-plus";
import request from '../utils/request';
import type { FormInstance } from 'element-plus';
import { useForm } from '@inertiajs/inertia-vue3'

const ruleFormRef = ref<FormInstance>()

const props = defineProps({
    taskId: {
        type: Number,
    },
});

const form = useForm({
    description: '',
    task_id: props.taskId,
});

const listComments = ref([]);

const limit = ref(3)

async function getComments() {
    await request.post(`/get-discussion-by-task-id/${props.taskId}`).then((res) => {
        listComments.value = res.data.result.discussions.reverse();
    })
}

getComments()

const showEditCmt = ref(new Array(listComments.value.length).fill(false));

document.addEventListener("keydown", function (event) {
    if (event.shiftKey && event.keyCode === 13) {
        handleSendComment();
    }
});

const oldComment = ref([])

function handleShowEditCmt(index) {
    showEditCmt.value[index] = true;
    oldComment.value[index] = listComments.value[index].description
}

function closeEditCmt(index) {
    listComments.value[index].description = oldComment.value[index]
    showEditCmt.value[index] = false;
}

function handleDeleteCmt(commentId) {
    ElMessageBox.confirm("Are you sure you want to delete this comment?", {
        confirmButtonText: "OK",
        cancelButtonText: "Cancel",
        type: "warning",
    })
        .then(() => {
            listComments.value = listComments.value.filter(
                (comment) => comment.id != commentId
            );
            ElMessage({
                type: "success",
                message: "Delete completed",
            });
        })
        .catch(() => {
            ElMessage({
                type: "info",
                message: "Delete canceled",
            });
        });
}

const handleSendComment = () => {
    if (!form.description) return
    request.post(`/discussion`, form).then(res => {
        form.description = "";
        getComments()
    })
}

const handleSaveEdit = (discussionId, comment, index) => {
    request.put(`/discussion/${discussionId}`, comment).then(res => {
        showEditCmt.value[index] = false;
    })
}

function showMore(){
    limit.value+=2
}

function hideComments(){
    limit.value = 3
}

</script>

<template>
    <div>
        <div class="flex mb-5">
            <h2>Comment</h2>
            <div v-if="listComments.length>0" class="comment-quantity">{{ listComments.length }}</div>
        </div>
        
        <div class="flex comment mr-2">
            <el-form ref="ruleFormRef" :model="form" class="demo-ruleForm w-[100%]">
                <el-form-item class="w-[100%]">
                    <div class="flex w-[100%]">
                        <!-- Current user avt -->
                        <img
                        class="comment-img"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU"
                        />
                        <el-input
                        v-model="form.description"
                        type="textarea"
                        :rows="2"
                        autocomplete="off"
                        placeholder="Nhấn Shift + Enter để gửi"
                        clearable
                        class="inline-block"
                        />
                    </div>
                    
                    <el-button class="mt-2 ml-auto" type="success" @click="handleSendComment"
                    >Gửi bình luận</el-button
                    >
                </el-form-item>
            </el-form>
        </div>
    </div>

    <template v-for="(comment,index) in listComments" :key="index" >
        <div v-if="index < limit" class="flex mr-2 mt-1">
            <img class="comment-img" :src="comment.attachment" />
            <div class="w-[100%]">
                <span>{{ comment.user }}</span>
                <el-form-item class="d-block w-[100%]">
                    <el-input
                        v-if="showEditCmt[index]"
                        v-model="listComments[index].description"
                        type="textarea"
                        :rows="2"
                        autocomplete="off"
                        class="d-inline-block w-[100%] cursor-pointer"
                    />
                    <div
                        class="border w-[100%] h-[60%] bg-white"
                        v-if="!showEditCmt[index]"
                    >
                        <span class="mt-4 mx-3">{{ comment.description }}</span>
                    </div>
                    <div class="flex w-[100%] mt-1">
                        <div class="w-[70%]">
                            <el-link class="mr-2" href="#">Thích</el-link>
                            <el-link class="mr-2" href="#">Trả lời</el-link>
                            <el-link class="mr-2" @click="handleShowEditCmt(index)"
                                >Sửa</el-link
                            >
                            <el-link
                                class="mr-2"
                                @click="handleDeleteCmt(comment.id)"
                                >Xóa</el-link
                            >
                            <el-link class="mr-2" href="#">{{
                                comment.created_at
                            }}</el-link>
                        </div>

                        <div
                            v-if="showEditCmt[index]"
                            class="flex justify-content-between align-items-center ml-auto"
                        >
                            <div>
                                <el-button type="success" @click="handleSaveEdit(comment.id, comment, index)">Cập nhật</el-button>
                                <el-button type="danger" @click="closeEditCmt(index)"
                                    >Hủy</el-button
                                >
                            </div>
                        </div>
                    </div>
                </el-form-item>
            </div>
        </div>
    </template>
        <div style="text-align: center;">
            <el-link v-if="limit < listComments.length" @click="showMore">Xem thêm</el-link>
            <el-link v-else @click="hideComments">Ẩn bớt</el-link>
        </div>
        
</template>
<style>
.comment-img {
    width: 30px;
    height: 30px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 10px;
}
.comment-quantity{
    width: 20px;
    height: 20px;
    border-radius: 50%;
    font-size: 15px;
    text-align: center;
    line-height:20px;
    margin-left: 10px;
    background-color:#ccc;
}
</style>
