// === ELIMINAR USUARIO ===
export function fillDeleteUserModal(id_user) {
    const form = document.querySelector("#deleteUserModal form");
    form.querySelector("#delete_id_user").value = id_user;
}

// === ELIMINAR USUARIO ===
export function fillClearUserModal(id_user) {
    const form = document.querySelector("#clearUserModal form");
    form.querySelector("#clear_id_user").value = id_user;
}
