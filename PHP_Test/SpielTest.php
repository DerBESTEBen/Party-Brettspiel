<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../PHP/spiel.php';

class SpielTest extends TestCase {
    public function testSpielerAnzahl() {
        $spiel = new Spiel(2, ["Anna", "Ben"]);
        $this->assertCount(2, $spiel->spieler);
    }
}
