// Crea y devuelve la card de una frase, con cubos
function createCardSentences(sentence) {
    const sentenceCard = document.createElement("div");
    sentenceCard.className = "col-md-12 mb-4 sentence-card";
    sentenceCard.dataset.id = sentence.id_sentence;

    sentenceCard.innerHTML = `
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                Frase #${sentence.number_sentence}
            </div>
            <div class="card-body">
                <p><strong>Texto:</strong> ${sentence.text_sentence}</p>
                <p><strong>Estado:</strong> 
                    <span class="badge ${
                        sentence.state_sentence === "active"
                            ? "bg-success"
                            : "bg-secondary"
                    }">
                        ${
                            sentence.state_sentence.charAt(0).toUpperCase() +
                            sentence.state_sentence.slice(1)
                        }
                    </span>
                </p>
                <hr>
                <h6>Cubos:</h6>
                <div class="row" id="cubes_for_${sentence.id_sentence}"></div>
            </div>
            <div class="card-footer">
                <button class="btn btn-warning btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#updateSentenceModal"
                    onclick='fillUpdateSentenceModal(${JSON.stringify(
                        sentence
                    )})'>
                    Editar Frase
                </button>
                <button class="btn btn-danger btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#deleteSentenceModal"
                    onclick="fillDeleteSentenceModal(${sentence.id_sentence})">
                    Eliminar Frase
                </button>
            </div>
        </div>
    `;

    // Cubos
    const cubeContainer = sentenceCard.querySelector(
        `#cubes_for_${sentence.id_sentence}`
    );
    sentence.cubes.forEach((cube) => {
        const cubeCard = document.createElement("div");
        cubeCard.className = "col-md-3 mb-3";
        cubeCard.innerHTML = `
            <div class="card h-100">
                <div class="card-header bg-info text-white">Cubo #${
                    cube.number_cube
                }</div>
                <div class="card-body">
                    <p>${cube.text_cube}</p>
                    <span class="badge ${
                        cube.state_cube === "active"
                            ? "bg-success"
                            : "bg-secondary"
                    }">
                        ${
                            cube.state_cube.charAt(0).toUpperCase() +
                            cube.state_cube.slice(1)
                        }
                    </span>
                </div>
            </div>
        `;
        cubeContainer.appendChild(cubeCard);
    });

    return sentenceCard;
}

function loadSentences() {
    const container = document.getElementById("sentencesContainer");

    fetch("/sentences/index")
        .then((res) => res.json())
        .then((sentences) => {
            container.innerHTML = "";
            sentences.forEach((sentence) => {
                const card = createCardSentences(sentence);
                container.appendChild(card);
            });
        });
}

// Llamar al cargar la página
document.addEventListener("DOMContentLoaded", loadSentences);

function fillUpdateSentenceModal(sentence) {
    // Formulario
    const form = document.querySelector("#updateSentenceModal form");
    form.action = `/sentences/update/${sentence.id_sentence}`;

    // Estado
    document.getElementById("update_state_sentence").value =
        sentence.state_sentence;

    // Inputs dinámicos de cubos
    let container = document.getElementById("updateCubesContainer");
    container.innerHTML = "";

    if (sentence.cubes && sentence.cubes.length > 0) {
        sentence.cubes.forEach((cube) => {
            let input = document.createElement("input");
            input.type = "text";
            input.name = "cubes[]";
            input.value = cube.text_cube;
            input.classList.add("form-control", "mb-2");
            container.appendChild(input);
        });
    }

    // Guardar el id para la eliminación si se requiere
    document.getElementById("delete_id_sentence").value = sentence.id_sentence;
}

// === ELIMINAR FRASE ===
function fillDeleteSentenceModal(id_sentence) {
    // Cambiar acción del formulario
    const form = document.querySelector("#deleteSentenceModal form");
    form.action = `/sentences/delete/${id_sentence}`; // DELETE
    document.getElementById("delete_id_sentence").value = id_sentence;
}
