const trackContainer = document.getElementById("raceTrack");

export async function createRaceUsers(users) {
    trackContainer.innerHTML = "";

    users.sort((a, b) => {
        const scoreA = a.score ?? 0;
        const scoreB = b.score ?? 0;
        if (scoreB !== scoreA) return scoreB - scoreA; 
        const timeA = a.total_time ?? Infinity;
        const timeB = b.total_time ?? Infinity;
        return timeA - timeB; 
    });

    const maxScore = Math.max(...users.map((u) => u.score ?? 0), 1);

    users.forEach((user, index) => {
        const track = document.createElement("div");
        track.classList.add("race-track");

        // Línea central amarilla
        const centerLine = document.createElement("div");
        centerLine.classList.add("center-line");
        track.appendChild(centerLine);

        const runner = document.createElement("div");
        runner.classList.add("runner");

        // 🔹 Avatar a la izquierda
        const avatar = document.createElement("img");
        avatar.classList.add("runner-avatar");
        avatar.src = user.avatar ?? "/img/default-avatar.png";
        avatar.alt = `${user.name} avatar`;

        // 🥇 Cambiar color del borde según posición
        if (index === 0) avatar.style.borderColor = "#FFD700"; // oro
        else if (index === 1) avatar.style.borderColor = "#C0C0C0"; // plata
        else if (index === 2) avatar.style.borderColor = "#CD7F32"; // bronce

        // Contenedor de info
        const infoContainer = document.createElement("div");
        infoContainer.classList.add("runner-info");

        const name = document.createElement("span");
        name.classList.add("runner-name");
        name.textContent = user.name;

        const stats = document.createElement("span");
        stats.classList.add("runner-stats");

        const score = document.createElement("span");
        score.classList.add("runner-score");
        score.textContent = `P: ${user.score ?? 0}`;

        const time = document.createElement("span");
        time.classList.add("runner-time");
        time.textContent = `T: ${user.completion_time ?? "—"}`;

        stats.appendChild(score);
        stats.appendChild(time);
        infoContainer.appendChild(name);
        infoContainer.appendChild(stats);

        // Orden visual: avatar → info
        runner.appendChild(avatar);
        runner.appendChild(infoContainer);

        track.appendChild(runner);
        trackContainer.appendChild(track);

        // Posicionar corredor según score
        let progress = (user.score / maxScore) * 90;
        if (progress < 2) progress = 2;
        runner.style.left = `${progress}%`;
    });
}
