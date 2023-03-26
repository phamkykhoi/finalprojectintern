<script setup>

import DepartenUserForm from '@/Pages/Departen/User.vue';
import ActivityUserForm from '@/Pages/Activity/User.vue';
import EditDepartmentForm from '@/Pages/Departen/Edit.vue';
import EditActivityForm from '@/Pages/Activity/Edit.vue';
import { Setting, CirclePlus, Avatar, More, Tools, Star, ChatSquare, Edit} from '@element-plus/icons-vue';
import Dropdown from '@/Components/Dropdown.vue';
import { Link } from '@inertiajs/inertia-vue3';
import ActivityForm from '@/Pages/Activity/Form.vue';
import { reactive, ref } from 'vue';

defineProps({
    departments: Array,
    activityId: Number,
});

const showFormActivity = ref(false);
const state = reactive({
    department: null,
    activity: null,
})

const createActivityForm = (currentDepartment) => {
    showFormActivity.value = true;
    state.department = currentDepartment
}

const closeFormActivity = (value) => {
    showFormActivity.value = value;
}
const showFormDepartment = ref(false);


const showFormEditActivity = ref(false);

const editActivityForm = (currentActivity) => {
    showFormEditActivity.value = true;
    state.activity = currentActivity
}

const closeFormEditActivity = (value) => {
    showFormEditActivity.value = value;
}

const showFormEditDepartment = ref(false);

const editDepartmentForm = (currentDepartment) => {
    showFormEditDepartment.value = true;
    state.department = currentDepartment
}

const closeFormEditDepartment = (value) => {
    showFormEditDepartment.value = value;
}

const showFormDepartmentUser = ref(false);

const createDepartmentUserForm = (currentDepartment) => {
    showFormDepartmentUser.value = true;
    state.department = currentDepartment
}
const closeFormDepartmentUser = (value) => {
    showFormDepartmentUser.value = value;
}

const showFormActivityUser = ref(false);

const createActivityUserForm = (currentActivity) => {
    showFormActivityUser.value = true;
    state.activity = currentActivity
}
const closeFormActivityUser = (value) => {
    showFormActivityUser.value = value;
}

</script>

<template>
    <div style="z-index: 999999;">
        <aside class="flex-shrink-0 hidden w-64 bg-white border-r dark:border-primary-darker dark:bg-darker md:block">
            <div class="flex flex-col h-full flex-hull">
                <div class="h-16 border-b border-gray-100 hidden space-x-8 sm:flex">
                    <h3
                        class='text-lg font-bold pl-2 inline-flex items-center w-full border-indigo-400 font-medium leading-5 text-gray-900 transition duration-150 ease-in-out' style="position:fixed; margin-top:-13px; height: 76px;">
                        &nbsp; Công việc của Tôi</h3>
                </div>

                <nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto" style="background-color:rgb(160, 160, 160);">
                    <div :key="index" v-for="(department, index) in departments">
                        <a href="#"
                            class="font-bold flex items-center transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                            role="button" aria-haspopup="true">
                            <span aria-hidden="true">
                                <a href="#" data-bs-toggle="dropdown"><i class="bi bi-gear"></i></a>
                            </span>
                            <span class="ml-2">{{ department.name }}</span>
                           <span class="ml-auto" aria-hidden="true">
                                <Dropdown align="right">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <button type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150; style=background:rgb(160, 160, 160);">
                                                <SettingIcon />
                                            </button>
                                        </span>
                                    </template>
                                    <template #content>
                                        <div class="flex" style="align-items: center;">
                                            <a @click="createActivityForm(department)"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                                <el-icon class="icon-action"><CirclePlus /></el-icon>
                                                <i class="bi bi-plus-lg"></i>Tạo hoạt động
                                            </a>
                                        </div>
                                        <div class="flex" style="align-items: center;">
                                            <a @click="createDepartmentUserForm(department)"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                                <el-icon class="icon-action"><Avatar /></el-icon>
                                                <i class="bi bi-plus-lg"></i>Quản lý thành viên
                                            </a>
                                        </div>
                                        <div class="flex" style="align-items: center;">
                                            <a @click="editDepartmentForm(department)"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out">
                                                <el-icon class="icon-action"><Setting /></el-icon>
                                                <i class="bi bi-plus-lg"></i>Cài đặt
                                            </a>
                                        </div>
                                    </template>
                                </Dropdown>
                            </span>
                        </a>

                        <div :key="index" v-for="(activity, index) in department.activities" role="acitivities"
                            x-show="open" class="space-y-2 pl-6 " aria-label="acitivities">
                            <div class="flex activity-link">
                            <Link :href="route('activity.show', {activity: activity.id})"
                                v-bind:class="{'bg-gray-200': activityId == activity.id}"
                                class="block py-2 pl-3 pr-4 my-1 transition-colors duration-200 rounded-md dark:text-light dark:hover:text-light hover:text-gray-700 w-[120%]">
                                <!-- {{ activity.name }}  -->
                                    <span class=" truncate w-[90%] block" style="font-size:14px">{{ activity.name }}</span>
                            </Link>
                            <Dropdown class="activity-setting duration-100">
                                    <template #trigger>
                                        <span class="inline-flex rounded-md">
                                            <el-icon class="float-right mt-3.5 cursor-pointer "><Tools /></el-icon>
                                        </span>
                                    </template>
                                    <template #content>
                                        <div class="flex" style="align-items: center;">
                                            <a @click="createActivityUserForm(activity)"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out cursor-pointer">
                                                <el-icon class="icon-action"><Avatar /></el-icon>
                                                <i class="bi bi-plus-lg"></i>Quản lý thành viên
                                            </a>
                                        </div>
                                        <div class="flex" style="align-items: center;">
                                            <a @click="editActivityForm(activity)"
                                            class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out cursor-pointer">
                                                <el-icon class="icon-action"><Edit /></el-icon>
                                                <i class="bi bi-plus-lg"></i>Chỉnh sửa
                                            </a>
                                        </div>
                                    </template>
                                </Dropdown>
                        </div>
                        </div>
                    </div>
                </nav>
            </div>
        </aside>

        <ActivityForm v-if="showFormActivity"
            :department="state.department"
            :isShowModal="showFormActivity"
            v-on:closeModal="closeFormActivity" />

        <ActivityUserForm v-if="showFormActivityUser" :activity="state.activity"
            :isShowModal="showFormActivityUser" v-on:closeModal="closeFormActivityUser" />
        <DepartenUserForm v-if="showFormDepartmentUser" :department="state.department"
            :isShowModal="showFormDepartmentUser" v-on:closeModal="closeFormDepartmentUser" />
        <EditDepartmentForm v-if="showFormEditDepartment" :department="state.department"
        :isShowModal="showFormEditDepartment" v-on:closeModal="closeFormEditDepartment" />
        <EditActivityForm v-if="showFormEditActivity" :activity="state.activity"
        :isShowModal="showFormEditActivity" v-on:closeModal="closeFormEditActivity" />
    </div>
</template>

<style>
    .flex-hull {
        padding-left: 54px;
        position: fixed;
        width:261px;
    }

    .icon-action {
        font-size: 1.2rem;
        vertical-align: middle;
        margin-right: 0.3rem;
    }
    .activity-link:hover .activity-setting {
        opacity: 1;
    }
    .activity-setting{
        opacity: 0;
        transition: opacity 0.1s ease-in-out;
        position: absolute;
        right: 15px;
    }
    .activity-name{
        width:200px;
    }
</style>
