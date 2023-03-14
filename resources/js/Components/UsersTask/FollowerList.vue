<script setup lang="ts">
import {Avatar, CircleCheck, CircleCloseFilled, CloseBold } from "@element-plus/icons-vue";
import { ref, unref } from 'vue'
import { ClickOutside as vClickOutside } from 'element-plus'

const buttonListFollowers = ref();
const popoverListFollowers = ref();
const onClickOutside4 = () => {
    unref(popoverListFollowers).popoverListFollowers?.delayHide?.();
};

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
            <div class="info-user info-user-close"  v-for="participant in participants">
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
</template>