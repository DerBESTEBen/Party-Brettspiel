/**
 * @jest-environment jsdom
 */

// Fix für ältere Node-Versionen
global.TextEncoder = require("util").TextEncoder;
global.TextDecoder = require("util").TextDecoder;

const fs = require("fs");
const path = require("path");
const { JSDOM } = require("jsdom");

describe("HTML-Spielmenü Tests", () => {
    let dom;
    let document;

    beforeAll(() => {
        // Lade das HTML in die Testumgebung
        const html = fs.readFileSync(path.resolve(__dirname, "../index.php"), "utf8");
        dom = new JSDOM(html);
        document = dom.window.document;
    });

    test("Sollte den Titel 'Spielmenü' enthalten", () => {
        const title = document.querySelector("h1").textContent;
        expect(title).toBe("Spielmenü");
    });

    test("Sollte die Menü-Links enthalten", () => {
        const menuLinks = document.querySelectorAll(".menu-list li a");
        expect(menuLinks.length).toBe(3); // Prüft, ob drei Links vorhanden sind
        expect(menuLinks[0].textContent).toBe("Spielen");
        expect(menuLinks[1].textContent).toBe("Spielanleitung");
        expect(menuLinks[2].textContent).toBe("Beenden");
    });

    test("Sollte das Pop-up für die Spielerauswahl enthalten", () => {
        const popup = document.getElementById("popup");
        expect(popup).not.toBeNull();
    });

    test("Sollte eine Spieleranzahl-Auswahl (Dropdown) enthalten", () => {
        const playerCountDropdown = document.getElementById("playerCount");
        expect(playerCountDropdown).not.toBeNull();
        expect(playerCountDropdown.tagName).toBe("SELECT");
    });

    /**
     * test("Sollte mindestens 2 und maximal 10 Spieler erlauben", () => {
        const options = [...document.getElementById("playerCount").options]
            .map(opt => parseInt(opt.value, 10))
            .filter(num => !isNaN(num)); // Entfernt ungültige Werte
        expect(options).toEqual([2, 3, 4, 5, 6, 7, 8, 9, 10]);
    });
    */

    test("Sollte einen Weiter-Button für die Spielerauswahl haben", () => {
        const nextButton = document.getElementById("nextStep");
        expect(nextButton).not.toBeNull();
        expect(nextButton.textContent).toBe("Weiter");
    });

    test("Sollte das Formular für Spielernamen versteckt sein", () => {
        const nameForm = document.getElementById("step-names");
        expect(nameForm.style.display).toBe("none");
    });
});
