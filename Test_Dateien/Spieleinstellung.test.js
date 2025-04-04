const fs = require("fs");
const path = require("path");

describe("Spieleinstellung.js", () => {
  beforeAll(() => {
    document.body.innerHTML = `
      <button id="startGame"></button>
      <div id="popup" style="display:none;"></div>
      <button id="nextStep"></button>
      <div id="step1"></div>
      <div id="step2"></div>
      <div id="step3"></div>
      <input id="playerCount" />
    `;

    const code = fs.readFileSync(path.resolve(__dirname, "../assets/js/Spieleinstellung.js"), "utf8");
    const script = document.createElement("script");
    script.textContent = code;
    document.head.appendChild(script);
  });

  test("Popup ist initial versteckt", () => {
    expect(document.getElementById("popup").style.display).toBe("none");
  });
});