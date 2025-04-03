function zeigeAufgabe(text, aufgabenText, aufgabenPopup) {
    aufgabenText.innerHTML = text;
    aufgabenPopup.style.display = "flex";
}

function hidePopup(popup) {
    popup.style.display = "none";
}

module.exports = {
    zeigeAufgabe,
    hidePopup
};
