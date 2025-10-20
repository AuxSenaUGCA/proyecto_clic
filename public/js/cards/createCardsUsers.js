function createCardUsers(user, index) {
    const userCard = document.createElement("div");
    userCard.className = "col-md-3 col-sm-6 mb-3 user-card";
    userCard.dataset.id = user.id;
    console.log(user, index)
    // 🎖️ Colores para los tres primeros
    let borderColor = "";
    if (index === 0) borderColor = "3px solid gold"; // 1° - Dorado
    else if (index === 1) borderColor = "3px solid silver"; // 2° - Plata
    else if (index === 2) borderColor = "3px solid #cd7f32"; // 3° - Cobre

    userCard.innerHTML = `
        <div class="card shadow-sm text-center h-100" style="border:${borderColor};">
            <div class="card-body p-2">
                <img src="${user.avatar || "/img/default-avatar.png"}"
                    alt="Avatar" 
                    class="rounded-circle mb-2"
                    style="width: 60px; height: 60px; object-fit: cover;">
                <h6 class="mb-1 fw-bold text-truncate" title="${user.name}">
                    ${user.name}
                </h6>
                <small class="text-muted d-block">
                    <strong>P:</strong> ${user.score ?? 0} |
                    <strong>T:</strong> ${user.completion_time ?? "—"}
                </small>
            </div>
            <div class="card-footer bg-transparent border-0 p-2 d-flex justify-content-center gap-2">
                <button class="btn btn-danger"
                    data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                    onclick="fillDeleteUserModal(${user.id})">
                    <i class="bi bi-trash me-1"></i> Eliminar
                </button>
                <button class="btn btn-warning text-white"
                    data-bs-toggle="modal" data-bs-target="#clearUserModal"
                    onclick="fillClearUserModal(${user.id})">
                    <i class="bi bi-eraser me-1"></i> Limpiar
                </button>
            </div>
        </div>
    `;

    return userCard;
}

// Carga todos los usuarios y crea las tarjetas
function loadUsers() {
    const container = document.getElementById("usersContainer");

    fetch("/users/index")
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((users) => {
            container.innerHTML = "";

            if (users.length === 0) {
                container.innerHTML = `
                    <div class="alert alert-info text-center">
                        No hay usuarios registrados.
                    </div>
                `;
                return;
            }

            users.forEach((user, index) => {
                const userCard = createCardUsers(user, index);
                container.appendChild(userCard);
            });
        })
        .catch((err) => {
            console.error("Error al cargar los usuarios:", err);
            container.innerHTML = `
                <div class="alert alert-danger text-center">
                    Error al cargar los usuarios. Intenta nuevamente.
                </div>
            `;
        });
}

// Llamar al cargar la página
document.addEventListener("DOMContentLoaded", loadUsers);

// === ELIMINAR USUARIO ===
function fillDeleteUserModal(id_user) {
    const form = document.querySelector("#deleteUserModal form");
    form.action = `/users/delete/${id_user}`;
    document.getElementById("delete_id_user").value = id_user;
}

// === ELIMINAR USUARIO ===
function fillClearUserModal(id_user) {
    const form = document.querySelector("#clearUserModal form");
    form.action = `/users/clear/${id_user}`;
    document.getElementById("clear_id_user").value = id_user;
}
