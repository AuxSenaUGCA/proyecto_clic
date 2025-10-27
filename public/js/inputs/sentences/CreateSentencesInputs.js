document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("#createSentenceModal form");
    const addBtn = form.querySelector("#addCubeBtn");
    const container = form.querySelector("#cubesContainer");
    const inputClass = "cube-input";
    const removeClass = "removeCube";
    const maxCubes = 4;
    let cubeCount = 0;

    // Crear cubo dinámico
    function createCube({ container, cubeIndex, inputClass, removeClass }) {
        const div = document.createElement("div");
        div.classList.add("input-group", "mb-2");

        div.innerHTML = `
            <span class="input-group-text">Cubo ${cubeIndex}</span>
            <input type="text" name="cubes[${
                cubeIndex - 1
            }][text_cube]" class="form-control ${inputClass}" required>
            <select name="cubes[${
                cubeIndex - 1
            }][state_cube]" class="form-select">
                <option value="active" selected>Activo</option>
                <option value="inactive">Inactivo</option>
            </select>
            <button type="button" class="btn btn-danger ${removeClass}">X</button>
        `;
        container.appendChild(div);

        div.querySelector(`.${removeClass}`).addEventListener("click", () => {
            div.remove();
            cubeCount--;
            renumerarCubes(container);
        });
    }

    // Renumerar cubos
    function renumerarCubes(container) {
        Array.from(container.children).forEach((div, i) => {
            div.querySelector(".input-group-text").textContent = `Cubo ${
                i + 1
            }`;
            div.querySelector("input[type=text]").setAttribute(
                "name",
                `cubes[${i}][text_cube]`
            );
            div.querySelector("select").setAttribute(
                "name",
                `cubes[${i}][state_cube]`
            );
        });
    }

    // Agregar cubo
    addBtn.addEventListener("click", () => {
        if (cubeCount < maxCubes) {
            cubeCount++;
            createCube({
                container: container,
                cubeIndex: cubeCount,
                inputClass: inputClass,
                removeClass: removeClass,
            });
        } else {
            alert("Solo puedes agregar hasta 4 cubos.");
        }
    });
});
