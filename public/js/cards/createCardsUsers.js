// Crea y devuelve la card de un usuario
function createCardUsers(user) {
    const userCard = document.createElement("div");
    userCard.className = "col-md-4 mb-4 user-card";
    userCard.dataset.id = user.id;

    userCard.innerHTML = `
        <div class="card shadow h-100">
            <div class="card-header bg-primary text-white">
                Usuario #${user.id}
            </div>
            <div class="card-body text-center">
                <img src="${user.avatar || "/images/default-avatar.png"}" 
                    alt="Avatar" class="img-fluid rounded-circle mb-3" 
                    style="width: 80px; height: 80px; object-fit: cover;">
                <h5>${user.name}</h5>
                <p><strong>Puntaje:</strong> ${user.score ?? 0}</p>
                <p><strong>Tiempo de completado:</strong> ${
                    user.completion_time ?? "—"
                }</p>
            </div>
            <div class="card-footer text-center">
                <button class="btn btn-danger btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#deleteUserModal"
                    onclick="fillDeleteUserModal(${user.id})">
                    Eliminar Usuario
                </button>
                <button class="btn btn-danger btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#clearUserModal"
                    onclick="fillClearUserModal(${user.id})">
                    Limpiar Datos Usuario
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
        .then((res) => res.json())
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

            users.forEach((user) => {
                const card = createCardUsers(user);
                container.appendChild(card);
            });
        })
        .catch((err) => {
            console.error("Error al cargar los usuarios:", err);
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

