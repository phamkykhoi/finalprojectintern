
<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm } from '@inertiajs/inertia-vue3';

const props = defineProps({
    users: Array,
    meta: Object,
});

const form = useForm({ })

const deleteUser = (userId) => {

    if (!confirm('Bạn có thực sự muốn xoá')) {
        return false;
    }

    form.delete(route('user.destroy', {user: userId}));
}


</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12">
            <div class="toolbar text-right">
                <el-link type="primary" :href="route('user.create')" target="_blank">Thêm mới thành viên</el-link>
            </div>

            <el-table :data="users" style="width: 100%" class="ml-20">
                <el-table-column prop="name" label="Tên" width="550" />
                <el-table-column prop="email" label="Email" width="550" />
                <el-table-column prop="created_at" label="Ngày tạo" width="550" />
                <el-table-column fixed="right" label="Actions" width="200">
                <template #default="scope">
                    <el-link type="primary" :href="route('user.edit', {user: scope.row.id})" target="_blank">Sửa</el-link>
                    <el-button @click="deleteUser(scope.row.id)" link type="primary" size="small">Xóa</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
