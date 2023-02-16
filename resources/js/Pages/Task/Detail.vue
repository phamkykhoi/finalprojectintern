<script lang="ts" setup>

import Modal from '@/Components/Modal.vue';
import { defineEmits } from 'vue';

const props = defineProps({
    task: {
        type: Object,
        default: null,
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
})

const emit = defineEmits(['closeModal'])

const closeModal = () => {
    emit('closeModal', false);
};

</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" @close="closeModal" v-bind:max-width="'3xl'">
            <form class="space-y-6 m-3">
                <el-row>
                    <el-col :span="18">
                        <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 rounded-t-md">
                            <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                                Tên task
                            </h5>
                        </div>
                        <el-form-item label="Mô tả:" style="display: block;">
                            <el-input type="textarea" :rows="2" autocomplete="off" placeholder="Mô tả công việc" clearable
                                style="display: inline-block;" />
                        </el-form-item>
                        <el-row class="mb-2" style="display: block;">
                            <el-row>
                                <el-col :span="18">
                                    <el-form-item label="Danh sách việc con:"></el-form-item>
                                </el-col>
                                <el-col :span="2" style="text-align: right;">
                                    <el-button>Tạo việc con</el-button>
                                </el-col>
                            </el-row>
                            <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Danh sách việc con" clearable
                                style="display: block;" />
                        </el-row>
                        <el-row class="mb-2">
                            <el-row>
                                <el-form-item label="Tệp đính kèm:"></el-form-item>
                                <el-button>Thêm tệp đính kèm</el-button>
                            </el-row>
                            <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Các tệp đính kèm"
                                style="display: block;" />
                        </el-row>
                        <el-form-item label="Nhật ký việc:" style="display: block;">
                            <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Nhật ký task"
                            style="display: block;" />
                        </el-form-item>
                        <el-form-item label="Thành viên đã xem việc này:" style="display: block;">
                            <el-input type="textarea" :rows="1" autocomplete="off" placeholder="Danh sách thành viên đã xem"
                            style="display: block;" />
                        </el-form-item>
                    </el-col>
                    <el-col :span="5" class="ml-2">
                        <el-checkbox v-model="checked1" label="Hoàn thành việc" size="large" />
                        <el-form-item label="Ngày phải thực hiện:" style="display: block;">
                            <el-input type="text" :rows="1" autocomplete="off" placeholder="Hover: Ngày thực hiện..." />
                        </el-form-item>
                        <div>Người thực hiện: <i class="el-icon-plus"></i></div>
                        <el-button>
                            <i class="el-icon-plus"></i> Thêm mới   
                        </el-button>
                        <el-checkbox v-model="checked1" label="Việc khẩn cấp" size="large" />
                        <el-checkbox v-model="checked1" label="Việc Quan trọng" size="large" />
                        <div class="btn-container">
                            <el-button class="btn-container">Cập nhật vào kế hoạch</el-button>
                            <el-button class="btn-container">Sao chép việc</el-button>
                            <el-button class="btn-container">Di chuyển việc</el-button>
                            <el-button class="btn-container">Tạo nhắc việc</el-button>
                            <el-button class="btn-container">Đánh giá hoàn thành</el-button>
                            <el-button class="btn-container">Khoá việc</el-button>
                            <el-button class="btn-container">Lưu trữ việc</el-button>
                            <el-button class="btn-container">Xoá việc</el-button>
                       </div>
                    </el-col>
                </el-row>            
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <div>
                        <el-button type="primary" @click="closeModal">
                            Đóng
                        </el-button>
                    </div>
                </div>
            </form>
        </Modal>
</section>
</template>
<style scoped>
.btn-container {
    width: 105%;
    margin: 2px;
  }
  
</style>