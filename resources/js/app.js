require('./bootstrap');

import { createApp } from 'vue';
import router from './router'

import MenuIndex from './components/MenuIndex.vue'
createApp({
    components: {
        MenuIndex
    }
}).use(router).mount('#app')
