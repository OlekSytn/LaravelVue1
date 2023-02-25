import Vue from 'vue'
import App from './App.vue'
import router from './router.js'
import './axios.js'
import './toast.js'
import store from './vuex';

Vue.config.productionTip = false

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#app')
