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
                loadSections();
                formCreateSection.reset();
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

    const formData = new FormData(formUpdateSection);
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
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                loadSections();
                formUpdateSection.reset();
            } else {
                console.error("Error al crear la sección:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
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
                loadSections();
                formDeleteSection.reset();
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
