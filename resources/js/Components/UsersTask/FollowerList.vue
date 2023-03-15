<script setup lang="ts">
import {Avatar, CircleCheck, CircleCloseFilled, CloseBold } from "@element-plus/icons-vue";
import { ref, unref, onBeforeMount} from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'
import { ElMessage } from 'element-plus';
import request from '../../utils/request';

const props = defineProps({
    taskId: Number,
})
const buttonListFollowers = ref();
const popoverListFollowers = ref();
const onClickOutside4 = () => {
    unref(popoverListFollowers).popoverListFollowers?.delayHide?.();
};
const hidePopover4 = () => {
    popoverListFollowers.value.hide();
};
const loading = ref(false)

const participants = ref([]);

function getUser(taskId)
{
    loading.value=true
    request.get(`/api/followers/${props.taskId}`)
        .then((res) => {
            participants.value = res.data.result.listsUser
            loading.value=false
        })
        .catch(err => {
            ElMessage({
                showClose: true,
                message: err.response.data.message,
                type: 'error',
            })
            loading.value=false;
        })
}

onBeforeMount(async () => {
    getUser(props.taskId);
});

</script>

<template>
    <div class="people-icon">
        <el-icon
            size="25"
            class="people-icon-avatar"
            ref="buttonListFollowers"
            v-click-outside="onClickOutside4"
        >
            <Avatar />
        </el-icon>

        <el-popover
            :width="300"
            ref="popoverListFollowers"
            :virtual-ref="buttonListFollowers"
            trigger="click"
            virtual-triggering
        >
        <el-icon
                    class="user-icon-close close left-0"
                    @click="hidePopover4"
                    ><CloseBold
                /></el-icon>
            <div class="info-user info-user-close"  v-for="(participant, index) in participants" :key="index">
                <img
                    src="https://i.bloganchoi.com/bloganchoi.com/wp-content/uploads/2022/09/avatar-buon-2022-106.jpg?fit\u003d594%2C20000\u0026quality\u003d95\u0026ssl\u003d1"
                    class="user-avt"
                />
                <div>
                    <h6 class="info-user-item">{{ participant.email }}</h6>
                    <h6 class="info-user-item">{{ participant.name }}</h6>
                </div>

            </div>

        </el-popover>
        <el-icon size="15" class="people-icon-remove close">
            <CircleCloseFilled />
        </el-icon>
    </div>
</template>