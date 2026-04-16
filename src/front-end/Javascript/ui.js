import {listTask} from "./dom.js";
import {createTaskElement} from "./tasks.js";
import {getTasks} from "./api.js";


export const showData = async () => {
    const data = await getTasks();

    const items = data.tasks;

    if (!listTask) {
        console.error("listTask introuvable");
        return;
    }

    listTask.innerHTML = "";

    items.forEach(item => {
        const li = createTaskElement(item.title);
        listTask.append(li);
    });
};
