import { loadSections } from "../load/LoadPage.js";
import { deletedCubeIds } from "../inputs/sentences/UpdateSentencesInputs.js";

const formCreateSentence = document.querySelector("#createSentenceModal form");
const formUpdateSentence = document.querySelector("#updateSentenceModal form");
const formDeleteSentence = document.querySelector("#deleteSentenceModal form");

function CreateSentence(event) {
    event.preventDefault();
    const formData = new FormData(formCreateSentence);

    let text_sentence = "";
    let cubesTexts = [];

    for (let [key, value] of formData.entries()) {
        if (key.includes("text_cube")) {
            cubesTexts.push(value.trim());
        }
    }

    text_sentence = cubesTexts.join(" ");

    formData.set("text_sentence", text_sentence);

    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch("/sentences/store", {
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
                formCreateSentence.reset();
            } else {
                console.error("Error al crear la frase:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function UpdateSentence(event) {
    event.preventDefault();

    const formData = new FormData(formUpdateSentence);

    let text_sentence = "";
    let cubesTexts = [];

    for (let [key, value] of formData.entries()) {
        if (key.includes("text_cube")) {
            cubesTexts.push(value.trim());
        }
    }

    text_sentence = cubesTexts.join(" ");

    formData.set("text_sentence", text_sentence);
    formData.set("deleted_cubes", deletedCubeIds.join(","));
    formData.set("_method", "PUT"); // Laravel lo interpretará como PUT

    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/sentences/update/${formData.get("id_sentence")}`, {
        method: "POST",
        headers: { "X-CSRF-TOKEN": token },
        body: formData,
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                loadSections();
                formUpdateSentence.reset();
            } else {
                console.error("Error al crear la sección:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

function DeleteSentence(event) {
    event.preventDefault();

    const formData = new FormData(formDeleteSentence);
    const token = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    fetch(`/sentences/delete/${formData.get("id_sentence")}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": token,
        },
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                loadSections();
                formDeleteSentence.reset();
            } else {
                console.error("Error al crear la sección:", data);
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}

// ============== EVENTOS ============== //
formCreateSentence.addEventListener("submit", CreateSentence);
formUpdateSentence.addEventListener("submit", UpdateSentence);
formDeleteSentence.addEventListener("submit", DeleteSentence);
