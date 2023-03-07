
<script setup>
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
                <Link :href="route('user.create')">Thêm mới thành viên</Link>
            </div>

            <table class="table-auto border-2 w-full" border="1">
                <thead>
                    <tr>
                        <th>Tên thành viên</th>
                        <th>Email</th>
                        <th>Ngày tạo</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-2" :key="index" v-for="(user, index) in users">
                        <td class="border-2">{{ user.name }}</td>
                        <td class="border-2">{{ user.email }}</td>
                        <td class="border-2">{{ user.created_at }}</td>
                        <td class="border-2">
                            <Link :href="route('user.edit', {user: user.id})">Sửa</Link>
                        </td>
                        <td class="border-2"><a href="#" @click="deleteUser(user.id)">Xoá</a></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>

</style>
