<?php
use PHPUnit\Framework\TestCase;

class AufgabenFelderTest extends TestCase {
    public function testAufgabenArrayExistiert() {
        $aufgaben = require __DIR__ . '/../PHP/aufgabenFelder.php';
        $this->assertIsArray($aufgaben);
        $this->assertNotEmpty($aufgaben);
    }
}
