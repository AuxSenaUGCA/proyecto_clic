import { loadSections } from "../load/LoadPage.js";

const formCreateSection = document.querySelector("#createSectionModal form");
const formUpdateSection = document.querySelector("#updateSectionModal form");
const formDeleteSection = document.querySelector("#deleteSectionModal form");

function CreateSection(event) {
    event.preventDefault();

    const formData = new FormData(formCreateSection);
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/sections/store", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const modalEl = document.getElementById("createSectionModal");
                const modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                if (modal) {
                    modal.hide();
                    loadSections();
                    formUpdateSection.reset();
                }
            } else {
                console.error("Error al crear la sección:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function UpdateSection(event) {
    event.preventDefault();
    const form = this;
    const formData = new FormData(form);

    // Capturar orden de sentencias
    const sentencesContainer = document.getElementById("sentencesContainer");
    const sentenceInputs = Array.from(sentencesContainer.children);

    sentenceInputs.forEach((div, index) => {
        const id = div.dataset.id;
        formData.append(`sentences[${index}][id_sentence]`, id);
        formData.append(
            `sentences[${index}][text_sentence]`,
            div.querySelector("input").value
        );
        formData.append(`sentences[${index}][number_sentence]`, index + 1); // número según el orden
    });
    formData.set("_method", "PUT");

    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/sections/update/${formData.get("id_section")}`, {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": token,
        },
        body: formData,
    })
        .then((res) => res.json())
        .then((data) => {
            if (data.success) {
                const modalEl = document.getElementById("updateSectionModal");
                const modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                if (modal) {
                    modal.hide();
                    loadSections();
                    formUpdateSection.reset();
                }
            }
        });
}

function DeleteSection(event) {
    event.preventDefault();

    const formData = new FormData(formDeleteSection);
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/sections/delete/${formData.get("id_section")}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                const modalEl = document.getElementById("deleteSectionModal");
                const modal =
                    bootstrap.Modal.getInstance(modalEl) ||
                    new bootstrap.Modal(modalEl);
                if (modal) {
                    modal.hide();
                    loadSections();
                    formUpdateSection.reset();
                }
            } else {
                console.error("Error al crear la sección:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

// ============== EVENTOS ============== //
formCreateSection.addEventListener("submit", CreateSection);
formUpdateSection.addEventListener("submit", UpdateSection);
formDeleteSection.addEventListener("submit", DeleteSection);
