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

const performers = ref([]);

function getPerformers(taskId)
{
    loading.value=true
    request.get(`/api/list-performers/${taskId}`)
        .then((res) => {
            performers.value = res.data.result.listPerformers
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

function showListPerformers() 
{
    getPerformers(props.taskId);
}
</script>

<template>
    <div class="people-icon">
        <el-icon
            size="25"
            class="people-icon-avatar"
            ref="buttonListFollowers"
            v-click-outside="onClickOutside4"
            @click="showListPerformers()"
        >
            <Avatar />
        </el-icon>

        <el-popover
            :width="300"
            ref="popoverListFollowers"
            :virtual-ref="buttonListFollowers"
            trigger="click"
            virtual-triggering
            class="list-performers"
        >
        <div v-loading="loading" style="overflow-y:auto; height: auto; max-height: 300px;">
            <div v-if="performers && performers.filter(p => p.role_performer).length > 0">
                <div v-for="(performer, index) in performers" :key="index">
                    <div class="info-user info-user-close" v-if="performer.role_performer">
                    <img :src="performer.avatar" class="user-avt" />
                    <div>
                        <h6 class="info-user-item">{{ performer.email }}</h6>
                        <h6 class="info-user-item">{{ performer.name }}</h6>
                    </div>
                    </div>
                </div>
            </div>
            <div v-else>
                Không có người thực hiện
            </div>
        </div>
        </el-popover>
        <el-icon size="15" class="people-icon-remove close">
            <CircleCloseFilled />
        </el-icon>
    </div>
</template>

<style scoped>
.close {
    cursor: pointer;
}
.info-user-close {
    position: relative;
}
.btn-add-user {
    width: 100%;
}
.people-icon:hover,
.icon-plus {
    cursor: pointer;
}
.info-user-item {
    margin-left: 6px;
}
.info-user-icon {
    position: relative;
}

.icon-circle-check{
    position: absolute;
    right:20px;
}

.info {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 3px;
}
.info-user {
    display: flex;
    align-items: center;
    padding:10px 10px;
    border-radius: 5px;
    cursor: pointer;
}
.info-user:hover{
    background-color:#ccc;
}
.people-icon {
    position: relative;
}
.people-icon:hover .people-icon-remove {
    display: block;
    left: 50%;
    bottom: 70%;
}
.people-icon-remove {
    display: none;
    position: absolute;
    color: red;
}
.user-icon-star {
    position: absolute;
    right: -5%;
    bottom: -5%;
}
.user-team {
    margin-top: 16px;
    align-items: center;
    justify-content: space-between;
}
.user-add {
    display: flex;
    margin: 16px 0;
}
.user-add img {
    border-radius: 50%;
    margin-right: 8px;
}
.info-user-close {
    position: relative;
}
.user-avt{
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
}
.user-avt-small{
    width: 35px;
    height: 35px;
    object-fit: cover;
    border-radius: 50%;
}
.user-icon-close{
    float: right;
}
.sub-title{
    line-height: 14px;
}

</style>