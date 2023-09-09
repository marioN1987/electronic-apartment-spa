// app.js
import('./bootstrap');

import { createApp } from 'vue';
import { createRouter, createWebHistory } from 'vue-router';

import App from './App.vue';
import Create from './components/Create.vue';
import Update from './components/Update.vue';
import Delete from './components/Delete.vue';
import Home from './components/Home.vue';

const router = new createRouter({
    history: createWebHistory(),
    mode: 'hash',
    routes: [
        { path: '/', name: 'home', component: Home },
        { path: '/create', name: 'create', component: Create },
        { path: '/update/:id', name: 'update', component: Update },
        { path: '/delete/:id', name: 'delete', component: Delete }
    ]
});

createApp(App).use(router).mount('#app');