<script lang="ts" setup>
import { ref } from "vue";
import { ElMessage, ElMessageBox } from "element-plus";

defineProps({
    taskId: {
        type: Number,
    },
});

const showEditCmt = ref(false);
const currentCmt = ref("");
let listComments = ref([
    {
        id: 1,
        user: "Admin",
        description: "Hãy xóa task này đi nhé",
        created_at: "16:00:00",
        attachment:
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU",
    },
    {
        id: 2,
        user: "John",
        description: "Ok admin",
        created_at: "16:20:00",
        attachment:
            "https://i.bloganchoi.com/bloganchoi.com/wp-content/uploads/2022/09/avatar-buon-2022-20-696x728.jpg?fit=700%2C20000&quality=95&ssl=1",
    },
]);

document.addEventListener("keydown", function (event) {
    if (event.shiftKey && event.keyCode === 13) {
        handleSendComment();
    }
});

function handleEditCmt() {
    showEditCmt.value = true;
}

function closeEditCmt() {
    showEditCmt.value = false;
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

    if (!currentCmt.value) {
        ElMessage({
            showClose: true,
            message: "Bạn không thể để trống comment",
            type: "error",
        });
    }else{
        listComments.value.push({
        id: Math.floor(Math.random() * 10),
        user: "Admin",
        description: currentCmt.value,
        created_at: "21:00:30",
        attachment:
            "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU",
    });
        ElMessage({
        showClose: true,
        message: "Bạn đã đăng comment thành công!",
        type: "success",
    });
    }

    currentCmt.value = "";
};
</script>

<template>
    <div>
        <div class="flex mb-5">
            <h2>Comment</h2>
            <div v-if="listComments.length>0" class="comment-quantity">{{ listComments.length }}</div>
        </div>
        <div class="flex comment mr-2">
            <el-form-item class="w-[100%]">
                <div class="flex w-[100%]">
                    <!-- Current user avt -->
                    <img
                        class="comment-img"
                        src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcShN0nuLT7HIpIANuDi6wbMKpeuCgZsl2PtAA&usqp=CAU"
                    />
                    <el-input
                        v-model="currentCmt"
                        type="textarea"
                        :rows="2"
                        autocomplete="off"
                        placeholder="Nhấn Shift + Enter để gửi"
                        clearable
                        class="inline-block"
                    />
                </div>

                <el-button class="mt-2 ml-auto" @click="handleSendComment"
                    >Gửi bình luận</el-button
                >
            </el-form-item>
        </div>
    </div>

    <div v-for="comment in listComments" class="flex mr-2 mt-1">
        <img class="comment-img" :src="comment.attachment" />
        <div class="w-[100%]">
            <span>{{ comment.user }}</span>
            <el-form-item class="d-block w-[100%]">
                <el-input
                    v-if="showEditCmt"
                    v-model="comment.description"
                    type="textarea"
                    :rows="2"
                    autocomplete="off"
                    class="d-inline-block w-[100%] cursor-pointer"
                />
                <div
                    class="border w-[100%] h-[60%] bg-white"
                    v-if="!showEditCmt"
                >
                    <span class="mt-4 mx-3">{{ comment.description }}</span>
                </div>
                <div class="flex w-[100%] mt-1">
                    <div class="w-[50%]">
                        <el-link class="mr-2" href="#">Thích</el-link>
                        <el-link class="mr-2" href="#">Trả lời</el-link>
                        <el-link class="mr-2" @click="handleEditCmt"
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
                        v-if="showEditCmt"
                        class="flex justify-content-between align-items-center ml-auto"
                    >
                        <div>
                            <el-button type="success">Cập nhật</el-button>
                            <el-button type="danger" @click="closeEditCmt"
                                >Hủy</el-button
                            >
                        </div>
                    </div>
                </div>
            </el-form-item>
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
