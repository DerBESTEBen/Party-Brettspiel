document.addEventListener("DOMContentLoaded", function () {
    const aufgabenPopup = document.getElementById("aufgabenPopup");
    const aufgabenText = document.getElementById("aufgabenText");
    const jaBtn = document.getElementById("aufgabeJa");
    const neinBtn = document.getElementById("aufgabeNein");

    // Globale Funktion, damit PHP sie aufrufen kann
    window.zeigeAufgabe = function (text) {
        aufgabenText.innerHTML = text;
        aufgabenPopup.style.display = "flex";
    };

    // Ja / Nein Buttons
    jaBtn.addEventListener("click", function () {
        aufgabenPopup.style.display = "none";
        console.log("JA gedrückt");
        // TODO: Handlung bei Ja
    });

    neinBtn.addEventListener("click", function () {
        aufgabenPopup.style.display = "none";
        console.log("NEIN gedrückt");
        // TODO: Handlung bei Nein
    });

    const inlineTextElement = document.getElementById("aufgabenInlineText");
    if (inlineTextElement) {
        zeigeAufgabe(inlineTextElement.innerHTML);
    }

});