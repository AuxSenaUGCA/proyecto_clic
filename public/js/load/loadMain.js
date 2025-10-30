import { createCardSection } from "../cards/CreateCardsSections.js";
import { renderPaginator } from "./paginador.js";

export function loadSections(page = 1) {
    // <-- page por defecto 1
    const container = document.getElementById("sectionsContainer");

    fetch(`/sections/indexPaginated?page=${page}`) 
        .then((res) => res.json())
        .then((sections) => {
            container.innerHTML = "";
            if (sections.data.length === 0) {
                container.innerHTML = `<p class="text-muted">No hay secciones registradas.</p>`;
                return;
            }
            sections.data.forEach((section) => {
                const card = createCardSection(section);
                container.appendChild(card);
            });
            renderPaginator(sections);
        })
        .catch((err) => {
            console.error("Error al cargar secciones:", err);
            container.innerHTML = `<p class="text-danger">Error al cargar secciones.</p>`;
        });
}


