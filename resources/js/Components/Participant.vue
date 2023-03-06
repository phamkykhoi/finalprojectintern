<script lang="ts" setup>
import {
    Avatar,
    CircleCheck,
    CircleCloseFilled,
    CirclePlusFilled,
    CloseBold,
    Search,
StarFilled,
} from "@element-plus/icons-vue";
import { ref, unref} from "vue";

defineProps({
    taskId: {
        type: Number,
    },
});

let participants = ref([
    {
        id: 1,
        name: "Vo Van Duc",
        email: "ducklady1610@gmail.com",
        attachment:
            "https://i.bloganchoi.com/bloganchoi.com/wp-content/uploads/2022/09/avatar-buon-2022-106.jpg?fit\u003d594%2C20000\u0026quality\u003d95\u0026ssl\u003d1",
    },
    {
        id: 2,
        name: "Ngo Quoc An",
        email: "ancncnccn@gmail.com",
        attachment:
            "http://media.vov.vn/sites/default/files/styles/large/public/2022-08/anh-nen-avatar-dep_652403.jpg",
    },
]);

const isPopoverVisible = ref(false);
const buttonRef = ref();
const buttonRef2 = ref();
const popoverRef = ref();
const popoverRef2 = ref();
const popoverRef3 = ref();
const popoverRef4 = ref();
const input3 = ref("");

function showNguoiThucHien() {
    isPopoverVisible.value = !isPopoverVisible.value;
    popoverRef.value.show();
}

const onClickOutside = () => {
    unref(popoverRef).popperRef?.delayHide?.();
};

const hidePopover = () => {
    isPopoverVisible.value = false;
    popoverRef.value.hide();
};

const onClickOutside2 = () => {
    unref(popoverRef2).popperRef2?.delayHide?.();
};

const hidePopover2 = () => {
    popoverRef2.value.hide();
};

const onClickOutside3 = () => {
    unref(popoverRef3).popperRef3?.delayHide?.();
};

const hidePopover3 = () => {
    popoverRef3.value.hide();
};

const onClickOutside4 = () => {
    unref(popoverRef4).popperRef4?.delayHide?.();
};

const hidePopover4 = () => {
    popoverRef4.value.hide();
};
const buttonRef4 = ref();
const buttonRef3 = ref();
const checked1 = ref(false);
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
            @click="showNguoiThucHien"
            ref="buttonRef"
            v-click-outside="onClickOutside"
        >
            <CirclePlusFilled />
        </el-icon>
        <el-popover
            :width="400"
            ref="popoverRef"
            :virtual-ref="buttonRef"
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
                v-model="input3"
                placeholder="Please Input"
                :suffix-icon="Search"
            />
            <p style="margin-top: 16px">THÀNH VIÊN TRONG KẾ HOẠCH</p>
            <div class="info" v-for="participant in participants">
                <div class="info-user w-[100%] mb-4">
                    <img class="user-avt-small" :src="participant.attachment"/>
                    <div>
                        <p class="info-user-item">{{ participant.email }}</p>
                        <p class="info-user-item">{{ participant.name }}</p>
                    </div>
                    <el-icon color="green" class="icon-circle-check " size="25"
                    ><CircleCheck
                /></el-icon>
                </div>
            </div>

            <el-button
                ref="buttonRef3"
                v-click-outside="onClickOutside3"
                class="btn-add-user"
                :icon="Search"
                >Thêm từ team</el-button
            >
            <el-popover
                :width="400"
                ref="popoverRef3"
                :virtual-ref="buttonRef3"
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
                        v-model="input3"
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
                            src="https://newmyxteam.blob.core.windows.net/attach/601007/17894854/202302We024328/view/VTV.jpg"
                            class="image"
                        />
                        <div>
                            <el-checkbox
                                v-model="checked1"
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

    <div>Người theo dõi (1):</div>
    <div class="people-handle" style="display: flex">
        <div class="people-icon">
            <el-icon
                size="25"
                class="people-icon-avatar"
                ref="buttonRef4"
                v-click-outside="onClickOutside4"
            >
                <Avatar />
            </el-icon>

            <el-popover
                :width="300"
                ref="popoverRef4"
                :virtual-ref="buttonRef4"
                trigger="click"
                virtual-triggering
            >
            <el-icon
                        class="user-icon-close close left-0"
                        @click="hidePopover4"
                        ><CloseBold
                    /></el-icon>
                <div class="info-user info-user-close mb-2"  v-for="participant in participants">
                    <img
                        :src="participant.attachment"
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

        <el-icon
            size="25"
            class="icon-plus"
            ref="buttonRef2"
            v-click-outside="onClickOutside2"
        >
            <CirclePlusFilled />
        </el-icon>
        <el-popover
            :width="400"
            ref="popoverRef2"
            :virtual-ref="buttonRef2"
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
                v-model="input3"
                placeholder="Please Input"
                :suffix-icon="Search"
            />
            <div
                class="flex mt-4 justify-between align-items-center flex"
            >
                <p>THÀNH VIÊN TRONG KẾ HOẠCH</p>
                <el-checkbox
                    v-model="checked1"
                    label="Chọn tất cả"
                    size="large"
                />
            </div>
            <div class="info" v-for="participant in participants">
                <div class="info-user">
                    <div class="info-user-icon">
                        <img
                        :src="participant.attachment"
                        class="user-avt-small"
                    />
                        <el-icon class="user-icon-star" :size="20" color="blue"
                            ><StarFilled
                        /></el-icon>
                    </div>
                    <div>
                        <p class="info-user-item">{{ participant.email }}</p>
                        <p class="info-user-item">{{ participant.name }}</p>
                    </div>
                </div>
                <el-icon color="orange" class="icon-circle-check" size="25"
                    ><CircleCheck
                /></el-icon>
            </div>
            <el-button color="green" class="btn-add-user">Cập nhật</el-button>
            <el-button
                style="margin: 6px 0px"
                ref="buttonRef3"
                v-click-outside="onClickOutside3"
                class="btn-add-user"
                :icon="Search"
                >Thêm từ team</el-button
            >
        </el-popover>
    </div>
</template>
<style>
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
    right:10px;
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
    right: 3%;
    bottom: 3%;
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
</style>
