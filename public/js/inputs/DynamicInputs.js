document.addEventListener("DOMContentLoaded", function () {
    let cubeCount = 0;
    const maxCubes = 4;
    const container = document.getElementById("cubesContainer");
    const addBtn = document.getElementById("addCubeBtn");
    const form = document.getElementById("sentenceForm");
    const hiddenSentence = document.getElementById("text_sentence");

    addBtn.addEventListener("click", function () {
        if (cubeCount < maxCubes) {
            const div = document.createElement("div");
            div.classList.add("input-group", "mb-2");
            div.innerHTML = `
                <span class="input-group-text">Cubo ${cubeCount + 1}</span>
                <input type="text" name="cubes[${cubeCount}][text_cube]" class="form-control cube-input" required>
                <select name="cubes[${cubeCount}][state_cube]" class="form-select">
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>
                <button type="button" class="btn btn-danger removeCube">X</button>
            `;
            container.appendChild(div);
            cubeCount++;

            // Botón eliminar
            div.querySelector(".removeCube").addEventListener(
                "click",
                function () {
                    div.remove();
                    cubeCount--;
                    renumerarCubes();
                }
            );
        } else {
            alert("Solo puedes agregar hasta 4 cubos.");
        }
    });

    // Antes de enviar el formulario → juntar textos
    form.addEventListener("submit", function () {
        const cubes = document.querySelectorAll(".cube-input");
        const texts = [];
        cubes.forEach((input) => texts.push(input.value.trim()));
        hiddenSentence.value = texts.join(" ");
    });

    // Renumerar cubos
    function renumerarCubes() {
        let i = 1;
        document
            .querySelectorAll("#cubesContainer .input-group-text")
            .forEach((span) => {
                span.textContent = "Cubo " + i++;
            });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    let cubeCountUpdate = 0;
    const maxCubesUpdate = 4;
    const containerUpdate = document.getElementById("updateCubesContainer");
    const addBtnUpdate = document.getElementById("addCubeUpdateBtn");
    const formUpdate = document.getElementById("updateSentenceForm");
    const hiddenSentenceUpdate = document.getElementById(
        "update_text_sentence"
    );

    // === Botón agregar cubo en UPDATE ===
    addBtnUpdate.addEventListener("click", function () {
        if (cubeCountUpdate < maxCubesUpdate) {
            const div = document.createElement("div");
            div.classList.add("input-group", "mb-2");
            div.innerHTML = `
                <span class="input-group-text">Cubo ${
                    cubeCountUpdate + 1
                }</span>
                <input type="text" name="cubes[${cubeCountUpdate}][text_cube]" class="form-control cube-input-update" required>
                <select name="cubes[${cubeCountUpdate}][state_cube]" class="form-select">
                    <option value="active">Activo</option>
                    <option value="inactive">Inactivo</option>
                </select>                
                <button type="button" class="btn btn-danger removeCubeUpdate">X</button>
            `;
            containerUpdate.appendChild(div);
            cubeCountUpdate++;

            // Botón eliminar
            div.querySelector(".removeCubeUpdate").addEventListener(
                "click",
                function () {
                    div.remove();
                    cubeCountUpdate--;
                    renumerarCubesUpdate();
                }
            );
        } else {
            alert("Solo puedes agregar hasta 4 cubos.");
        }
    });

    // === Antes de enviar formulario UPDATE ===
    formUpdate.addEventListener("submit", function () {
        const cubes = document.querySelectorAll(".cube-input-update");
        const texts = [];
        cubes.forEach((input) => texts.push(input.value.trim()));
        hiddenSentenceUpdate.value = texts.join(" ");
    });

    // === Renumerar cubos al eliminar ===
    function renumerarCubesUpdate() {
        let i = 1;
        document
            .querySelectorAll("#updateCubesContainer .input-group-text")
            .forEach((span) => {
                span.textContent = "Cubo " + i++;
            });
    }

    // === Llenar cubos existentes en modal UPDATE ===
    window.fillUpdateSentenceModal = function (sentence) {
        cubeCountUpdate = 0;
        containerUpdate.innerHTML = "";

        // Estado general
        document.getElementById("update_state_sentence").value =
            sentence.state_sentence;
        document.getElementById("update_id_sentence").value =
            sentence.id_sentence;

        // Cubos actuales
        if (sentence.cubes && sentence.cubes.length > 0) {
            sentence.cubes.forEach((cube) => {
                cubeCountUpdate++;
                const div = document.createElement("div");
                div.classList.add("input-group", "mb-2");
                div.innerHTML = `
                    <span class="input-group-text">Cubo ${cubeCountUpdate}</span>
                    <input type="text" name="cubes[${cubeCountUpdate}][text_cube]" class="form-control cube-input-update" value="${
                    cube.text_cube
                }" required>
                    <select name="cubes[${cubeCountUpdate}][state_cube]" class="form-select">
                        <option value="active" ${
                            cube.state_cube === "active" ? "selected" : ""
                        }>Activo</option>
                        <option value="inactive" ${
                            cube.state_cube === "inactive" ? "selected" : ""
                        }>Inactivo</option>
                    </select>
                    <input type="hidden" name="cubes[${cubeCountUpdate}][id_cube]" value="${
                    cube.id_cube
                }">
                    <button type="button" class="btn btn-danger removeCubeUpdate">X</button>
                `;
                containerUpdate.appendChild(div);

                div.querySelector(".removeCubeUpdate").addEventListener(
                    "click",
                    function () {
                        div.remove();
                        cubeCountUpdate--;
                        renumerarCubesUpdate();
                    }
                );
            });
        }

        // Resetear frase oculta
        hiddenSentenceUpdate.value = sentence.text_sentence;
        formUpdate.action = `/sentences/update/${sentence.id_sentence}`;
    };
});
