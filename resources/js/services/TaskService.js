import axios from "axios";

export function checkTask(taskId, emit) {
    axios
        .put("/api/tasks/complete/" + taskId)
        .then(() => {
            emit("task-updated");
        })
        .catch((error) => {
            console.log(error);
            alert("Error");
        });
}
