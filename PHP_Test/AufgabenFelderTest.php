<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../PHP/aufgabenFelder.php';

class AufgabenFelderTest extends TestCase {
    public function testAufgabenArrayExistiert() {
        $this->assertIsArray(Aufgabenfeld::getAlleAufgaben());
    }
}
