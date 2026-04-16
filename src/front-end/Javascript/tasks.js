
import {updateTaskCount} from "./updateCount.js";
import {updateTask} from "./api.js";


export const createTaskElement = async (text) => {
    let li = document.createElement("li");
    li.classList.add("list-item");
    updateTaskCount();

    let inputBox = document.createElement("input");
    inputBox.type = "checkbox";
    inputBox.checked = text.checked;

    let spanText = document.createElement("span");
    spanText.textContent = text;
    spanText.classList.add("spanLi");
    inputBox.addEventListener("change", (e) => {
        if (e.target.checked === true) {
            spanText.classList.toggle("checked");
        } else {
            spanText.classList.remove("checked");
        }
        updateTaskCount();
    })
    let blockButton = document.createElement("div");
    blockButton.classList.add("button-action");
    li.appendChild(blockButton);

    let editButton = document.createElement("button");
    editButton.classList.add("buttonModifier");
    editButton.addEventListener("click", async () => {
        const newValue = prompt("Modifier l'element", spanText.textContent);
        if (newValue !== null && newValue.trim() !== "") {
            const value = newValue.trim();
            spanText.textContent = value;
        }

    })
    blockButton.appendChild(editButton);
    let iconEdit = document.createElement("i");
    iconEdit.classList.add("fas")
    iconEdit.classList.add("fa-edit");
    editButton.appendChild(iconEdit);


    let supprimeButton = document.createElement("button");
    supprimeButton.classList.add("buttonSupprimer");
    blockButton.appendChild(supprimeButton);
    supprimeButton.style.marginLeft = "1rem";

    supprimeButton.addEventListener("click", () => {
        if (confirm("Are you sure?")) {
            li.remove();
            updateTaskCount();

        }
    });

    let iconTrash = document.createElement("i");
    iconTrash.classList.add("fas");
    iconTrash.classList.add("fa-trash-alt");
    supprimeButton.appendChild(iconTrash);
    updateTaskCount();
    li.appendChild(inputBox);
    li.appendChild(spanText);

    return li;
};