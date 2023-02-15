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
                <div class="modal-header flex flex-shrink-0 items-center justify-between p-4 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Tên task
                    </h5>
                </div>
                <el-form-item label="" prop="description">
                    <el-input
                        type="textarea"
                        :rows="3"
                        autocomplete="off"
                        placeholder="Mô tả công việc"
                        clearable />
                </el-form-item>
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

