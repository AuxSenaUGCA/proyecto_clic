export function fillCreateSentenceModal(id_section) {
    const form = document.querySelector("#createSentenceModal form");
    form.querySelector("#id_section").value = id_section;
}

export function fillDeleteSectionModal(id_section) {
    const form = document.querySelector("#deleteSectionModal form");
    form.querySelector("#delete_id_section").value = id_section;
}
