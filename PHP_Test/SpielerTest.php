<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../PHP/spieler.php';

class SpielerTest extends TestCase {
    public function testInitialisierung() {
        $spieler = new Spieler("Max", "rot");
        $this->assertEquals("Max", $spieler->name);
        $this->assertEquals("rot", $spieler->farbe);
        $this->assertEquals(0, $spieler->position);
    }
}
