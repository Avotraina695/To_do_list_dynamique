const API_BASE = "http://localhost:8000";

export const getTasks = async () => {
    try {
        const response = await fetch(`${API_BASE}/tasks`);
        return await response.json();
    } catch (error) {
        console.error("Erreur GET :", error);
        return { success: false, message: "Connexion au serveur impossible." };
    }
};

export const addTask = async (title, status = "pending") => {
    try {
        const response = await
            fetch(`${API_BASE}/tasks`, {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ title, status })
        });
        return await response.json();
    } catch (error) {
        console.error("Erreur POST :", error);
        return { success: false, message: "Connexion au serveur impossible." };
    }
};

export const updateTask = async (id, status) => {
    try {
        const response = await fetch(`${API_BASE}/tasks/${id}`, {
            method: "PUT",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify({ status })
        });
        return await response.json();
    } catch (error) {
        console.error("Erreur update :", error);
        return { success: false, message: "Connexion au serveur impossible." };
    }
};

export const deleteTask = async (id) => {
    try {
        const response = await fetch(`${API_BASE}/tasks/${id}`, {
            method: "DELETE"
        });
        return await response.json();
    } catch (error) {
        console.error("Erreur delete :", error);
        return { success: false, message: "Connexion au serveur impossible." };
    }
};