document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("sentenceSearch");
    const resultsDiv = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();

        if (query.length < 2) {
            resultsDiv.innerHTML = "";
            // Mostrar todas las cards si input vacío
            document
                .querySelectorAll("#sentencesContainer .sentence-card")
                .forEach((card) => (card.style.display = "block"));
            return;
        }

        fetch(`/sentences/search?q=${encodeURIComponent(query)}`)
            .then((res) => res.json())
            .then((data) => {
                resultsDiv.innerHTML = "";

                if (data.length === 0) {
                    resultsDiv.innerHTML =
                        "<div class='list-group-item'>Sin resultados</div>";
                    return;
                }

                data.forEach((sentence) => {
                    const item = document.createElement("button");
                    item.classList.add(
                        "list-group-item",
                        "list-group-item-action"
                    );
                    item.textContent = sentence.text_sentence;
                    item.addEventListener("click", function () {
                        searchInput.value = sentence.text_sentence;
                        resultsDiv.innerHTML = "";
                        filterVisibleCards(sentence.id_sentence);
                    });
                    resultsDiv.appendChild(item);
                });
            });
    });

    // Mostrar solo la card seleccionada
    function filterVisibleCards(id_sentence) {
        document
            .querySelectorAll("#sentencesContainer .sentence-card")
            .forEach((card) => {
                card.style.display =
                    card.dataset.id == id_sentence ? "block" : "none";
            });
    }
});
