const fetch = require('node-fetch');

describe('sonderfelder.php', () => {
  test('sollte erreichbar sein und Sonderfeldinfos liefern', async () => {
    const res = await fetch('http://localhost/PartyBrettspiel/PHP/sonderfelder.php');
    expect(res.status).toBe(200);
  });
});
