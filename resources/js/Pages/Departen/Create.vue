
<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import TextInput from '@/Components/TextInput.vue';
import InputLabel from '@/Components/InputLabel.vue';
import InputError from '@/Components/InputError.vue';
import { ref, inject } from 'vue';
import request from '../../utils/request';
import { ElMessage } from 'element-plus';
import type { FormInstance } from 'element-plus';

const ruleFormRef = ref<FormInstance>()

const props = defineProps({
    department: Object,
    pageTitle: String,
});
console.log(props.department)
const getDepartment = inject('getDepartment');

const form = useForm({
    name: props.department ? props.department.name : null,
    description: props.department ? props.department.description : null,
    type: props.department ? props.department.type : null,
});

const saveDepartment = () => {
    if (!props.department) {
        form.post(route('department.store'), {
            preserveScroll: true,
            onSuccess: () => { },
            onError: () => { },
            onFinish: () => { },
        })
        return;
    }
    form.put(route('department.update', {department: props.department.id}));
}
// const saveUser = () => {
//     if (!props.user) {
//         form.post(route('user.store'), {
//             preserveScroll: true,
//             onSuccess: () => { },
//             onError: () => { },
//             onFinish: () => { },
//         })
//         return;
//     }

//     form.patch(route('user.update', {user: props.user.id}))
// }
const closeModal = () => {
    window.history.go(-1);
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white">
                <header>
                    <h3>{{ pageTitle }}</h3>
                </header>
                <form class="mt-6 space-y-6">
                    <el-form ref="ruleFormRef" :model="form" class="demo-ruleForm" :rules="rules">
                        <div>
                            <InputLabel for="name" value="Tên Phòng ban" />
                            <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name"
                                autofocus />

                            <InputError class="mt-2" :message="form.errors.name" />
                        </div>

                        <div>
                            <InputLabel for="name" value="Mô tả phòng ban" />
                            <TextInput id="description" type="text" class="mt-1 block w-full" v-model="form.description"
                                autofocus />

                            <InputError class="mt-2" :message="form.errors.description" />
                        </div>

                        <div>
                            <InputLabel for="name" value="Type" />
                            <TextInput id="type" type="number" class="mt-1 block w-full" v-model="form.type" />

                            <InputError class="mt-2" :message="form.errors.type" />
                        </div>
                    </el-form>

                    <div class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                        <div>
                            <el-button type="primary" @click="closeModal">
                                Đóng
                            </el-button>
                            <el-button type="primary" @click="saveDepartment">
                                Lưu lại
                            </el-button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>