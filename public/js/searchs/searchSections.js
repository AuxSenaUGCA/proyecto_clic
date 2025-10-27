document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("SearchBar");
    const resultsDiv = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();

        if (query.length < 2) {
            resultsDiv.innerHTML = "";
            // Mostrar todas las cards si input vacío
            document
                .querySelectorAll("#sectionsContainer .section-card")
                .forEach((card) => (card.style.display = "block"));
            return;
        }

        fetch(`/sections/search?q=${encodeURIComponent(query)}`)
            .then((res) => res.json())
            .then((data) => {
                resultsDiv.innerHTML = "";

                if (data.length === 0) {
                    resultsDiv.innerHTML =
                        "<div class='list-group-item'>Sin resultados</div>";
                    return;
                }

                data.forEach((section) => {
                    const item = document.createElement("button");
                    item.classList.add(
                        "list-group-item",
                        "list-group-item-action"
                    );

                    // Si tu tabla tiene un campo de texto visible (como "nombre_section" o "titulo"),
                    // cámbialo aquí para que se muestre algo más descriptivo.
                    item.textContent = `Sección #${section.id_section} - Profesor ID: ${section.id_profesor}`;

                    item.addEventListener("click", function () {
                        searchInput.value = `Sección #${section.id_section}`;
                        resultsDiv.innerHTML = "";
                        filterVisibleCards(section.id_section);
                    });

                    resultsDiv.appendChild(item);
                });
            })
            .catch((error) => {
                console.error("Error al buscar secciones:", error);
            });
    });

    // Mostrar solo la card seleccionada
    function filterVisibleCards(id_section) {
        document
            .querySelectorAll("#sectionsContainer .section-card")
            .forEach((card) => {
                card.style.display =
                    card.dataset.id == id_section ? "block" : "none";
            });
    }
});
