<script lang="ts" setup>
import FollowerList from "@/Components/UsersTask/FollowerList.vue"
import {
    Avatar,
    CircleCheck,
    CircleCloseFilled,
    CirclePlusFilled,
    CloseBold,
    Search,
StarFilled,
} from "@element-plus/icons-vue";
import request from '../utils/request';
import { ElMessage } from 'element-plus';
import { ref, unref, onBeforeMount} from "vue";

const props = defineProps({
    taskId: {
        type: Number,
    },
});

const isPopoverVisible = ref(false);
const buttonSearchParticipants = ref();
const buttonInviteParticipants = ref();
const buttonSearchFollowers = ref();
const buttonListFollowers = ref();
const popoverSearchParticipants = ref();
const popoverSearchFollowers = ref();
const popoverInviteParticipants = ref();
const popoverListFollowers = ref();
const popoverInviteFollowers = ref();
const buttonInviteFollowers = ref();
const inputSearchParticipant = ref("");
const inputInviteParticipant = ref("");
const inputSearchFollowers = ref("");
const inputInviteFollowers = ref("");
const checkAllowFollowers = ref(false);
const checkAllSearchFollowers = ref(false);
const checkAllowParticipants = ref(false);

function showParticipants() {
    isPopoverVisible.value = !isPopoverVisible.value;
    popoverSearchParticipants.value.show();
}

const onClickOutside = () => {
    unref(popoverSearchParticipants).popoverSearchParticipants?.delayHide?.();
};

const hidePopover = () => {
    isPopoverVisible.value = false;
    popoverSearchParticipants.value.hide();
};

const onClickOutside2 = () => {
    unref(popoverSearchFollowers).popoverSearchFollowers?.delayHide?.();
};

const hidePopover2 = () => {
    popoverSearchFollowers.value.hide();
};

const onClickOutside3 = () => {
    unref(popoverInviteParticipants).popoverInviteParticipants?.delayHide?.();
};

const hidePopover3 = () => {
    popoverInviteParticipants.value.hide();
};

const onClickOutside4 = () => {
    unref(popoverListFollowers).popoverListFollowers?.delayHide?.();
};

const hidePopover4 = () => {
    popoverListFollowers.value.hide();
};

const onClickOutside5 = () => {
    unref(popoverInviteFollowers).popoverInviteFollowers?.delayHide?.();
};

const hidePopover5 = () => {
    popoverInviteFollowers.value.hide();
};

const handleUpdate = () =>{
    hidePopover2();
}
const loading = ref(false)

const participants = ref([]);
const users = ref([]);

