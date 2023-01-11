<script setup>

import DangerButton from '@/Components/DangerButton.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm, usePage, Link } from '@inertiajs/inertia-vue3';
import { nextTick, ref, defineEmits, watch, reactive } from 'vue';


const props = defineProps({
    department:{
        type: Object,
        pageTitle: String,
        // default: {name: null},
    },
    isShowModal: {
        type: Boolean,
        default: false,
    },
});
const emit = defineEmits(['closeModal']);
const closeModal = () => {
    emit('closeModal', false);   
};

let users = reactive([]);
async function getAllUser() {
        try {
          const res = await axios.get(`/user/list`);
          users = res.data.users;
          console.log(users);          
        } catch (error) {
          console.log(error);
        }
    }

await getAllUser();
// const userdepartemnts = await getAllUser();
// users.value = userdepartemnts.users;
// console.log(users.value); 

// users.value = [
//      {id: 1, name: 'Nguyễn Van A'},
//      {id: 2, name: 'Nguyễn Van B'},
//      {id: 3, name: 'Nguyễn Van C'},
//      {id: 4, name: 'Nguyễn Van D'},
// ]

</script>

<template>
    <section class="space-y-6">
        <Modal :show="isShowModal" >
            <form @submit.prevent="saveDepartment()" class="space-y-6">
                <div
                    class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                    <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalScrollableLabel">
                        Quản lý thành viên
                    </h5>
                </div>
                <div>
                    <InputLabel for="name" value="Chủ Phòng" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Danh sách User để chọn" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Giám sát Phòng" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Danh sách User để chọn" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Thành viên của phòng" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Danh sách User để chọn" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Người phối hợp" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Danh sách User để chọn" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>
                    <InputLabel for="name" value="Người theo dõi" />
                    <TextInput id="name" type="text" class="mt-1 block w-full" placeholder="Danh sách User để chọn" autofocus
                        autocomplete="name" />
                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>
                <div>Danh sách thành viên Trong Phòng: {{ X }}</div>
                <select>
                    <option :key="index" v-for="(user,index) in users">
                      {{ user.name }}
                    </option>
                  </select>
                <div
                    class="modal-footer flex flex-shrink-0 flex-wrap items-center justify-end p-4 border-t border-gray-200 rounded-b-md">
                    <SecondaryButton @click="closeModal"> Đóng </SecondaryButton>
                    <PrimaryButton class="ml-3">Lưu lại</PrimaryButton>
                </div>
            </form>
        </Modal>
    </section>
</template>
