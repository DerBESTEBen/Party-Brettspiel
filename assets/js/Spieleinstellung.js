function showNameInputs(count, nameInputsElement) {
    nameInputsElement.innerHTML = '';
    for (let i = 1; i <= count; i++) {
        let input = document.createElement("input");
        input.type = "text";
        input.name = `player${i}`;
        input.placeholder = `Name Spieler ${i}`;

        if (input.value.trim() === "") {
            input.value = `Spieler ${i}`;
        }

        input.addEventListener("focus", function () {
            if (input.value === `Spieler ${i}`) {
                input.value = "";
            }
        });

        input.addEventListener("blur", function () {
            if (input.value.trim() === "") {
                input.value = `Spieler ${i}`;
            }
        });

        nameInputsElement.appendChild(input);
    }
}

module.exports = { showNameInputs };
