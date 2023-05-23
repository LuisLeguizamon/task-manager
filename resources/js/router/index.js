import { createRouter, createWebHistory } from "vue-router";

import Tasks from '../components/Tasks/Tasks.vue';

const routes = [
    {
        path: "/tasks",
        component: Tasks
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router
