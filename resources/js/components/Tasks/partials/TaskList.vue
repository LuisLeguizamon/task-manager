<script setup>

const props = defineProps({
    tasks: Array,
});

</script>
<template>
    <div class="bg-white drop-shadow-md rounded mb-5 px-3 py-5" v-for="task in props.tasks">
        {{ task.name }}
    </div>
</template>