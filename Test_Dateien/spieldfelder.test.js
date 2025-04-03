const fetch = require('node-fetch');

describe('spieldfelder.php', () => {
  test('sollte das Spielfeld definieren oder rendern', async () => {
    const res = await fetch('http://localhost/PartyBrettspiel/PHP/spieldfelder.php');
    expect(res.status).toBe(200);
  });
});
