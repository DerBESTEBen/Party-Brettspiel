document.addEventListener("DOMContentLoaded", function () {
    const startGameBtn = document.getElementById("startGame");
    const popup = document.getElementById("popup");
    const closeBtn = document.querySelector(".close-btn");
    const nextStepBtn = document.getElementById("nextStep");
    const playerCountSelect = document.getElementById("playerCount");
    const popupTitle = document.getElementById("popup-title");
    const stepPlayers = document.getElementById("step-players");
    const stepNames = document.getElementById("step-names");
    const nameInputs = document.getElementById("nameInputs");
    const nameForm = document.getElementById("step-names");

    let playerCount = 2;

    // "Spielen"-Button öffnet das Pop-up (Erster Schritt: Spieleranzahl)
    startGameBtn.addEventListener("click", function (event) {
        event.preventDefault();
        popup.style.display = "flex";
        stepPlayers.style.display = "block";
        stepNames.style.display = "none";
        popupTitle.textContent = "Spieleranzahl wählen";
    });

    // Weiter zur Namenseingabe
    nextStepBtn.addEventListener("click", function () {
        playerCount = parseInt(playerCountSelect.value);
        showNameInputs(playerCount);
        stepPlayers.style.display = "none";
        stepNames.style.display = "block";
        popupTitle.textContent = "Spielernamen eingeben";
    });

    // Spielernamen-Felder generieren
    function showNameInputs(count) {
        nameInputs.innerHTML = ""; // Vorherige Eingaben löschen
        for (let i = 1; i <= count; i++) {
            let input = document.createElement("input");
            input.type = "text";
            input.name = `player${i}`;
            input.placeholder = `Name Spieler ${i}`;
            input.required = true;
            nameInputs.appendChild(input);
        }
    }

    // Spielernamen bestätigen -> Weiterleitung zum Spiel mit Namen
    nameForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let playerData = [];
        let inputs = document.querySelectorAll("#nameInputs input");

        inputs.forEach(input => {
            playerData.push(encodeURIComponent(input.value));
        });

        let queryString = `PHP/spieloberflaeche.php?players=${playerCount}&names=${playerData.join(",")}`;
        window.location.href = queryString;
    });

    // Schließen des Pop-ups
    closeBtn.addEventListener("click", function () {
        popup.style.display = "none";
    });

    // Schließen des Pop-ups beim Klick außerhalb
    window.addEventListener("click", function (event) {
        if (event.target === popup) popup.style.display = "none";
    });
});
