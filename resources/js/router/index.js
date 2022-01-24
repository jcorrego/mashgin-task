import { createRouter, createWebHistory } from 'vue-router'

import MenuIndex from '../components/MenuIndex.vue'

const routes = [
    {
        path: '/',
        name: 'menu.index',
        component: MenuIndex
    }
];

export default createRouter({
    history: createWebHistory(),
    routes
})
