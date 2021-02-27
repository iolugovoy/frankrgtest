<template>
    <div class="list-item" @click="activateItem(name)" @dblclick="renameItem(name)">
        <div class="list-item__icon" >
            <div v-if="isFile(clearName)">
                📄
            </div>
            <div v-else>
                📂
            </div>

        </div>
        <div class="list-item__name">
            <span :contenteditable="isRenaming" ref="name" @focusout="onBlur" @keydown="submitRename">
            {{ clearName }}
            </span>
        </div>

        <a v-if="isFile(clearName)" @click.stop class="list-item__icon" :href="url" target="_blank" download >
            ️⬇️
        </a>
        <div class="list-item__icon delete" @click.stop="deleteItem">
            ❌
        </div>
    </div>
</template>

<script>
    import mixins from "../mixins";
    import { mapState, mapMutations } from 'vuex';

    export default {
        name: "ListItem",
        mixins: [mixins],
        props: {
            name: {
                type: String,
                default: () => {}
            }
        },
        data() {
            return {
                activateTimerID: 0,
                isRenaming: false,
            }
        },
        computed: {
            ...mapState(["currentPath", "baseURL"]),
            clearName() {
                let splitedName =  this.name.split('/');
                let lastIndex = splitedName.length - 1;
                return splitedName[lastIndex];
            },
            url() {
                return '/files' + this.name;
            }
        },
        methods: {
            ...mapMutations(["setCurrentList"]),
            onBlur(){
                if (this.isRenaming){
                    this.isRenaming = false;
                    this.updateName(this.$refs.name.innerText);
                }
            },
            activateItem(item){
                if (!this.isRenaming) {
                    clearTimeout(this.activateTimerID);
                    this.activateTimerID = setTimeout(() => {
                        if (!this.isFile(item)){
                            this.$emit('openFolder', item);
                        }
                    }, 200);
                }
            },
            renameItem(){
                clearTimeout(this.activateTimerID);
                this.isRenaming = true;
                setTimeout(()=>{
                    this.$refs.name.focus();
                }, 10)
            },
            updateName(){
                const isPrevNameFile = this.isFile(this.clearName);
                const isNewNameFile = this.isFile(this.$refs.name.innerText);
                const isFileNameCorrect = isPrevNameFile && isNewNameFile;
                const isFolderNameCorrect = !isPrevNameFile && !isNewNameFile;
                const isNewNameNotEmpty = this.$refs.name.innerText != '';
                const isNameCorrect = (isFileNameCorrect || isFolderNameCorrect) && isNewNameNotEmpty;
                if (isNameCorrect){
                    console.log('name correct');
                    let formData = new FormData();
                    formData.append('action', 'rename',);
                    formData.append('current', this.currentPath);
                    formData.append('oldname', this.name);
                    formData.append('newname', this.currentPath + this.$refs.name.innerText);

                    this.request(this.baseURL, 'POST', formData).then((data) => {
                        this.setCurrentList(Object.values(data));
                    }).catch((message) => {
                        alert(message);
                    });


                } else if (!isNewNameNotEmpty) {
                    this.cancelRenaming();
                    alert('Название не может быть пустым');
                } else {
                    this.cancelRenaming();
                    if (!isPrevNameFile && isNewNameFile) {
                        alert('Папки не должны содержать точку в названии');
                    } else if (isPrevNameFile && !isNewNameFile) {
                        alert('Файлы должны содержать точку в названии');
                    }
                }
            },
            cancelRenaming(){
                this.$refs.name.innerText = this.clearName;
                this.isRenaming = false;
            },
            submitRename(e){
                if (this.isRenaming) {
                    if (e.keyCode === 13) {
                        e.preventDefault();
                        console.log(this.$refs.name.innerText);
                        this.isRenaming = false;
                        this.updateName();
                    }
                    if (e.keyCode === 27) {
                        e.preventDefault();
                        this.cancelRenaming();

                    }
                }
            },
            deleteItem() {
                let formData = new FormData();
                formData.append('action', 'delete',)
                formData.append('current', this.currentPath)
                formData.append('filename', this.name)
                this.request(this.baseURL, 'POST', formData).then((data) => {
                    this.setCurrentList(Object.values(data));
                }).catch((message) => {
                    alert(message);
                });
            }
        }
    }
</script>

<style scoped lang="stylus">
    .list-item
        user-select none
        font-size 20px
        margin-bottom 10px
        display flex
        align-items center
        cursor pointer
        &__icon
            margin-right 10px
            margin-left 10px
        .delete
            display none
            &:hover
              opacity .5
        &:hover
            .delete
                display block

</style>