<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import DepartenList from '@/Pages/Departen/Index.vue';

defineProps({
    departments: Array,
});

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
