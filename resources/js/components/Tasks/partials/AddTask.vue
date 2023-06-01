<script setup>
import { computed, ref, watch } from 'vue';

const emit = defineEmits(['add-task']);
const disableAddTask = ref(true);
const form = ref({});

const textLengthWarning = computed(() => {
    let textTask = `${form.value.name}`;
    if (textTask.length > 20) {
        return 'Text too long';
    }
})

watch(form.value, (newValue) => {
    disableAddTask.value = !(newValue.name && newValue.name.trim());
})

function addTask() {
    axios.post('/api/tasks', form.value)
        .then(() => {
            emit('add-task');
            form.value.name = null;
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        });
};
</script>
<template>
    <input
        v-model="form.name"
        name="name"
        type="text"
        required
        class="bg-white border border-gray-300 text-sm px-5 py-2.5 mr-2 mb-2">
    <h1>{{ textLengthWarning }}</h1>
    <button
        @click="addTask()"
        :disabled="disableAddTask"
        :class="{ 'opacity-50': disableAddTask }"
        class="border border-none text-white bg-blue-950 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none">
        Add task
    </button>
</template>