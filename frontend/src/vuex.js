import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)



const store = new Vuex.Store({
    state : {
        user: {
            name: '',
            email: ''
        },
        loader:false,
    },
    getters:{
        user: (state) => {
            return state.user;
        },
        loader:(state) => {
            return state.loader;
        }
    },
    mutations:{
        user(state, user){
            state.user = user
        },
        loader(state, loader) {
            state.loader = loader
        }
    },
    actions:{
        user(context, user){
            context.commit('user', user);
        },
        loader(context, loader){
            context.commit('loader', loader);
        }
    }
});

export default store;