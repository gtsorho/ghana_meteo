import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/home.vue'
import Admin from '../views/admin.vue'



const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,
    },
    {
        path: '/admin',
        name: 'Admin',
        component: Admin,
    },
    // {
    //     path: '/:catchAll(.*)',
    //     name: 'NotFound',
    //     component: NotFound
    // },
]

    const router = createRouter({
    history: createWebHistory(),
    routes,
    // scrollBehavior(to, from, savedPosition) {
    //     if (to.hash) {
    //         return {
    //         el: to.hash,
    //         top: 50,
    //         behavior: 'smooth',
    //         }
    //     }else{
    //         return {top: 0}
    //     }
    // },
    })

    export default router
