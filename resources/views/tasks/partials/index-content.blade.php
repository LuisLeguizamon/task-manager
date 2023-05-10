<div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">

    <div class="max-w-7xl mx-auto">
        <div class="mt-4">
            <img class="mx-auto" src="/logo_tasks.png" alt="logo" width="50px">
        </div>
        <div class="mt-8 text-center">
            <a href="{{ route('tasks.create') }}"
                class="border border-none text-white bg-blue-950 hover:bg-blue-900 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 focus:outline-none dark:focus:ring-blue-8000">
                Create Task
            </a>
        </div>

        <div class="mt-8 text-center">
            <ul id="sortable">
                @if ($tasks)
                    @foreach ($tasks as $task)
                        <li data-task-id="{{ $task->id }}"
                            class="sortable-item bg-white border border-none font-semibold mb-5 p-5 w-full">
                            <p class="text-left">
                                <span class="bg-blue-100 text-blue-800 text-xs font-medium mr-2 px-2.5 py-0.5 rounded">
                                    {{ $task->priority}}
                                </span>
                            </p>
                            <span>
                                {{ $task->name }}
                            </span>
                            <span class="bg-gray-100 text-gray-500 text-xs font-normal mr-2 px-1 py-0.5 rounded">
                                {{ $task->id }}
                            </span>
                            <div class="mt-5 grid grid-cols-12">
                                <div class="my-auto">
                                    <a href="{{ route('tasks.edit', ['task' => $task->id]) }}">
                                        <svg class="w-4 h-4 mx-auto hover:text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125"></path>
                                          </svg>
                                    </a>
                                </div>
                                <div class="my-auto border border-none rounded-lg p-2">
                                    <form id="delete-form-{{$task->id}}" method="POST"
                                            action="{{ route('tasks.destroy', $task->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">
                                            <svg
                                                class="w-4 h-4 mx-auto text-red-500 hover:text-red-900" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path>
                                              </svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @else
                    <li>No tasks found</li>
                @endif
            </ul>
        </div>
    </div>
</div>