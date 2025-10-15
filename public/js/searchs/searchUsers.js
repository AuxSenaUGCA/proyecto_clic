document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("userSearch");
    const resultsDiv = document.getElementById("searchResults");

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();

        if (query.length < 2) {
            resultsDiv.innerHTML = "";
            // Mostrar todas las cards si input vacío
            document
                .querySelectorAll("#usersContainer .user-card")
                .forEach((card) => (card.style.display = "block"));
            return;
        }

        fetch(`/users/search?q=${encodeURIComponent(query)}`)
            .then((res) => res.json())
            .then((data) => {
                resultsDiv.innerHTML = "";

                if (data.length === 0) {
                    resultsDiv.innerHTML =
                        "<div class='list-group-item'>Sin resultados</div>";
                    return;
                }

                data.forEach((user) => {
                    const item = document.createElement("button");
                    item.classList.add(
                        "list-group-item",
                        "list-group-item-action"
                    );
                    item.textContent = user.name;
                    item.addEventListener("click", function () {
                        searchInput.value = user.name;
                        resultsDiv.innerHTML = "";
                        filterVisibleCards(user.id);
                    });
                    resultsDiv.appendChild(item);
                });
            })
            .catch((err) => console.error("Error al buscar usuarios:", err));
    });

    // Mostrar solo la card seleccionada
    function filterVisibleCards(id_user) {
        document
            .querySelectorAll("#usersContainer .user-card")
            .forEach((card) => {
                card.style.display =
                    card.dataset.id == id_user ? "block" : "none";
            });
    }
});
