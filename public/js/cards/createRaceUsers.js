const trackContainer = document.getElementById("raceTrack");

export async function createRaceUsers(users) {
    trackContainer.innerHTML = "";

    const maxScore = Math.max(...users.map((u) => u.score ?? 0), 1);

    users.forEach((user) => {
        const track = document.createElement("div");
        track.classList.add("race-track");

        // Agregar la línea central amarilla
        const centerLine = document.createElement("div");
        centerLine.classList.add("center-line");
        track.appendChild(centerLine);

        const runner = document.createElement("div");
        runner.classList.add("runner");

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

        runner.appendChild(name);
        runner.appendChild(stats);
        track.appendChild(runner);
        trackContainer.appendChild(track);

        // Posicionar corredor según score
        const progress = (user.score / maxScore) * 90;
        runner.style.left = `${progress}%`;
    });
}
