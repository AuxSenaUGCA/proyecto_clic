export let deletedCubeIds = [];

const form = document.querySelector("#updateSentenceModal form");
const addBtn = form.querySelector("#addCubeUpdateBtn");
const container = form.querySelector("#updateCubesContainer");
const inputClass = "cube-input-update";
const removeClass = "removeCubeUpdate";
const maxCubes = 4;
let cubeCount = 0;

// --- Función para crear un cubo ---
export function createCubeUpdate({
    container,
    cubeIndex,
    value = {},
    id_cube = null,
}) {
    const div = document.createElement("div");
    div.classList.add("input-group", "mb-2");

    div.innerHTML = `
            <span class="input-group-text">Cubo ${cubeIndex}</span>
            <input type="text" name="cubes[${
                cubeIndex - 1
            }][text_cube]" class="form-control ${inputClass}" 
            value="${value.text_cube || ""}" required>
            <select name="cubes[${
                cubeIndex - 1
            }][state_cube]" class="form-select">
                <option value="active" ${
                    value.state_cube === "active" ? "selected" : ""
                }>Activo</option>
                <option value="inactive" ${
                    value.state_cube === "inactive" ? "selected" : ""
                }>Inactivo</option>
            </select>
            ${
                id_cube
                    ? `<input type="hidden" name="cubes[${
                          cubeIndex - 1
                      }][id_cube]" value="${id_cube}">`
                    : ""
            }
            <button type="button" class="btn btn-danger ${removeClass}">X</button>
        `;
    container.appendChild(div);

    div.querySelector(`.${removeClass}`).addEventListener("click", () => {
        if (id_cube) deletedCubeIds.push(id_cube);
        div.remove();
        cubeCount--;
        renumerarCubes(container);
    });
}

function renumerarCubes(container) {
    Array.from(container.children).forEach((div, i) => {
        div.querySelector(".input-group-text").textContent = `Cubo ${i + 1}`;
        div.querySelector("input[type=text]").setAttribute(
            "name",
            `cubes[${i}][text_cube]`
        );
        div.querySelector("select").setAttribute(
            "name",
            `cubes[${i}][state_cube]`
        );
        const hiddenId = div.querySelector('input[type="hidden"]');
        if (hiddenId) hiddenId.setAttribute("name", `cubes[${i}][id_cube]`);
    });
}

// --- Botón para agregar cubo ---
addBtn.addEventListener("click", () => {
    if (cubeCount < maxCubes) {
        cubeCount++;
        createCubeUpdate({ container, cubeIndex: cubeCount });
    } else {
        alert("Solo puedes agregar hasta 4 cubos.");
    }
});
