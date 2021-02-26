<template>
    <div class="file-input">
        <label for="file">
            <span class="file-input__icon">
                ⬆️
            </span>
            Загрузить файл
        </label>
        <input type="file" name="file" id="file"  @change="onFileChange" >
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';
    import mixins from "../mixins";

    export default {
        name: "UploadFile",
        mixins: [mixins],
        methods: {
            ...mapMutations(["setCurrentList"]),
            onFileChange(e) {
                let files = e.target.files || e.dataTransfer.files;
                if (!files.length)
                    return;
                let formData = new FormData();
                formData.append('action', 'upload',);
                formData.append('current', this.currentPath);
                formData.append("file", files[0]);
                this.request(this.baseURL, 'POST', formData).then((data) => {
                    this.setCurrentList(Object.values(data));
                    e.target.value = '';
                }).catch((message) => {
                    alert(message);
                });

            }
        },
        computed: {
            ...mapState(["currentPath", "baseURL"]),
        }
    }
</script>

<style scoped lang="stylus">
    .file-input
        cursor pointer
        padding-top 20px
        border-top 1px solid black
        font-size 20px
        margin-top 30px
        padding-left 10px
        input
            display none
        label
            cursor pointer
        &__icon
            margin-right 5px
</style>