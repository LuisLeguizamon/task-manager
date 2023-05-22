<script setup>
import axios from 'axios';
import { nextTick, ref, watch } from 'vue';

const disableAddTask = ref(true);
const editInputRefs = ref([]);
const form = ref({});
const tasks = ref(null);

watch(form.value, (newValue) => {
    disableAddTask.value = !(newValue.name && newValue.name.trim());
})

function addTask() {
    axios.post('/api/tasks', form.value)
        .then(() => {
            getTasks();
            form.value.name = null;
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        });
};

function allowEdition(index) {
    disableEditionOfTasks();
    tasks.value[index].edit_item = true;
    focusItem(index);
};

async function focusItem(index)
{
    await nextTick();//need to use this utility to wait that the element with v-if (the edit input) is "updated" in DOM
    editInputRefs.value[index].children[1].focus();//the second element (children[1]) is the edit input
}

function deleteItem(taskId) {
    axios.delete('/api/tasks/' + taskId)
        .then(() => {
            getTasks();
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
};

function disableEditionOfTasks() {
    tasks.value.forEach((task) => {
        task.edit_item = false;
    })
};

function getTasks() {
    axios.get('/api/tasks')
        .then((response) => {
            if (response.data.length > 0) {
                tasks.value = response.data;
                disableEditionOfTasks();
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
};

function updateTask(taskId, index) {
    axios.put('/api/tasks/' + taskId, tasks.value[index])
        .then(() => {
            getTasks();
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
}

function onCreate() {
    getTasks();
}

onCreate();
</script>

<template>
    <div class="max-w-7xl mx-auto text-center">
        <input v-model="form.name" name="name" type="text" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 px-5 py-2.5 mr-2 mb-2">
        <button 
            @click="addTask()"
            :disabled="disableAddTask"
            :class="{ 'opacity-50': disableAddTask }"
            class="border border-none text-white bg-blue-950 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
            Add Task
        </button>
    </div>
    <div class="sm:flex min-h-screen pt-5">
        <ul v-if="tasks" class="max-w-7xl mx-auto">
            <li v-for="(task, index) in tasks"
                ref="editInputRefs"
                class="sortable-item bg-white border border-none drop-shadow-lg font-semibold mb-5 p-5 w-full
                        hover:bg-sky-400 hover:text-white transition duration-300 ease-in-out">
                <p class="text-left">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                        {{ task.priority }}
                    </span>
                </p>

                <input v-if="tasks[index].edit_item" type="text" v-model="tasks[index].name" class="bg-slate-100 text-black text-center">
                <span v-else>{{ task.name }}</span>

                <div class="mt-5 grid grid-cols-12">
                    <div class="my-auto">
                        <button v-if="task.edit_item"
                                @click="updateTask(task.id, index)"
                                class="border border-none text-white bg-blue-950 hover:bg-blue-900 font-medium px-3 py-1">
                            Update
                        </button>
                        <button v-else
                                @click="allowEdition(index)">
                            <svg class="w-4 h-4 mx-auto hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                </svg>
                        </button>
                    </div>
                    <div class="my-auto border border-none rounded-lg p-2">
                        <button @click="deleteItem(task.id)">
                            <svg
                                class="w-4 h-4 mx-auto text-red-500 hover:text-red-900" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                </svg>
                        </button>
                    </div>
                </div>
            </li>
        </ul>
        <div v-else class="max-w-7xl mx-auto">
            <h1>No tasks found</h1>
        </div>
    </div>
</template>