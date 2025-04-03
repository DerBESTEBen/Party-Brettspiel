const fetch = require('node-fetch');

describe('spiel.php', () => {
  test('sollte initiale Spieldaten liefern', async () => {
    const res = await fetch('http://localhost/PartyBrettspiel/PHP/spiel.php');
    expect(res.status).toBe(200);
  });
});
