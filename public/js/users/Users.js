import { loadUsers } from "../load/loadUsers.js";

const formClearDataUsers = document.getElementById("clearDataForm");
const formDeleteUsers = document.getElementById("truncateDataForm");
const formDeleteUser = document.querySelector("#deleteUserModal form");
const formClearUser = document.querySelector("#clearUserModal form");

// 🔹 Limpiar datos de todos los usuarios
function ClearAllData(event) {
    event.preventDefault();
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/users/clear", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    })
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                formClearDataUsers.reset();
                loadUsers();
            } else {
                console.error("Error al limpiar datos de usuarios:", data);
            }
        })
        .catch((error) => console.error("Error:", error));
}

// 🔹 Eliminar todos los usuarios
function DeleteAllData(event) {
    event.preventDefault();
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/users/destroyAll", {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    })
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                formDeleteUsers.reset();
                loadUsers();
            } else {
                console.error("Error al eliminar usuarios:", data);
            }
        })
        .catch((error) => console.error("Error:", error));
}

// 🔹 Eliminar un usuario específico
function DeleteUser(event) {
    event.preventDefault();
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const formData = new FormData(formDeleteUser);
    const userId = formData.get("id_user");

    fetch(`/users/delete/${userId}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    })
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                const modalEl = document.getElementById("deleteUserModal");
                const modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                if (modal) {
                    formDeleteUser.reset();
                    modal.hide();
                    loadUsers();
                }
            } else {
                console.error("Error al eliminar usuario:", data);
            }
        })
        .catch((error) => console.error("Error:", error));
}

// 🔹 Limpiar datos de un usuario específico
function ClearUser(event) {
    event.preventDefault();
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    const formData = new FormData(formClearUser);
    const userId = formData.get("id_user");

    fetch(`/users/clear/${userId}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((data) => {
            if (data.success) {
                const modalEl = document.getElementById("clearUserModal");
                const modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                if (modal) {
                    formClearUser.reset();
                    modal.hide();
                    loadUsers();
                }
            } else {
                console.error("Error al limpiar datos del usuario:", data);
            }
        })
        .catch((error) => console.error("Error:", error));
}

// ============== EVENTOS ============== //
formClearDataUsers.addEventListener("submit", ClearAllData);
formDeleteUsers.addEventListener("submit", DeleteAllData);
formDeleteUser.addEventListener("submit", DeleteUser);
formClearUser.addEventListener("submit", ClearUser);
