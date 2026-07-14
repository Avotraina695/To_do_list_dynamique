import { getTasks, addTask, updateTask, deleteTask } from "./Api.js";
import { renderTasks, updateCounters, getInputElement, getListElement } from "./Ui.js";

const inputEl = getInputElement();
const listEl = getListElement();
const addButton = document.getElementById("AddTaskButton");
const clearIcon = document.getElementById("iconSupprime");

const completedButton = document.getElementById("completedButton");
const pendingButton = document.getElementById("pendingButton");
const allButton = document.getElementById("allButton");
const historyButton = document.getElementById("historyButton");

let allTasks = [];
let currentFilter = "all";
function applyFilter() {
    let filtered = allTasks;
    if (currentFilter === "pending") {
        filtered = allTasks.filter(t => t.status === "pending");
    } else if (currentFilter === "completed" || currentFilter === "history") {
        filtered = allTasks.filter(t => t.status === "completed");
    }
    renderTasks(filtered);
}
function setActiveFilter(button) {
    [completedButton, pendingButton, allButton, historyButton].forEach(btn => {
        btn.classList.remove("active-filter");
    });
    button.classList.add("active-filter");
}

async function refresh() {
    const data = await getTasks();
    if (!data.success) {
        listEl.innerHTML = `<li class="list-group-item text-danger text-center">Connexion au serveur impossible.</li>`;
        return;
    }
    allTasks = data.tasks;
    updateCounters(allTasks);
    applyFilter();
}

async function handleAddTask() {
    const title = inputEl.value.trim();
    if (!title) return;

    const result = await addTask(title);
    if (!result.success) {
        console.error(result.message);
        return;
    }

    inputEl.value = "";
    refresh();
}

addButton.addEventListener("click", handleAddTask);

inputEl.addEventListener("keydown", (e) => {
    if (e.key === "Enter") {
        e.preventDefault();
        handleAddTask();
    }
});

clearIcon.addEventListener("click", () => {
    inputEl.value = "";
    inputEl.focus();
});

allButton.addEventListener("click", () => {
    currentFilter = "all";
    setActiveFilter(allButton);
    applyFilter();
});

pendingButton.addEventListener("click", () => {
    currentFilter = "pending";
    setActiveFilter(pendingButton);
    applyFilter();
});

completedButton.addEventListener("click", () => {
    currentFilter = "completed";
    setActiveFilter(completedButton);
    applyFilter();
});

historyButton.addEventListener("click", () => {
    currentFilter = "history";
    setActiveFilter(historyButton);
    applyFilter();
});

listEl.addEventListener("click", async (e) => {
    const toggle = e.target.closest(".task-toggle");
    if (toggle) {
        const newStatus = toggle.dataset.status === "completed" ? "pending" : "completed";
        const result = await updateTask(toggle.dataset.id, newStatus);
        if (!result.success) {
            console.error(result.message);
            return;
        }
        refresh();
        return;
    }

    const del = e.target.closest(".task-delete");
    if (del) {
        const result = await deleteTask(del.dataset.id);
        if (!result.success) {
            console.error(result.message);
            return;
        }
        refresh();
    }
});

refresh();