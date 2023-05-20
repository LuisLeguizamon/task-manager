import { createRouter, createWebHistory } from "vue-router";

import TaskList from '../components/Tasks/TaskList.vue';
import TaskCreate from '../components/Tasks/TaskCreate.vue';

const routes = [
    {
        path: "/tasks",
        component: TaskList
    },
    {
        path: "/tasks/create",
        component: TaskCreate
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router
