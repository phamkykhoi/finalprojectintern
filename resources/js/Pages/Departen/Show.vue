
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import request from '../../utils/request';

const props = defineProps({
    meta: Object,
});

const form = useForm({ })

const departments = ref([]);

async function getDepartment() {
    await request.get(`/api/department`).then((res) => {
        departments.value = res.data.result.departments
    })
}

getDepartment()

const deleteDepartment = (departmentId) => {

    if (!confirm('Bạn có thực sự muốn xoá')) {
        return false;
    }

    form.delete(route('department.destroy', {department: departmentId}));
}

</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="toolbar text-right">
                <el-button type="primary" :href="route('department.create')" class="mr-20">Thêm mới Phòng ban</el-button>
            </div>
            <div class="ml-20">
            <el-table  :data="departments" stripe border style="width: 80%">
            <el-table-column prop="id" label="ID" width="100" />
            <el-table-column prop="name" label="Name" width="300" />
            <el-table-column prop="description" label="Desciption" />
            </el-table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
