<template>
    <el-upload
        class="upload-demo"
        ref="upload"
        action="#"
        :on-change="handleChange"
        :auto-upload="false"
        :multiple="true"
        :show-file-list = "false"
    >
        <slot name="content"> <el-button slot="trigger" type="primary" :disabled="isDisabled">Select File</el-button></slot>
    </el-upload>
</template>
<script>
import axios from "axios";
import { ElMessage } from "element-plus";

export default {
    props: {
        params: Object,
        isDisabled: Boolean,
    },
    methods: {
        handleChange(file) {
            file.url = URL.createObjectURL(file.raw);
            this.submitUpload(file.url, file.name, this.params);
        },

        submitUpload(fileUrl, title, params) {
            let formData = new FormData();
            fetch(fileUrl)
                .then((res) => res.blob())
                .then((blob) => {
                    let file = new File([blob], "filename.jpeg");
                    formData.append("file", file, title);
                    formData.append("params", JSON.stringify(params));
                    axios
                        .post("/upload-file", formData)
                        .then((res) => {
                            if (res.data.status) {
                                ElMessage({
                                    showClose: true,
                                    message: "Upload file thành công",
                                    type: "success",
                                });
                            }
                            this.$emit('data',res.data.result)
                            this.$emit('data-updated')
                        })
                        .catch((err) => {
                            ElMessage({
                                showClose: true,
                                message: err.response.data.message,
                                type: "error",
                            });
                        });
                });
        },
    },
};
</script>
<style>
.el-upload{
    width: 100%;
}
</style>
