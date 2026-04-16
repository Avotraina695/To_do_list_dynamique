import {inputTask, AddTaskButton, listTask, completedButton, allButton, pendingButton, historyButton} from "./dom.js";
import {createTaskElement} from "./tasks.js";
import {updateTaskCount} from "./updateCount.js";
import {showData} from "./ui.js";
import {addTask} from "./api.js";

AddTaskButton.addEventListener("click", () => {
    const text = inputTask.value.trim();
    if (!text) return;

    const li = createTaskElement(text);
    listTask.appendChild(li);
    updateTaskCount();

    addTask(text);


    inputTask.value = "";
});
historyButton.addEventListener("click", () => showData())
