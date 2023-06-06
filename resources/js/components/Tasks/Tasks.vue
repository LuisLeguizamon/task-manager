<script setup>
import axios from 'axios';
import { ref } from 'vue';
import AddTask from './partials/AddTask.vue';
import TaskList from './partials/TaskList.vue';

const completeTasks = ref(null);
const incompleteTasks = ref(null);

function getTasks() {
    axios.get('/api/tasks')
        .then((response) => {
            if (response.data.incomplete != undefined && response.data.incomplete.length > 0) {
                incompleteTasks.value = response.data.incomplete;
            } else {
                incompleteTasks.value = null;
            }
            if (response.data.complete != undefined && response.data.complete.length > 0) {
                completeTasks.value = response.data.complete;
            } else {
                completeTasks.value = null;
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
    <div class="max-w-7xl mx-auto text-center w-4/5">
        <AddTask @add-task="getTasks"></AddTask>
    </div>
    <!-- Incomplete Tasks -->
    <div class="sm:flex screen pt-5 mx-auto w-4/5">
        <TaskList 
            v-if="incompleteTasks"
            :tasks="incompleteTasks"
            @task-deleted="getTasks"
            @task-updated="getTasks">
        </TaskList>
        <div v-else class="max-w-7xl mx-auto">
            <h1>No tasks found</h1>
        </div>
    </div>
    <!-- Complete Tasks -->
    <div class="sm:flex min-h-screen pt-5 mx-auto w-4/5">
        <TaskList 
            v-if="completeTasks"
            :tasks="completeTasks"
            @task-updated="getTasks">
        </TaskList>
    </div>
</template>