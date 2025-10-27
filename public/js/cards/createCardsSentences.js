import { fillUpdateSentenceModal, fillDeleteSentenceModal } from "../sentences/fillFieldsSentences.js";

// Crea y devuelve la card de una frase, con cubos
export function createCardSentences(sentence) {
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
                    data-bs-toggle="modal" data-bs-target="#updateSentenceModal" id="EditarFrase">
                    Editar Frase
                </button>
                <button class="btn btn-danger btn-sm" 
                    data-bs-toggle="modal" data-bs-target="#deleteSentenceModal" id="EliminarFrase">
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

    // ============== EVENTOS ============== //
    const editarFraseBtn = sentenceCard.querySelector("#EditarFrase");
    editarFraseBtn.addEventListener("click", () => {
        fillUpdateSentenceModal(sentence);
    });

    const eliminarFraseBtn = sentenceCard.querySelector("#EliminarFrase");
    eliminarFraseBtn.addEventListener("click", () => {
        fillDeleteSentenceModal(sentence.id_sentence);
    });

    return sentenceCard;
}
