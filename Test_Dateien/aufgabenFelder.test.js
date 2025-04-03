const fetch = require('node-fetch');

describe('aufgabenFelder.php', () => {
  test('sollte erreichbar sein und HTML oder JSON liefern', async () => {
    const res = await fetch('http://localhost/PartyBrettspiel/PHP/aufgabenFelder.php');
    expect(res.status).toBe(200);
    const contentType = res.headers.get('content-type');
    expect(contentType).toMatch(/(text\/html|application\/json)/);
  });
});
