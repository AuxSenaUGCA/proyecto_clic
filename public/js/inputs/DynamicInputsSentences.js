let deletedCubeIds = []; // Cubos eliminados (solo para UPDATE)

document.addEventListener("DOMContentLoaded", function () {
    // === Configuración general de cubos ===
    const config = {
        create: {
            container: document.getElementById("cubesContainer"),
            addBtn: document.getElementById("addCubeBtn"),
            form: document.getElementById("sentenceForm"),
            hiddenSentence: document.getElementById("text_sentence"),
            cubeCount: 0,
            maxCubes: 4,
            inputClass: "cube-input",
            removeClass: "removeCube",
        },
        update: {
            container: document.getElementById("updateCubesContainer"),
            addBtn: document.getElementById("addCubeUpdateBtn"),
            form: document.getElementById("updateSentenceForm"),
            hiddenSentence: document.getElementById("update_text_sentence"),
            cubeCount: 0,
            maxCubes: 4,
            inputClass: "cube-input-update",
            removeClass: "removeCubeUpdate",
        },
    };

    // === Función genérica para crear un cubo ===
    function createCube({
        container,
        cubeIndex,
        value = {},
        id_cube = null,
        inputClass,
        removeClass,
    }) {
        const div = document.createElement("div");
        div.classList.add("input-group", "mb-2");

        div.innerHTML = `
            <span class="input-group-text">Cubo ${cubeIndex}</span>
            <input type="text" name="cubes[${
                cubeIndex - 1
            }][text_cube]" class="form-control ${inputClass}" value="${value.text_cube || ""}" required>
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

        return div;
    }

    // === Función genérica para renumerar cubos ===
    function renumerarCubes(container) {
        Array.from(container.children).forEach((div, i) => {
            div.querySelector(".input-group-text").textContent =
                "Cubo " + (i + 1);
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

    // === Función para manejar ADD de cubos ===
    function handleAdd(configKey) {
        const cfg = config[configKey];
        cfg.addBtn.addEventListener("click", () => {
            if (cfg.cubeCount < cfg.maxCubes) {
                cfg.cubeCount++;
                const div = createCube({
                    container: cfg.container,
                    cubeIndex: cfg.cubeCount,
                    inputClass: cfg.inputClass,
                    removeClass: cfg.removeClass,
                });

                div.querySelector(`.${cfg.removeClass}`).addEventListener(
                    "click",
                    () => {
                        div.remove();
                        cfg.cubeCount--;
                        renumerarCubes(cfg.container);
                    }
                );
            } else {
                alert("Solo puedes agregar hasta 4 cubos.");
            }
        });
    }

    // === Función para manejar SUBMIT ===
    function handleSubmit(configKey) {
        const cfg = config[configKey];
        cfg.form.addEventListener("submit", () => {
            const cubes = cfg.container.querySelectorAll(`.${cfg.inputClass}`);
            const texts = Array.from(cubes).map((input) => input.value.trim());
            cfg.hiddenSentence.value = texts.join(" ");

            if (configKey === "update") {
                // Añadir input oculto con cubos eliminados
                let deletedInput = cfg.form.querySelector(
                    'input[name="deleted_cubes"]'
                );
                if (!deletedInput) {
                    deletedInput = document.createElement("input");
                    deletedInput.type = "hidden";
                    deletedInput.name = "deleted_cubes";
                    cfg.form.appendChild(deletedInput);
                }
                deletedInput.value = deletedCubeIds.join(",");
            }
        });
    }

    // === Inicializar CREATE y UPDATE ===
    handleAdd("create");
    handleSubmit("create");

    handleAdd("update");
    handleSubmit("update");

    // === Función para llenar cubos existentes en modal UPDATE ===
    window.fillUpdateSentenceModal = function (sentence) {
        const cfg = config.update;
        cfg.cubeCount = 0;
        cfg.container.innerHTML = "";
        deletedCubeIds = [];

        document.getElementById("update_state_sentence").value =
            sentence.state_sentence;
        document.getElementById("update_id_sentence").value =
            sentence.id_sentence;

        if (sentence.cubes && sentence.cubes.length > 0) {
            sentence.cubes.forEach((cube, i) => {
                cfg.cubeCount++;
                const div = createCube({
                    container: cfg.container,
                    cubeIndex: cfg.cubeCount,
                    value: cube,
                    id_cube: cube.id_cube,
                    inputClass: cfg.inputClass,
                    removeClass: cfg.removeClass,
                });

                div.querySelector(`.${cfg.removeClass}`).addEventListener(
                    "click",
                    () => {
                        deletedCubeIds.push(cube.id_cube);
                        div.remove();
                        cfg.cubeCount--;
                        renumerarCubes(cfg.container);
                    }
                );
            });
            renumerarCubes(cfg.container);
        }

        cfg.hiddenSentence.value = sentence.text_sentence;
        cfg.form.action = `/sentences/update/${sentence.id_sentence}`;
    };
});
