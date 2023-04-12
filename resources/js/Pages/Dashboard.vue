<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';
import request from '../utils/request';
import { ref, provide } from 'vue';

const departments = ref([]);

async function getDepartment() {
    await request.get(`/api/department`).then((res) => {
        departments.value = res.data.result.departments
    })
}

getDepartment()
provide('getDepartmentDashBoard', getDepartment)
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #departen>
            <DepartenList :departments="departments" />
        </template>
        
        <div class="py-16 ml-2">
            <div class="grid grid-cols-3 divide-x">
                <h3>Dashboard</h3>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
