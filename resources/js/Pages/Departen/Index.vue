<script setup>

import DepartenUserForm from '@/Pages/Departen/User.vue';
import SettingIcon from '@/Components/Icons/SettingIcon.vue';
import PlusIcon from '@/Components/Icons/PlusIcon.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import { Link } from '@inertiajs/inertia-vue3';
import ActivityForm from '@/Pages/Activity/Form.vue';
import { reactive, ref } from 'vue';

defineProps({
    departments: Array,
    activityId: Number,
});

const showFormActivity = ref(false);
const state  = reactive({
    department: null
})

const createActivityForm = (currentDepartment) => {
    showFormActivity.value = true;
    state.department = currentDepartment
}

const closeFormActivity = (value) => {
    showFormActivity.value = value;
}
const showFormDepartment = ref(false);

const editDepartmentForm = (currentDepartment) => {
    showFormDepartment.value = true;
    state.department = currentDepartment
}

const closeFormDepartment = (value) => {
    showFormDepartment.value = value;
}

const showFormDepartmentUser = ref(false);

const createDepartmentUserForm = (currentDepartment) => {
    showFormDepartmentUser.value = true;
    state.department = currentDepartment
}
const closeFormDepartmentUser = (value) => {
    showFormDepartmentUser.value = value;
}

</script>

<template>
<div>
    <aside class="flex-shrink-0 hidden w-64 bg-white border-r dark:border-primary-darker dark:bg-darker md:block">
        <div class="flex flex-col h-full">
            <div class="h-16 border-b border-gray-100 hidden space-x-8 sm:flex">
                <h3 class='text-lg font-bold pl-2 inline-flex items-center w-full border-indigo-400 font-medium leading-5 text-gray-900 transition duration-150 ease-in-out'>&nbsp; Công việc của Tôi</h3>
            </div>

            <nav aria-label="Main" class="flex-1 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto">
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
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                            <SettingIcon />
                                        </button>
                                    </span>
                                </template>
                                <template #content>
                                    <a @click="createActivityForm(department)" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="bi bi-plus-lg"></i>Tạo hoạt động</a>
                                    <a @click="createDepartmentUserForm(department)" class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 transition duration-150 ease-in-out"><i class="bi bi-plus-lg"></i>Quản lý thành viên</a>
                                </template>
                            </Dropdown>
                        </span>
                    </a>

                    <div :key="index" v-for="(activity, index) in department.activities" role="acitivities" x-show="open" class="space-y-2 px-7" aria-label="acitivities">
                        <Link :href="route('activity.show', {activity: activity.id})" v-bind:class="{'bg-gray-200': activityId == activity.id}" class="block p-1 transition-colors duration-200 rounded-md dark:text-light dark:hover:text-light hover:text-gray-700">
                            {{ activity.name }}
                        </Link>
                    </div>
                </div>
            </nav>
        </div>
    </aside>

    <ActivityForm :departmentId="state.department" :isShowModal="showFormActivity" v-on:closeModal="closeFormActivity" />
    <DepartenUserForm :department="state.department" :isShowModal="showFormDepartmentUser" v-on:closeModal="closeFormDepartmentUser" />
</div>
</template>
