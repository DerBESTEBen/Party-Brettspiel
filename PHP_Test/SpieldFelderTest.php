<?php
use PHPUnit\Framework\TestCase;

class SpieldFelderTest extends TestCase {
    public function testSpieldfelderArrayExistiert() {
        $spielfelder = require __DIR__ . '/../PHP/spieldfelder.php';
        $this->assertIsArray($spielfelder);
        $this->assertNotEmpty($spielfelder);
    }
}
