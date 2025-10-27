let draggedSentence = null;

export function fillCreateSentenceModal(id_section) {
    const form = document.querySelector("#createSentenceModal form");
    form.querySelector("#id_section").value = id_section;
}

export function fillDeleteSectionModal(id_section) {
    const form = document.querySelector("#deleteSectionModal form");
    form.querySelector("#delete_id_section").value = id_section;
}

// Función para rellenar modal con sección y sus sentencias
export function fillUpdateSectionModal(section) {
    const form = document.getElementById("updateSectionForm");

    form.querySelector("#update_id_section").value = section.id_section;
    form.querySelector("#update_name_section").value = section.name_section;
    form.querySelector("#update_state_section").value = section.state_section;
    form.querySelector("#update_id_profe").value = section.id_profe;

    const container = document.getElementById("sentencesContainer");
    container.innerHTML = "";
    section.sentences.forEach((sentence) => {
        const div = document.createElement("div");
        div.classList.add("list-group-item", "mb-1", "p-2");
        div.setAttribute("draggable", "true");
        div.dataset.id = sentence.id_sentence;

        const input = document.createElement("input");
        input.type = "text";
        input.readOnly = true;
        input.classList.add("form-control");
        input.value = sentence.text_sentence;

        div.appendChild(input);
        container.appendChild(div);

        // Drag events
        div.addEventListener("dragstart", (e) => {
            draggedSentence = div;
            e.dataTransfer.effectAllowed = "move";
        });

        div.addEventListener("dragover", (e) => {
            e.preventDefault();
            e.dataTransfer.dropEffect = "move";
        });

        div.addEventListener("drop", (e) => {
            e.preventDefault();
            if (draggedSentence && draggedSentence !== div) {
                const container = div.parentNode;
                container.insertBefore(draggedSentence, div.nextSibling);
            }
        });
    });
}

