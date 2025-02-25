document.addEventListener("DOMContentLoaded", function () {
    const startGameBtn = document.getElementById("startGame");
    const popupPlayers = document.getElementById("popup-players");
    const popupNames = document.getElementById("popup-names");
    const confirmPlayersBtn = document.getElementById("confirmPlayers");
    const nameForm = document.getElementById("nameForm");
    const nameInputs = document.getElementById("nameInputs");
    const closeBtns = document.querySelectorAll(".close-btn");

    let playerCount = 1;

    // "Spielen"-Button öffnet das erste Pop-up (Spieleranzahl wählen)
    startGameBtn.addEventListener("click", function (event) {
        event.preventDefault();
        popupPlayers.style.display = "flex";
    });

    // Spieleranzahl bestätigen -> öffnet Namenseingabe
    confirmPlayersBtn.addEventListener("click", function () {
        playerCount = document.getElementById("playerCount").value;
        popupPlayers.style.display = "none";
        showNameInputs(playerCount);
        popupNames.style.display = "flex";
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

    // Schließen der Pop-ups
    closeBtns.forEach(btn => {
        btn.addEventListener("click", function () {
            popupPlayers.style.display = "none";
            popupNames.style.display = "none";
        });
    });

    // Schließen des Pop-ups beim Klick außerhalb
    window.addEventListener("click", function (event) {
        if (event.target === popupPlayers) popupPlayers.style.display = "none";
        if (event.target === popupNames) popupNames.style.display = "none";
    });
});
