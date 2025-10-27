import { createCubeUpdate } from "../inputs/sentences/UpdateSentencesInputs.js";

// --- Función para rellenar el modal de actualización ---
export function fillUpdateSentenceModal(sentence) {
    const form = document.querySelector("#updateSentenceModal form");

    // Estado de la frase
    form.querySelector("#update_state_sentence").value =
        sentence.state_sentence;

    // Cubos
    const container = form.querySelector("#updateCubesContainer");
    container.innerHTML = "";
    let cubeCount = 0;

    cubes.forEach((cube) => {
        cubeCount++;
        createCubeUpdate({
            container,
            cubeIndex: cubeCount,
            value: cube,
            id_cube: cube.id_cube || null,
        });
    });

    form.querySelector("#update_id_sentence").value = sentence.id_sentence;
}

// === ELIMINAR FRASE ===
export function fillDeleteSentenceModal(id_sentence) {
    // Cambiar acción del formulario
    const form = document.querySelector("#deleteSentenceModal form");
    form.querySelector("#delete_id_sentence").value = id_sentence;
}
