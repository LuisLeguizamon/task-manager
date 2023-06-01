<script setup>
import axios from 'axios';
import { ref } from 'vue';
import AddTask from './partials/AddTask.vue';
import TaskList from './partials/TaskList.vue';

const tasks = ref(null);

function getTasks() {
    axios.get('/api/tasks')
        .then((response) => {
            if (response.data.length > 0) {
                tasks.value = response.data;
                // disableEditionOfTasks();//comunicate to list component
            } else {
                tasks.value = null;
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
};

function onCreate() {
    getTasks();
}

onCreate();
</script>

<template>
    <div class="max-w-7xl mx-auto text-center">
        <AddTask @add-task="getTasks"></AddTask>
    </div>
    <div class="sm:flex min-h-screen pt-5">
        <TaskList 
            v-if="tasks"
            :tasks="tasks"
            @task-deleted="getTasks"
            @task-updated="getTasks">
        </TaskList>
        <div v-else class="max-w-7xl mx-auto">
            <h1>No tasks found</h1>
        </div>
    </div>
</template>