document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("SearchBar");
    const resultsDiv = document.getElementById("searchResults");
    const filterSelect = document.querySelector(".form-select");

    function performSearch() {
        const query = searchInput.value.trim();
        const filter = filterSelect.value;

        // ✅ Si el campo de búsqueda está vacío, aplicar solo el filtro
        if (query.length === 0) {
            fetch(`/sections/search?filter=${filter}`)
                .then((res) => res.json())
                .then((data) => {
                    resultsDiv.innerHTML = "";

                    if (data.length === 0) {
                        resultsDiv.innerHTML =
                            "<div class='list-group-item'>Sin resultados</div>";
                        document
                            .querySelectorAll(
                                "#sectionsContainer .section-card"
                            )
                            .forEach((card) => (card.style.display = "none"));
                        return;
                    }

                    // Mostrar todas las cards según el filtro
                    const ids = data.map((s) => s.id_section);
                    document
                        .querySelectorAll("#sectionsContainer .section-card")
                        .forEach((card) => {
                            card.style.display = ids.includes(
                                Number(card.dataset.id)
                            )
                                ? "block"
                                : "none";
                        });
                })
                .catch((error) =>
                    console.error("Error al aplicar filtro:", error)
                );
            return;
        }

        // 🔍 Si hay texto, hacer búsqueda normal
        fetch(
            `/sections/search?q=${encodeURIComponent(query)}&filter=${filter}`
        )
            .then((res) => res.json())
            .then((data) => {
                resultsDiv.innerHTML = "";

                if (data.length === 0) {
                    resultsDiv.innerHTML =
                        "<div class='list-group-item'>Sin resultados</div>";
                    document
                        .querySelectorAll("#sectionsContainer .section-card")
                        .forEach((card) => (card.style.display = "none"));
                    return;
                }

                data.forEach((section) => {
                    const item = document.createElement("button");
                    item.classList.add(
                        "list-group-item",
                        "list-group-item-action"
                    );
                    item.textContent = `${section.name_section} - Profesor ID: ${section.id_profe}`;
                    item.addEventListener("click", function () {
                        searchInput.value = `Sección #${section.id_section}`;
                        resultsDiv.innerHTML = "";
                        filterVisibleCards(section.id_section);
                    });
                    resultsDiv.appendChild(item);
                });

                const ids = data.map((s) => s.id_section);
                document
                    .querySelectorAll("#sectionsContainer .section-card")
                    .forEach((card) => {
                        card.style.display = ids.includes(
                            Number(card.dataset.id)
                        )
                            ? "block"
                            : "none";
                    });
            })
            .catch((error) =>
                console.error("Error al buscar secciones:", error)
            );
    }

    searchInput.addEventListener("input", performSearch);
    filterSelect.addEventListener("change", performSearch);

    function filterVisibleCards(id_section) {
        document
            .querySelectorAll("#sectionsContainer .section-card")
            .forEach((card) => {
                card.style.display =
                    card.dataset.id == id_section ? "block" : "none";
            });
    }
});
