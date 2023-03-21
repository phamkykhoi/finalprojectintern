<template>
    <div ref="editor"></div>
</template>
<script>
import Quill from "quill";
import "quill/dist/quill.core.css";
import "quill/dist/quill.bubble.css";
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
