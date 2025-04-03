const fetch = require("node-fetch");

describe("spieler_api.php", () => {
  test("sollte einen neuen Spieler anlegen", async () => {
    const res = await fetch("http://localhost/PartyBrettspiel/PHP/spieler_api.php", {
      method: "POST",
      body: JSON.stringify({ name: "Testspieler", spiel_id: 1 }),
      headers: { "Content-Type": "application/json" },
    });

    expect(res.status).toBe(200);
    const contentType = res.headers.get("content-type");
    expect(contentType).toMatch(/application\/json/);

    const text = await res.text();
    const data = JSON.parse(text);
    expect(data.success).toBe(true);
    expect(data.spieler.name).toBe("Testspieler");
  });
});
