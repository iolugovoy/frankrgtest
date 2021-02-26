import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        currentList: [],
        currentPath: '',
    },
    mutations: {
        setCurrentPath(state, value) {
            state.currentPath = value;
        },
        setCurrentList(state, value) {
            state.currentList = value;
        }
    },
    actions: {
    },
    modules: {},
});