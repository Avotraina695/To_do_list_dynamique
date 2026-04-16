import {taskTotal , taskCompleted , taskPending} from "./dom.js";

export const updateTaskCount = () => {
    const totalTask = document.querySelectorAll("li");
    const CompletedTask = document.querySelectorAll("input[type='checkbox']:checked");
    const total = totalTask.length;
    const completed = CompletedTask.length;
    const pending = total - completed;
    console
    taskTotal.textContent = total;
    taskCompleted.textContent = completed;
    taskPending.textContent = pending;
}
