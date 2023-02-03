<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { nextTick, ref, defineEmits, watch, reactive, onMounted, onBeforeMount } from 'vue';

const props = defineProps({
    department: {
        type: Object,
        pageTitle: String,
        // default: {name: null},
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(['closeModal']);
const closeModal = () => {
    emit('closeModal', false);
};

let users = reactive([]);

onBeforeMount(async () => {
    await axios.get(`/user/list`).then((res) => {
        users = res.data.users
    })
});
</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal">
            <form class="space-y-6 m-3">
                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Cập nhật thành viên
                    </h5>
                </div>
            <form>
                <div style="display: flex">
                    <div class="selectbox">
                        <select>
                            <option :key="index" v-for="(user, index) in users">
                                {{ user.name }}
                            </option>
                        </select>
                    </div>
                    <div class="selectbox"> 
                        <select>
                            <option>Role</option>
                            <option value="1">Root</option>
                            <option value="2">Member</option>
                        </select>
                    </div>
                    <div>
                        <button class="bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-2 border border-blue-500 hover:border-transparent rounded">
                            Thêm mới
                        </button>
                    </div>
                </div>
            </form>
                <div>
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Danh sách thành viên
                    </h5>
                </div>
                
                <div>
                    <el-tabs v-model="activeName" class="demo-tabs" @tab-click="handleClick">
                        <el-tab-pane label="User" name="first">
                            <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                        <el-tab-pane label="Config" name="second">
                             <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                        <el-tab-pane label="Role" name="third">
                            <el-table style="width: 100%">
                                <el-table-column label="ID" width="180" />
                                <el-table-column label="Name" width="180" />
                                <el-table-column label="Email" />
                            </el-table>
                        </el-tab-pane>
                    </el-tabs>
                </div>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>

<style>
    .demo-tabs > .el-tabs__content {
        padding: 0 20px;
        color: #6b778c;
        font-size: 32px;
        font-weight: 600;
    }

    .selectbox {
        margin-right: 20px;
    }
</style>
