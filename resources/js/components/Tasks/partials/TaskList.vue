<script setup>
import CircleIcon from '../../CircleIcon.vue';

const props = defineProps({
    tasks: Array,
});

</script>
<template>
    <div class="bg-white drop-shadow-md rounded mb-5 px-3 py-5" v-for="task in props.tasks">
        <div class="flex items-center">
            <span>
                <CircleIcon></CircleIcon>
            </span>
            <span class="ml-5">
                {{ task.name }}
            </span>
        </div>
    </div>
</template>