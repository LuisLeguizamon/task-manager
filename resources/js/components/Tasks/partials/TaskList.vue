<script setup>
import { ref, computed } from 'vue';
import CircleIcon from '../../CircleIcon.vue';
import EditTaskModal from '../../EditTaskModal.vue';
import { checkTask } from '../../../services/TaskService';

const props = defineProps({
    incompleteTasks: Boolean,
    tasks: Array,
});

const emit = defineEmits(['task-updated']);

const showEditTaskModal = ref(false);
const taskSelected = ref({
    'id': null,
    'name': null
});

// Check task
function checkTaskWrapper(taskId) {
  checkTask(taskId, emit);
}

function showModal(task) {
    if (props.incompleteTasks) {
        taskSelected.value = JSON.parse(JSON.stringify(task));
        showEditTaskModal.value = true;
    }
}

function taskUpdated() {
    showEditTaskModal.value = false;
    emit('task-updated');
}

const customClass = computed(() => {
    return props.incompleteTasks ? 'drop-shadow-md' : 'bg-gray-50'
})
</script>
<template>
    <div class="bg-white rounded mb-5 px-3 py-5"
        :class="customClass"
        v-for="task in props.tasks">
        <div class="flex items-center">
            <span v-if="!task.completed">
                <CircleIcon @click="checkTaskWrapper(task.id)" />
            </span>
            <span class="ml-5 hover:cursor-pointer"
                :class="{'text-gray-400 line-through': task.completed}"
                @click="showModal(task)">
                {{ task.name }}
            </span>
        </div>
    </div>
    <template v-if="incompleteTasks">
        <Transition>
            <EditTaskModal
                :show="showEditTaskModal"
                :task="taskSelected"
                @task-updated="taskUpdated()"
                @close-modal="showEditTaskModal = false"
            >
            </EditTaskModal>
        </Transition>
    </template>
    
</template>
<style scoped>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.2s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>