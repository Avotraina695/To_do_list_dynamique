const listEl = document.getElementById("listTask");
const totalEl = document.getElementById("taskTotal");
const completedEl = document.getElementById("taskCompleted");
const pendingEl = document.getElementById("taskPending");

function escapeHtml(str) {
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
}

export function updateCounters(tasks) {
    const completed = tasks.filter(t => t.status === "completed").length;
    const pending = tasks.length - completed;

    totalEl.textContent = tasks.length;
    completedEl.textContent = completed;
    pendingEl.textContent = pending;
}

export function renderTasks(tasks) {
    listEl.innerHTML = "";

    if (!tasks.length) {
        listEl.innerHTML = `
            <li class="list-group-item text-center text-muted">
                Aucune tâche pour l'instant.
            </li>`;
        return;
    }

    tasks.forEach(task => {
        const isDone = task.status === "completed";

        const li = document.createElement("li");
        li.className = "list-group-item gap-10 d-flex align-items-center justify-content-between" + (isDone ? " task-done" : "");
        li.dataset.id = task.id;

        li.innerHTML = `
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid ${isDone ? "fa-circle-check" : "fa-circle"} task-toggle"
                   data-id="${task.id}"
                   data-status="${task.status}"
                   role="button"
                   title="${isDone ? "Marquer à faire" : "Marquer terminée"}"></i>
                <span class="task-title">${escapeHtml(task.title)}</span>
            </div>
            <i class="fa-solid fa-trash task-delete" data-id="${task.id}" role="button" title="Supprimer"></i>
        `;

        listEl.appendChild(li);
    });
}

export function getInputElement() {
    return document.getElementById("inputTask");
}

export function getListElement() {
    return listEl;
}