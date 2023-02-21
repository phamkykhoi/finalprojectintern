<template>
    <el-upload
        class="upload-demo"
        ref="upload"
        action="#"
        :on-change="handleChange"
        :auto-upload="false"
        :limit="1"
    >
        <el-button slot="trigger" type="primary">Select file</el-button>
    </el-upload>
</template>
<script>
import axios from "axios";
import { ElMessage } from "element-plus";

export default {
    methods: {
        handleChange(file) {
            file.url = URL.createObjectURL(file.raw);
            this.submitUpload(file.url, file.name);
        },

        submitUpload(fileUrl, title) {
            let formData = new FormData();
            fetch(fileUrl)
                .then((res) => res.blob())
                .then((blob) => {
                    let file = new File([blob], "filename.jpeg");
                    formData.append("file", file, title);
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
                            console.log(res.data.result);
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
