import { createRouter, createWebHistory } from "vue-router";

import TaskList from '../components/Tasks/TaskList.vue';

const routes = [
    {
        path: "/tasks",
        component: TaskList
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router
