import Vue from 'vue';
import VueRouter from 'vue-router'
import Dashboard from './views/Dashboard'
import Products from './views/Products'
Vue.use(VueRouter);
const routes = [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard
    },
    {
        path: '/products',
        name: 'products',
        component: Products,
    }
    ]
const router = new VueRouter({
    mode: 'history',
    routes
});
export default router;
