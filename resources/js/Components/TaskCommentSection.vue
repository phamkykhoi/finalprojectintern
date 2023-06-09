<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { ElMessage, ElMessageBox } from "element-plus";
import request from '../utils/request';
import type { FormInstance } from 'element-plus';
import { useForm } from '@inertiajs/inertia-vue3'
import TimeAgo from 'javascript-time-ago'
import vi from 'javascript-time-ago/locale/vi'

const props = defineProps({
    taskId: {
        type: Number,
    },
    isDisabled: {
        type: Boolean,
        default: false,
    }
});

TimeAgo.addDefaultLocale(vi)

const timeAgo = new TimeAgo('vi')

const ruleFormRef = ref<FormInstance>()

const loading = ref(true)

const form = useForm({
    description: '',
    task_id: props.taskId,
});

const listComments = ref([]);

const meta = ref([])

async function getComments(nextPage) {
    loading.value = true

    await request.post(`/get-discussion-by-task-id/${props.taskId}`, { page: nextPage }).then((res) => {
        listComments.value = res.data.result.discussions.data;
        meta.value = res.data.result.meta
        loading.value = false
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
        .then(async () => {
            await request.delete(`/discussion/${commentId}`).then((res) => {
                getComments()
            })
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
    if (!listComments.value[index].description) return
    request.put(`/discussion/${discussionId}`, comment).then(res => {
        showEditCmt.value[index] = false;
    })
}

const handleCurrentChange = (page: number) => {
    getComments(page)
}

</script>

<template>
    <div>
        <div class="flex mb-5">
            <h2>Comment</h2>
            <div v-if="listComments.length>0" class="comment-quantity">{{ meta.total }}</div>
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
                        :autosize="{ minRows: 2 }"
                        autocomplete="off"
                        placeholder="Nhấn Shift + Enter để gửi"
                        clearable
                        class="inline-block"
                        :disabled="isDisabled"
                        />
                    </div>

                    <el-button class="mt-2 ml-auto" type="success" @click="handleSendComment" :disabled="isDisabled"
                    >Gửi bình luận</el-button
                    >
                </el-form-item>
            </el-form>
        </div>
    </div>
    <div v-loading="loading">
        <template v-for="(comment,index) in listComments" :key="index" >
            <div class="flex mr-2 mt-1">
                <img class="comment-img" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU" />
                <div class="w-[100%]">
                    <span>{{ comment.user }}</span>
                    <el-form-item class="d-block w-[100%]">
                        <el-input
                            v-if="showEditCmt[index]"
                            v-model="listComments[index].description"
                            type="text"
                            autosize
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
                                <el-link class="mr-2" href="#" :disabled="isDisabled">Thích</el-link>
                                <el-link class="mr-2" href="#" :disabled="isDisabled">Trả lời</el-link>
                                <el-link
                                    class="mr-2" @click="handleShowEditCmt(index)"
                                    :disabled="isDisabled">Sửa</el-link>
                                <el-link
                                    class="mr-2"
                                    @click="handleDeleteCmt(comment.id)"
                                    :disabled="isDisabled">Xóa</el-link>
                                <el-link class="mr-2" href="#">{{
                                    timeAgo.format((new Date(comment.created_at)))
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
    </div>

        <div style="text-align: center;">
            <div class="example-pagination-block">
                <el-pagination
                v-model:current-page="meta.currentPage"
                v-model:page-size="meta.perPage"
                layout="prev, pager, next"
                :total="meta.total"
                @current-change="handleCurrentChange"
                v-if="listComments.length"
                />
            </div>
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
