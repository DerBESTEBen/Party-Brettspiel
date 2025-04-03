const fetch = require('node-fetch');

describe('spielanleitung.php', () => {
  test('sollte die Spielanleitung anzeigen', async () => {
    const res = await fetch('http://localhost/PartyBrettspiel/PHP/spielanleitung.php');
    expect(res.status).toBe(200);
    const contentType = res.headers.get('content-type');
    expect(contentType).toMatch(/text\/html/);
  });
});
