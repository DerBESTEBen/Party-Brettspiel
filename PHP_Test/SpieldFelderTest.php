<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../PHP/spieldfelder.php';

class SpieldFelderTest extends TestCase {
    public function testSpieldfelderArrayExistiert() {
        $this->assertIsArray(SpieldFelder::getAlleFelder());
    }
}
