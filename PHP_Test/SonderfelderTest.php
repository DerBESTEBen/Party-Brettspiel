<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../PHP/sonderfelder.php';

class SonderfelderTest extends TestCase {
    public function testSonderfelderArrayExistiert() {
        $this->assertIsArray(Sonderfeld::getAlle());
    }
}
