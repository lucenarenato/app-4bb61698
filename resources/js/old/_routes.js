import Vue from 'vue'
/*import AllProduct from './components/AllProduct.vue';
import CreateProduct from './components/CreateProduct.vue';
import EditProduct from './components/EditProduct.vue';*/
import Home from './components/AllProduct.vue'
import CreateProduct from './components/CreateProduct.vue'
import EditProduct from './components/EditProduct.vue';

import vrouter from 'vue-router'
Vue.use(vrouter)

export default new vrouter({

    routes: [
        {
            path: '/',
            name: 'home',
            component: Home,
        },
        {
            path: '/create',
            name: 'create',
            component: CreateProduct,
        },
        {
            name: 'edit',
            path: '/edit/:id',
            component: EditProduct
        }
    ]
})
/*export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllProduct
    },
    {
        name: 'create',
        path: '/create',
        component: CreateProduct
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditProduct
    }
];*/