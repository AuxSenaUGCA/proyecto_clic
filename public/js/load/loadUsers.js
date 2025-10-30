import { createCardUsers } from "../cards/createCardsUsers.js";
import { createRaceUsers } from "../cards/createRaceUsers.js";

export function loadUsers() {
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

export function updateUsersRace() {
    fetch("/users/index")
        .then((res) => {
            if (!res.ok) throw new Error("Error HTTP " + res.status);
            return res.json();
        })
        .then((users) => {
            if (users.length === 0) {
                return;
            }

            createRaceUsers(users);
        })
        .catch((err) => {
            console.error("Error al cargar los usuarios:", err);
        });
}
