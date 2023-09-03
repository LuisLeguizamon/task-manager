<script setup>
import CircleIcon from '../../CircleIcon.vue';
import { checkTask } from '../../../services/TaskService';

const props = defineProps({
    tasks: Array,
});

const emit = defineEmits(['task-updated']);

// Check task
function checkTaskWrapper(taskId) {
  checkTask(taskId, emit);
}
</script>
<template>
    <div class="bg-white drop-shadow-md rounded mb-5 px-3 py-5"
        :class="{'bg-gray-50': task.completed}"
        v-for="task in props.tasks">
        <div class="flex items-center">
            <span v-if="!task.completed">
                <CircleIcon @click="checkTaskWrapper(task.id)" />
            </span>
            <span class="ml-5" :class="{'text-gray-400 line-through': task.completed}">
                {{ task.name }}
            </span>
        </div>
    </div>
</template>