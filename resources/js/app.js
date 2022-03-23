
require('./bootstrap');

import Vue from 'vue/dist/vue';

window.Vue = require('vue').default;

import App from './App.vue';
import VueAxios from 'vue-axios';
import VueRouter from 'vue-router';
import axios from 'axios';
import { routes } from './routes';
// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);

const router = new VueRouter({
    mode: 'history',
    routes: routes
});

const app = new Vue({
    el: '#app',
    methods: {
        log: function (e) {
            console.log('Estou aqui => app.js');
            console.log(e.currentTarget);
            console.log(e);
        }
    },
    router: router,
    render: h => h(App),
});