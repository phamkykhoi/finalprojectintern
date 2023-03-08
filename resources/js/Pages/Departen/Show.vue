
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';
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
                <Link :href="route('department.create')">Thêm mới Phòng ban</Link>
            </div>

            <table class="table-auto border-2 w-full" border="1">
                <thead>
                    <tr>
                        <th>Tên Phòng ban</th>
                        <th>Mô tả</th>
                        <th>Type</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-2" :key="index" v-for="(department, index) in departments">
                        <td class="border-2">{{ department.name }}</td>
                        <td class="border-2">{{ department.description }}</td>
                        <td class="border-2">{{ department.type }}</td>
                        <td class="border-2">
                            <Link :href="route('department.edit', {department: department.id})">Sửa</Link>
                        </td>
                        <td class="border-2"><a href="#" @click="deleteDepartment(department.id)">Xoá</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