function getUsers()
{
    loading.value=true
    request.get(`/api/list-followers-in-task`).then((res) => {
            users.value = res.data.result.listFollowers
            loading.value=false
            countFollowers(users)
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
    getUsers()
});

function assginMember(user)
{
    const members = {
        user_id: user.id,
        task_id: props.taskId,
        role_task: 2, // 
    }
    request.post(`/assign-followers/${props.taskId} `, members).then((res)=>{
        ElMessage({
            showClose: true,
            message: 'Assign members successfully',
            type: 'success',
        })
        getUsers()
        countFollowers(users)
    }).catch(err => {
        ElMessage({
            showClose: true,
            message: err.response.data.message,
            type: 'error',
            })
        })
}

const total = ref(0)
function countFollowers(users)
{
    let follower = users.value.filter(function (user)
        {
            return user.role_task == 2
        });
        total.value = follower.length
}

</script>
<template>
    <div>Người thực hiện:</div>
    <div class="people-handle" style="display: flex">
        <div class="people-icon">
            <el-icon size="25" class="people-icon-avatar">
                <Avatar />
            </el-icon>
            <el-icon size="15" class="people-icon-remove close">
                <CircleCloseFilled />
            </el-icon>
        </div>

        <el-icon
            size="25"
            class="icon-plus"
            @click="showParticipants"
            ref="buttonSearchParticipants"
            v-click-outside="onClickOutside"
        >
            <CirclePlusFilled />
        </el-icon>
        <el-popover
            :width="400"
            :height="400"
            ref="popoverSearchParticipants"
            :virtual-ref="buttonSearchParticipants"
            :trigger="'click'"
            virtual-triggering
            :visible="isPopoverVisible"
        >
            <div class="form-add-user flex">
                <span>Chọn người thực hiện</span>
                <el-icon
                    class="close ml-auto mb-2"
                    size="large"
                    @click="hidePopover"
                    ><CloseBold
                /></el-icon>
            </div>
            <el-input
                v-model="inputSearchParticipant"
                placeholder="Please Input"
                :suffix-icon="Search"
            />
            <p class="mt-4 sub-title">THÀNH VIÊN TRONG KẾ HOẠCH</p>
            <div style="overflow-y: scroll; height: 155px;">
                <el-row class="info" v-for="(user, index) in users" :key="index" :span="24">
                    <div class="info-user w-[100%]">
                        <el-col class="info-user-icon" :span="3">
                            <img
                            :src="user.avatar"
                            class="user-avt-small"
                        />
                            <el-icon class="user-icon-star" :size="20" color="blue"><StarFilled/></el-icon>
                        </el-col>
                        <el-col :span="21">
                            <el-row>
                                <el-col :span="18">
                                    <p class="info-user-item">{{ user.email }}</p>
                                    <p class="info-user-item">{{ user.name }}</p>
                                </el-col>
                                <el-col style="position: relative;" :span="3"  v-if="user.role_task == 1">
                                    <el-icon color="green" class="icon-circle-check " size="25"><CircleCheck/></el-icon>
                                </el-col>
                            </el-row>
                        </el-col>
                    </div>
                </el-row>
            </div>
            <el-button
                ref="buttonInviteParticipants"
                v-click-outside="onClickOutside3"
                class="btn-add-user"
                :icon="Search"
                >Thêm từ team</el-button
            >
            <el-popover
                :width="400"
                ref="popoverInviteParticipants"
                :virtual-ref="buttonInviteParticipants"
                trigger="click"
                virtual-triggering
                placement="right-start"
            >
                <div>
                    <div class="form-add-user flex">
                        <span>Mời thành viên</span>
                        <el-icon
                            class="close ml-auto mb-2"
                            size="large"
                            @click="hidePopover3"
                            ><CloseBold
                        /></el-icon>
                    </div>
                    <el-input
                        v-model="inputInviteParticipant"
                        placeholder="Please Input"
                        :suffix-icon="Search"
                    />
                    <div class="flex user-team">
                        <p>THÀNH VIÊN TEAM</p>
                        <span>
                            <el-button size="small">Bỏ chọn tất cả</el-button>
                            <el-button size="small" color="green"
                                >Chọn tất cả</el-button
                            >
                        </span>
                    </div>
                    <div class="user-add">
                        <img
                            src="https://workdone.myxteam.com/img/member-invite.864af677.png"
                            class="image"
                        />
                        <div>
                            <el-checkbox
                                v-model="checkAllowParticipants"
                                label="Cho phép theo dõi công việc đã có?"
                                size="large"
                            />
                            <el-button color="green" class="btn-add-user"
                                >Cập nhật</el-button
                            >
                        </div>
                    </div>
                    <span style="color: red"
                        >* Nếu thành viên chưa có trong Team, vui lòng vào Quản
                        lý thành viên kế hoạch hoặc Quản lý thành viên team mời
                        vào trước</span
                    >
                </div>
            </el-popover>
        </el-popover>
    </div>

    <div>Người theo dõi ({{ total }}):</div>
    <div class="people-handle" style="display: flex">
        <FollowerList :taskId="props.taskId" />
        <el-icon
            size="25"
            class="icon-plus"
            ref="buttonSearchFollowers"
            v-click-outside="onClickOutside2"
        >
            <CirclePlusFilled />
        </el-icon>
        <el-popover
            :width="400"
            :height="400"
            ref="popoverSearchFollowers"
            :virtual-ref="buttonSearchFollowers"
            trigger="click"
            virtual-triggering
        >
            <div class="form-add-user flex">
                <span>Chọn người theo dõi</span>
                <el-icon
                    class="close ml-auto mb-2"
                    size="large"
                    @click="hidePopover2"
                    ><CloseBold
                /></el-icon>
            </div>
            <el-input
                v-model="inputSearchFollowers"
                placeholder="Please Input"
                :suffix-icon="Search"
            />
            <div
                class="flex mt-4 justify-between align-items-center flex"
            >
                <p class="mt-4 sub-title">THÀNH VIÊN TRONG KẾ HOẠCH</p>
                <el-checkbox
                    v-model="checkAllSearchFollowers"
                    label="Chọn tất cả"
                    size="large"
                />
            </div>
            <div style="overflow-y: scroll; height: 155px;">
                <el-row class="info" v-for="(user, index) in users" :key="index" :span="24" @click="assginMember(user)">
                    <div class="info-user w-[100%]">
                        <el-col class="info-user-icon" :span="3">
                            <img
                            :src="user.avatar"
                            class="user-avt-small"
                        />
                            <el-icon class="user-icon-star" :size="20" color="blue"
                                ><StarFilled
                            /></el-icon>
                        </el-col>
                        <el-col :span="21">
                            <el-row>
                                <el-col :span="18">
                                    <p class="info-user-item">{{ user.email }}</p>
                                    <p class="info-user-item">{{ user.name }}</p>
                                </el-col>
                                <el-col style="position: relative;" :span="3" v-if="user.role_task == 2">
                                    <el-icon color="green" class="icon-circle-check " size="25"><CircleCheck/></el-icon>
                                </el-col>
                            </el-row>
                        </el-col>
                    </div>
                </el-row>
            </div>
            <el-button color="green" style="place-content: center; margin-top: 10px;" class="btn-add-user" @click="handleUpdate">Cập nhật</el-button>
            <el-button
                style="margin: 6px 0px"
                ref="buttonInviteFollowers"
                v-click-outside="onClickOutside5"
                class="btn-add-user"
                :icon="Search"
                >Thêm từ team</el-button
            >
            <el-popover
                :width="400"
                ref="popoverInviteFollowers"
                :virtual-ref="buttonInviteFollowers"
                trigger="click"
                virtual-triggering
                placement="right-start"
            >
                <div>
                    <div class="form-add-user flex">
                        <span>Mời thành viên</span>
                        <el-icon
                            class="close ml-auto mb-2"
                            size="large"
                            @click="hidePopover5"
                            ><CloseBold
                        /></el-icon>
                    </div>
                    <el-input
                        v-model="inputInviteFollowers"
                        placeholder="Please Input"
                        :suffix-icon="Search"
                    />
                    <div class="flex user-team">
                        <p>THÀNH VIÊN TEAM</p>
                        <span>
                            <el-button size="small">Bỏ chọn tất cả</el-button>
                            <el-button size="small" color="green"
                                >Chọn tất cả</el-button
                            >
                        </span>
                    </div>
                    <div class="user-add">
                        <img
                            src="https://workdone.myxteam.com/img/member-invite.864af677.png"
                            class="image"
                        />
                        <div>
                            <el-checkbox
                                v-model="checkAllowFollowers"
                                label="Cho phép theo dõi công việc đã có?"
                                size="large"
                            />
                            <el-button color="green" class="btn-add-user">Cập nhật</el-button>
                        </div>
                    </div>
                    <span style="color: red"
                        >* Nếu thành viên chưa có trong Team, vui lòng vào Quản
                        lý thành viên kế hoạch hoặc Quản lý thành viên team mời
                        vào trước</span
                    >
                </div>
            </el-popover>
        </el-popover>
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
