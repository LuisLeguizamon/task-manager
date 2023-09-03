<script setup>
import CircleIcon from '../../CircleIcon.vue';

const props = defineProps({
    tasks: Array,
});

const emit = defineEmits(['task-updated']);

// Check task
function checkTask(taskId) {
    axios.put('/api/tasks/complete/' + taskId,)
        .then(() => {
            emit('task-updated');
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        })
}
</script>
<template>
    <div class="bg-white drop-shadow-md rounded mb-5 px-3 py-5"
        :class="{'bg-gray-50': task.completed}"
        v-for="task in props.tasks">
        <div class="flex items-center">
            <span v-if="!task.completed">
                <CircleIcon @click="checkTask(task.id)" />
            </span>
            <span class="ml-5" :class="{'text-gray-400 line-through': task.completed}">
                {{ task.name }}
            </span>
        </div>
    </div>
</template>