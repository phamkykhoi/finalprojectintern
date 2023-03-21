
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { useForm } from '@inertiajs/inertia-vue3';
import { ref } from 'vue';
import { Edit, Delete, Plus } from '@element-plus/icons-vue';
import { Inertia } from "@inertiajs/inertia";
import request from '../../utils/request';

const props = defineProps({
    departments: Array,
    meta: Object,
});

function destroy(departmentId) {
    if (confirm("Bạn có thực sự muốn xoá")) {
        Inertia.delete(route('department.destroy', {department: departmentId}));
    }
}

function changePage(page)
{
    Inertia.visit(route('department.index', {page: page}))
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="py-12 container">
                <div v-if="$page.props.flash.message"
                class="p-4 mb-4 text-sm text-green-700 bg-green-100 rounded-lg dark:bg-green-200 dark:text-green-800 message-success"
                role="alert"
            >
                <span class="font-medium">
                    {{  $page.props.flash.message }}
                </span>
            </div>
            <div class="toolbar text-right">
                <el-link :href="route('department.create')" target="_blank">
                    <el-button type="primary" class="btn-add" :icon="Plus">Thêm mới Phòng ban</el-button> 
                </el-link>
            </div>
            <div >
                <el-table :data="props.departments" style="width: 93%" border class="ml-20 table-user">
                    <el-table-column prop="id" label="ID" width="50" />
                    <el-table-column prop="name" label="Name" width="440"/>
                    <el-table-column prop="description" label="Desciption" width="650" />
                    <el-table-column label="Actions" width="205">
                        <template #default="scope">
                            <el-row :span="24">
                                <el-col :span="12">
                                    <el-link type="primary" :href="route('department.edit', {department: scope.row.id})" target="_blank">
                                        <el-button type="primary" plain :icon="Edit">Sửa</el-button>
                                    </el-link>
                                </el-col>
                                <el-col :span="12">
                                    <el-button @click="destroy(scope.row.id)" type="danger" :icon="Delete">Xóa</el-button>
                                </el-col>
                            </el-row>
                        </template>
                    </el-table-column>
                </el-table>
                <div class="example-pagination-block pagination">
                    <el-pagination
                        @current-change="changePage"
                        v-model:current-page="meta.currentPage"
                        v-model:page-size="meta.perPage"
                        layout="prev, pager, next"
                        :total="meta.total"
                        v-if="departments.length"
                    />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style scoped>
.message-success {
    margin: 0 2.5rem 1rem 5rem;
}
.btn-add {
    margin: 0 1.7rem 1.5rem 0;
}

.container {
    background: #e9e9e9;
    max-width: 100%;
}

.table-user {
    padding: 2rem;
    border-radius: 0.5rem;
}
.pagination {
    margin-left: 5rem;
}
</style>
