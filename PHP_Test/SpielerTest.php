<?php
use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../PHP/spieler.php';

class SpielerTest extends TestCase {
    public function testInitialisierung() {
        $spieler = new Spieler("Max", 1);
        $this->assertEquals("Max", $spieler->name);
        $this->assertEquals(1, $spieler->spielerId);
        $this->assertEquals(0, $spieler->spielerPosition);
        $this->assertTrue($spieler->status);
    }

    public function testPositionAktualisieren() {
        $spieler = new Spieler("Max", 1);
        $spieler->position_aktualisieren(3);
        $this->assertEquals(3, $spieler->spielerPosition);
    }
}