
<script lang="ts" setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, useForm, usePage} from '@inertiajs/inertia-vue3';
import { Edit, Delete, Plus } from '@element-plus/icons-vue';
import { Inertia } from "@inertiajs/inertia";

import { ref, watch } from "vue";
const props = defineProps({
    users: Array,
    meta: Object,
});

const form = useForm({ })

function destroy(userId) {
    if (confirm("Bạn có thực sự muốn xoá")) {
        Inertia.delete(route('user.destroy', {user: userId}));
    }
}

function changePage(page)
{
    Inertia.visit(route('user.index', {page: page}))
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
                <el-link type="primary" :href="route('user.create')" target="_blank">
                    <el-button type="primary" class="btn-add" :icon="Plus">Thêm mới thành viên</el-button> 
                </el-link>
            </div>
            <div >
                <el-table :data="users" style="width: 93%" border class="ml-20 table-user">
                    <el-table-column prop="name" label="Tên" width="200" />
                    <el-table-column prop="email" label="Email" width="540"/>
                    <el-table-column prop="created_at" label="Ngày tạo" width="400" />
                    <el-table-column label="Actions" width="205">
                        <template #default="scope">
                            <el-row :span="24">
                                <el-col :span="12">
                                    <el-link type="primary" :href="route('user.edit', {user: scope.row.id})" target="_blank">
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
                        v-if="users.length"
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
}

.table-user {
    padding: 2rem;
    border-radius: 0.5rem;
}
.pagination {
    margin-left: 5rem;
}
</style>
