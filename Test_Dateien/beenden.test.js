const fetch = require("node-fetch");

describe("beenden.php", () => {
  test("sollte HTML anzeigen und kein Fehler liefern", async () => {
    const res = await fetch("http://localhost/PartyBrettspiel/PHP/beenden.php");

    expect(res.status).toBe(200);
    const contentType = res.headers.get("content-type");
    expect(contentType).toMatch(/text\/html/);

    const text = await res.text();
    expect(text).toContain("Zurück zum Hauptmenü");
  });
});
