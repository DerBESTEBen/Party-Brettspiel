
<?php
use PHPUnit\Framework\TestCase;

class SpielerApiTest extends TestCase {
    public function testRequestOhneDaten() {
        $this->expectOutputRegex('/"success":false/');
        $_POST = [];
        include __DIR__ . '/../spieler_api.php';
    }
}
