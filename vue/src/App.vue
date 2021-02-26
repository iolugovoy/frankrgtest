<template>
  <div id="app">
    <ParentDirectory @click.native="goParent()" v-if="currentPath != parentPath">{{ currentPath }}</ParentDirectory>
    <div class="list">
      <ListItem v-for="item in currentList" :key="item" :name="item" @openFolder="openFolder"></ListItem>
    </div>
    <UploadFile></UploadFile>
    <CreateFolder></CreateFolder>
  </div>
</template>

<script>
import { mapState, mapMutations } from 'vuex';
import ParentDirectory from './components/ParentDirectory';
import ListItem from './components/ListItem';
import CreateFolder from './components/CreateFolder';
import UploadFile from './components/UploadFile';
import mixins from './mixins.js';


export default {

  name: 'App',
  mixins: [mixins],
  components: {
    ParentDirectory,
    ListItem,
    UploadFile,
    CreateFolder
  },
  props: {

  },
  data() {
    return {
      parentPath: '',

    }
  },
  methods: {
    ...mapMutations(["setCurrentPath", "setCurrentList"]),
    goParent(){
      this.openFolder(this.parentPath);
    },

    openFolder(item) {
      let splitedName =  item.split('/');
      let lastIndex = splitedName.length - 1;
      if (lastIndex > -1) {
        splitedName.splice(lastIndex, 1);
      }
      this.parentPath = splitedName.join('/');
      this.setCurrentPath(item);
      let formData = new FormData();
      formData.append('action', 'get',)
      formData.append('current', this.currentPath)
      this.request(this.baseURL, 'POST', formData).then((data) => {
        this.setCurrentList(Object.values(data));
      }).catch((message) => {
        alert(message);
      });
    },

  },
  computed: {
    ...mapState(["currentPath", "currentList", "baseURL"]),
  },
  beforeMount() {

    let formData = new FormData;
    formData.append('action', 'get',)
    formData.append('current', '',)
    this.request(this.baseURL, 'POST', formData).then((data) => {
      this.setCurrentList(Object.values(data));
    }).catch((message) => {
      alert(message);
    });
  }
}
</script>

<style lang="stylus">
#app
  font-family Avenir, Helvetica, Arial, sans-serif
  -webkit-font-smoothing antialiased
  -moz-osx-font-smoothing grayscale
  text-align left
  color #2c3e50
  margin-top 60px
</style>
