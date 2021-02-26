import Vue from 'vue'
import App from './App.vue'
import store from './store'

Vue.config.productionTip = false


store.state.baseURL = document.querySelector('#app').getAttribute('data-base');

new Vue({
  store,
  render: h => h(App),
}).$mount('#app')

