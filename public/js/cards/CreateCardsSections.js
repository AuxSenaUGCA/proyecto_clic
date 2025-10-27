import { loadSections } from "../load/LoadPage.js";
import { createCardSentences } from "./CreateCardsSentences.js";
import {
    fillCreateSentenceModal,
    fillDeleteSectionModal,
    fillUpdateSectionModal,
} from "../sections/fillFieldsSections.js";

// === Crear Card para una Sección ===
export function createCardSection(section) {
    const sectionCard = document.createElement("div");
    sectionCard.className = "col-md-12 mb-4 section-card";
    sectionCard.dataset.id = section.id_section;
    sectionCard.innerHTML = `
        <div class="card shadow">
            <div class="card-header bg-secondary text-white d-flex justify-content-between align-items-center">
                <span><strong>Sección:</strong> ${section.name_section}</span>
                <span class="badge ${
                    section.state_section === "active"
                        ? "bg-success"
                        : "bg-secondary"
                }">
                    ${
                        section.state_section.charAt(0).toUpperCase() +
                        section.state_section.slice(1)
                    }
                </span>
            </div>

            <div class="card-body">
                <p><strong>Profesor:</strong> ${
                    section.profesor ? section.profesor.name : "Sin asignar"
                }</p>

                <hr>
                <h6>Frases:</h6>
                <div class="row" id="sentences_for_${
                    section.id_section
                }" style="max-height: 25rem; overflow-y: auto;">
                    <p class="text-muted">Cargando frases...</p>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <button class="btn btn-success btn-sm" 
                    data-bs-toggle="modal"
                    data-bs-target="#createSentenceModal" id="AgregarFrase">
                    + Agregar Frase
                </button>
                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" 
                    data-bs-target="#updateSectionModal" id="EditarSeccion">
                    Editar
                </button>
                <button class="btn btn-danger btn-sm" data-bs-toggle="modal" 
                    data-bs-target="#deleteSectionModal" id="EliminarSeccion">
                    Eliminar
                </button>
            </div>
        </div>
    `;

    // Contenedor donde se mostrarán las frases
    const sentencesContainer = sectionCard.querySelector(
        `#sentences_for_${section.id_section}`
    );

    // === Cargar frases asociadas desde la ruta ===
    fetch(`/sentences/indexSection/${section.id_section}`)
        .then((res) => res.json())
        .then((sentences) => {
            sentencesContainer.innerHTML = "";
            if (sentences.length === 0) {
                sentencesContainer.innerHTML = `<p class="text-muted">No hay frases registradas para esta sección.</p>`;
                return;
            }

            sentences.forEach((sentence) => {
                const card = createCardSentences(sentence); // Usa tu función ya existente
                sentencesContainer.appendChild(card);
            });
        })
        .catch((err) => {
            console.error(
                `Error cargando frases de la sección ${section.id_section}:`,
                err
            );
            sentencesContainer.innerHTML = `<p class="text-danger">Error al cargar frases.</p>`;
        });

    // ============== EVENTOS ============== //
    const agregarFraseBtn = sectionCard.querySelector("#AgregarFrase");
    agregarFraseBtn.addEventListener("click", () => {
        fillCreateSentenceModal(section.id_section);
    });

    const editarSeccionBtn = sectionCard.querySelector("#EditarSeccion");
    editarSeccionBtn.addEventListener("click", () => {
        fillUpdateSectionModal(section);
    });

    const eliminarSeccionBtn = sectionCard.querySelector("#EliminarSeccion");
    eliminarSeccionBtn.addEventListener("click", () => {
        fillDeleteSectionModal(section.id_section);
    });

    return sectionCard;
}

document.addEventListener("DOMContentLoaded", loadSections());
