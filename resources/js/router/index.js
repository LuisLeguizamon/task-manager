import { createRouter, createWebHistory } from "vue-router";

import TaskList from '../components/Tasks/TaskList.vue';
import TaskForm from '../components/Tasks/TaskForm.vue';

const routes = [
    {
        path: "/tasks",
        component: TaskList
    },
    {
        path: "/tasks/create",
        component: TaskForm
    },
    {
        path: "/tasks/edit/:id",
        component: TaskForm
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router
