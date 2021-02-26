<template>
    <div class="create-folder" @click="createStart">
        <div class="create-folder__icon">
            ➕
        </div>
        <div class="create-folder__text">
            Добавить папку
        </div>
    </div>
</template>

<script>
    import { mapState, mapMutations } from 'vuex';
    import mixins from "../mixins";


    export default {
        name: "CreateFolder",
        mixins: [mixins],
        methods: {
            ...mapMutations(["setCurrentList"]),
            createStart() {
                let nameprompt = prompt("Введите название папки", "Новая папка");
                if (nameprompt) {
                    let formData = new FormData();
                    formData.append('action', 'create',);
                    formData.append('current', this.currentPath);
                    formData.append("foldername", nameprompt);
                    this.request(this.baseURL, 'POST', formData).then((data) => {
                        this.setCurrentList(Object.values(data));
                    }).catch((message) => {
                        alert(message);
                    });
                }
            }
        },
        computed: {
            ...mapState(["currentPath", "baseURL"]),
        }
    }
</script>

<style scoped lang="stylus">
    .create-folder
        display flex
        align-items center
        cursor pointer
        font-size 20px
        margin-top 30px
        padding-left 10px
        input
            display none
        label
            cursor pointer
        &__icon
            margin-right 10px
</style>