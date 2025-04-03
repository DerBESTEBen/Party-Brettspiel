<?php
use PHPUnit\Framework\TestCase;

class SonderfelderTest extends TestCase {
    public function testSonderfelderArrayExistiert() {
        $sonderfelder = require __DIR__ . '/../PHP/sonderfelder.php';
        $this->assertIsArray($sonderfelder);
        $this->assertNotEmpty($sonderfelder);
    }
}
