import Vue from 'vue'
import Vuelidate from 'vuelidate'
Vue.use(Vuelidate)
require('./bootstrap');

window.Vue = require('vue');

import Vuetify from 'vuetify'
import router from './router'
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/dist/vuetify.min.css'
Vue.use(Vuetify);
import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './routes';
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
import App from './components/app'

Vue.use(VueRouter);
Vue.use(VueAxios, axios);

/*const router = new VueRouter({
    mode: 'history',
    routes: routes
});*/

// const app = new Vue(Vue.util.extend({ router }, App)).$mount('#app');
Vue.component('pagination', require('laravel-vue-pagination'));

const app = new Vue({
    el: '#app',
    vuetify: new Vuetify({
        icons: {
            iconfont: 'mdi'
        }
    }),
    components: { App },
    router,
    // router: router,
    // render: h => h(App),
}).$mount('#app');

