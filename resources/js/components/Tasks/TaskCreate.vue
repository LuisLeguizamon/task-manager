<template>
    <form @submit.prevent="handleSubmit()" class="max-w-sm mx-auto my-8 bg-white p-10 border border-none rounded-lg">
        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Task name</label>
            <input v-model="form.name" name="name" type="text" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900">Priority</label>
            <input v-model="form.priority" name="priority" type="number" min="1" required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
        </div>

        <button
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">
            Create Task
        </button>
    </form>
</template>
<script>
import axios from 'axios';

export default {
    data() {
        return {
            form: {}
        }
    },
    methods: {
        handleSubmit() {
            axios.post('/api/tasks', this.form)
                .then((response) => {
                    this.$router.push('/tasks');
                })
                .catch((error) => {
                    console.log(error);
                    alert("Error");
                });
        }
    },
}
</script>