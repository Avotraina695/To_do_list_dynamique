export const getTasks = async () => {
    const response = await fetch('back-end/php/get_history.php');
    return await response.json();
}

export const addTask = async (text) => {
    try {
        const response = await fetch("back-end/php/add_task.php", {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ text })
        });

        return await response.json();
    } catch (error) {
        console.error("Erreur POST :", error);
    }
}

export const updateTask = async (id, status) => {
    try {
        const response = await fetch("back-end/php/updateTask.php", {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: "update",
                id,
                status
            })
        });

        return await response.json();
    } catch (error) {
        console.error("Erreur update :", error);
    }
}
