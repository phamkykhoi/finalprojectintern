<template>
    <div ref="editor" :options="editorOption"></div>
</template>
<script>
import Quill from "quill";
import "quill/dist/quill.core.css";
import "quill/dist/quill.snow.css";

export default {
    props: {
        modelValue: {
            type: String,
            default: "",
        },
        placeholder: {
            type: String,
            default: "",
        },
    },

    data() {
        return {
            editor: null,
        };
    },
    mounted() {
        var _this = this;
        this.editor = new Quill(this.$refs.editor, {
            placeholder: this.placeholder,
            theme: "snow",
            modules: {
                toolbar: [
                    ["bold", "italic", "underline", "strike"],
                    [{ list: "ordered" }, { list: "bullet" }],
                    [{ script: "sub" }, { script: "super" }],
                    [{ color: [] }, { background: [] }],
                    [{ font: [] }],
                    [{ align: [] }],
                ],
            },
        });
        this.editor.root.innerHTML = this.modelValue;
        this.editor.on("text-change", function () {
            return _this.update();
        });
    },

    methods: {
        update: function update() {
            this.$emit(
                "input-update",
                this.editor.getText() ? this.editor.root.innerText : ""
            );
        },
    },
};
</script>
<style>
.ql-editor {
    font-size: 15px;
    border: 0.2px dotted #ccc;
}
</style>
