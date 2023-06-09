<script setup>
import { nextTick, ref } from 'vue';

const props = defineProps({
    tasks: Array,
});

const emit = defineEmits(['task-deleted', 'task-updated']);

const editInputRefs = ref([]);
const startDrag = ref(false);
const indexDragEnter = ref(null);
// Check task
function checkTask(taskId) {
    axios.put('/api/tasks/complete/' + taskId, )
        .then(() => {
            emit('task-updated');
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
}

// Edit task
function editTask(index) {
    disableEditionOfTasks();
    props.tasks[index].edit_item = true;
    focusItem(index);
};

function updateTask(taskId, index) {
    axios.put('/api/tasks/' + taskId, props.tasks[index])
        .then(() => {
            emit('task-updated');
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
}

// Delete task
function deleteTask(taskId) {
    axios.delete('/api/tasks/' + taskId)
        .then((response) => {
            if (response.data.error) {
                alert("Error");
            } else {
                emit('task-deleted');
            }
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
};

// Aux functions
async function focusItem(index)
{
    await nextTick();//need to use this utility to wait that the element with v-if (the edit input) is "updated" in DOM
    editInputRefs.value[index].children[1].focus();//the second element (children[1]) is the edit input
}

function disableEditionOfTasks() {
    props.tasks.forEach((task) => {
        task.edit_item = false;
    })
};

// Drag and Drop
function dragStart(event, task) {
    startDrag.value = true;
    event.dataTransfer.setData('taskId', task.id);
}

function dragEnd() {
    startDrag.value = false;
}

function onDragEnter(event, index) {
    event.preventDefault();
    indexDragEnter.value = index;
}

function getClassOnDragEnter(index) {
    if (indexDragEnter.value == index) {
        return 'bg-slate-100';
    }
}

function onDrop(event, index, targetTask) {
    indexDragEnter.value = null;
    if (targetTask.completed == 1) {
        return;
    }
    const taskId = event.dataTransfer.getData('taskId');
    const filteredTask = props.tasks.filter(obj => obj.id == taskId);
    if (filteredTask[0].priority == index) {
        return;
    }
    axios.put('/api/tasks/priority/' + taskId, {'index': index})
        .then((response) => {
            emit('task-updated');
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
    })
}
</script>
<template>
    <ul class="max-w-7xl mx-auto w-full">
        <div 
            v-for="(task, index) in tasks"
            class="my-5 bg-slate-100"
            :class="{ 'p-1': startDrag }"
            @drop="onDrop($event, index + 1, task)"
            @dragenter="onDragEnter($event, index)"
            @dragover.prevent="false">

            <li
                ref="editInputRefs"
                class="sortable-item bg-white border border-none drop-shadow-lg font-semibold p-5 w-full truncate
                        hover:bg-sky-50 transition duration-300 ease-in-out"
                :class="getClassOnDragEnter(index)"
                :draggable="task.completed == 0 ? true : false"
                @dragstart="dragStart($event, task)"
                @dragend="dragEnd()">
                
                <p class="text-left" v-if="!task.completed">
                    <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                        {{ task.priority }}
                    </span>
                </p>

                <input v-if="tasks[index].edit_item" type="text" v-model="tasks[index].name" class="bg-slate-100 text-black text-center w-full">
                <span v-else :class="task.completed ? 'text-gray-400' : 'text-black'">{{ task.name }}</span>

                <div class="mt-5 grid grid-cols-7">
                    <!-- Check task -->
                    <div class="my-auto text-left">
                        <button @click="checkTask(task.id)">
                            <svg v-if="!task.completed" class="w-8 h-8 mx-auto hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 7.5A2.25 2.25 0 017.5 5.25h9a2.25 2.25 0 012.25 2.25v9a2.25 2.25 0 01-2.25 2.25h-9a2.25 2.25 0 01-2.25-2.25v-9z"></path>
                            </svg>
                            <svg v-else class="w-8 h-8 mx-auto text-gray-400 hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Edit task -->
                    <div class="my-auto col-span-5 text-right" v-if="!task.completed">
                        <button v-if="task.edit_item"
                                @click="updateTask(task.id, index)"
                                class="border border-none text-white bg-blue-950 hover:bg-blue-900 font-medium px-3 py-1">
                            Update
                        </button>
                        <button v-else
                                @click="editTask(index)">
                            <svg class="w-4 h-4 mx-auto hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                            </svg>
                        </button>
                    </div>
                    <!-- Delete task -->
                    <div class="my-auto text-right" v-if="!task.completed">
                        <button @click="deleteTask(task.id)">
                            <svg
                                class="w-4 h-4 mx-auto text-red-500 hover:text-red-900" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                </svg>
                        </button>
                    </div>
                </div>
            </li>
        </div>
    </ul>
</template>