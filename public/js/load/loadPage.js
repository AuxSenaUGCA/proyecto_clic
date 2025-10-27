import { createCardSection } from "../cards/CreateCardsSections.js";

export function loadSections() {
    const container = document.getElementById("sectionsContainer");

    fetch("/sections/index")
        .then((res) => res.json())
        .then((sections) => {
            container.innerHTML = "";
            if (sections.length === 0) {
                container.innerHTML = `<p class="text-muted">No hay secciones registradas.</p>`;
                return;
            }
            console.log(sections)
            sections.forEach((section) => {
                const card = createCardSection(section);
                container.appendChild(card);
            });
        })
        .catch((err) => {
            console.error("Error al cargar secciones:", err);
            container.innerHTML = `<p class="text-danger">Error al cargar secciones.</p>`;
        });
}

// Carga todos los usuarios y crea las tarjetas
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
