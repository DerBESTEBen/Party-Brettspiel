/**
 * @jest-environment jsdom
 */
const { showNameInputs } = require("../assets/js/Spieleinstellung");

describe("Spieleinstellung.js – Nameingabe", () => {
  test("erstellt die richtige Anzahl an Namensfeldern", () => {
    document.body.innerHTML = '<div id="nameInputs"></div>';
    const nameInputs = document.getElementById("nameInputs");

    showNameInputs(3, nameInputs);
    const inputs = nameInputs.querySelectorAll("input");

    expect(inputs.length).toBe(3);
    expect(inputs[0].placeholder).toBe("Name Spieler 1");
    expect(inputs[1].value).toBe("Spieler 2");
  });
});
