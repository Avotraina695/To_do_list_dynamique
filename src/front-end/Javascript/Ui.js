const listEl = document.getElementById("listTask");
const totalEl = document.getElementById("taskTotal");
const completedEl = document.getElementById("taskCompleted");
const pendingEl = document.getElementById("taskPending");

function escapeHtml(str) {
    const div = document.createElement("div");
    div.textContent = str;
    return div.innerHTML;
}

function formatDate(str) {
    if (!str) return "";
    const d = new Date(str.replace(" ", "T"));
    if (isNaN(d)) return str;
    return d.toLocaleDateString("fr-FR", {
        day: "2-digit",
        month: "short",
        hour: "2-digit",
        minute: "2-digit"
    });
}

export function updateCounters(tasks) {
    const completed = tasks.filter(t => t.status === "completed").length;
    const pending = tasks.length - completed;

    totalEl.textContent = tasks.length;
    completedEl.textContent = completed;
    pendingEl.textContent = pending;
}

// isHistoryView : quand true, affiche les tâches supprimées différemment
// et désactive toutes les actions (toggle/éditer/supprimer) dessus
export function renderTasks(tasks, isHistoryView = false) {
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
        const isDeleted = !!task.deleted_at;

        const li = document.createElement("li");
        li.className = "list-group-item d-flex align-items-center justify-content-between"
            + (isDone ? " task-done" : "")
            + (isDeleted ? " task-deleted" : "");
        li.dataset.id = task.id;
        li.dataset.title = task.title;

        const toggleIcon = isDeleted
            ? `<i class="fa-solid fa-ban text-muted" title="Tâche supprimée"></i>`
            : `<i class="fa-solid ${isDone ? "fa-circle-check" : "fa-circle"} task-toggle"
                   data-id="${task.id}"
                   data-status="${task.status}"
                   role="button"
                   title="${isDone ? "Marquer à faire" : "Marquer terminée"}"></i>`;

        const actionIcons = isDeleted
            ? ""
            : `<i class="fa-solid fa-pen task-edit" data-id="${task.id}" role="button" title="Modifier"></i>
               <i class="fa-solid fa-trash task-delete" data-id="${task.id}" role="button" title="Supprimer"></i>`;

        const statusTag = isDeleted
            ? `<span class="badge bg-secondary">Supprimée le ${formatDate(task.deleted_at)}</span>`
            : `<span class="badge ${isDone ? "bg-success" : "bg-warning text-dark"}">${isDone ? "Terminée" : "En attente"}</span>`;

        li.innerHTML = `
            <div class="d-flex align-items-center gap-2 task-content">
                ${toggleIcon}
                <span class="task-title" data-id="${task.id}">${escapeHtml(task.title)}</span>
                ${isHistoryView ? statusTag : ""}
            </div>
            <div class="d-flex align-items-center gap-2 task-actions">
                ${actionIcons}
            </div>
        `;

        listEl.appendChild(li);
    });
}

// Remplace le <span> du titre par un champ éditable, et retourne l'input créé
export function enterEditMode(id) {
    const titleSpan = listEl.querySelector(`.task-title[data-id="${id}"]`);
    if (!titleSpan) return null;

    const currentTitle = titleSpan.textContent;

    const input = document.createElement("input");
    input.type = "text";
    input.className = "task-edit-input";
    input.value = currentTitle;
    input.dataset.id = id;
    input.dataset.original = currentTitle;

    titleSpan.replaceWith(input);
    input.focus();
    input.select();

    return input;
}

export function getInputElement() {
    return document.getElementById("inputTask");
}

export function getListElement() {
    return listEl;
}