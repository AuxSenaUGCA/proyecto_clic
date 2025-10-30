import { loadSections } from "./loadMain.js";

export function renderPaginator(sectionsData) {
    const paginator = document.getElementById("paginator");
    paginator.innerHTML = "";

    const { current_page, last_page } = sectionsData;

    // Botón "Anterior"
    const prevBtn = document.createElement("button");
    prevBtn.textContent = "« Anterior";
    prevBtn.disabled = current_page === 1;
    prevBtn.addEventListener("click", () => loadSections(current_page - 1));
    paginator.appendChild(prevBtn);

    // Números de página
    for (let i = 1; i <= last_page; i++) {
        const pageBtn = document.createElement("button");
        pageBtn.textContent = i;

        if (i === current_page) {
            pageBtn.classList.add("active");
        }

        pageBtn.addEventListener("click", () => loadSections(i));
        paginator.appendChild(pageBtn);
    }

    // Botón "Siguiente"
    const nextBtn = document.createElement("button");
    nextBtn.textContent = "Siguiente »";
    nextBtn.disabled = current_page === last_page;
    nextBtn.addEventListener("click", () => loadSections(current_page + 1));
    paginator.appendChild(nextBtn);
}
