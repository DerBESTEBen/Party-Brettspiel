/**
 * @jest-environment jsdom
 */
const { zeigeAufgabe, hidePopup } = require("../assets/js/spieloberflaeche");

describe("spieloberflaeche Funktionen", () => {
  test("zeigeAufgabe zeigt das Popup", () => {
    document.body.innerHTML = '<div id="aufgabenPopup" style="display:none"></div><div id="aufgabenText"></div>';
    const popup = document.getElementById("aufgabenPopup");
    const text = document.getElementById("aufgabenText");
    zeigeAufgabe("TEST", text, popup);
    expect(popup.style.display).toBe("flex");
    expect(text.innerHTML).toBe("TEST");
  });

  test("hidePopup versteckt das Popup", () => {
    document.body.innerHTML = '<div id="popup" style="display:flex"></div>';
    const popup = document.getElementById("popup");
    hidePopup(popup);
    expect(popup.style.display).toBe("none");
  });
});
