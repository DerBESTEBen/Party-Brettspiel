/**
 * @jest-environment jsdom
 */
const { setupMenuHover } = require("../assets/js/script");

describe("script.js – Hover-Menü", () => {
  test("ändert Farbe beim Hover", () => {
    document.body.innerHTML = '<ul class="menu-list"><li><a href="#">Test</a></li></ul>';
    const link = document.querySelector("a");

    setupMenuHover();

    const mouseOverEvent = new Event("mouseover");
    link.dispatchEvent(mouseOverEvent);
    expect(link.style.color).toBe("blue");

    const mouseOutEvent = new Event("mouseout");
    link.dispatchEvent(mouseOutEvent);
    expect(link.style.color).toBe("black");
  });
});
