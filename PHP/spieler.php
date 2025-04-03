<?php
class Spieler {
    public string $name;
    public int $spielerPosition;
    public bool $istFertig;
    public int $spielerId;
    public bool $status;

    public function __construct(string $name, int $spielerId) {
        $this->name = $name;
        $this->spielerPosition = 0;
        $this->status = true;
        $this->spielerId = $spielerId;
        $this->istFertig = false;
    }

    public function position_aktualisieren(int $felder): void {
        $this->spielerPosition += $felder;
    }

    public function getInfo(): array {
        return [
            'name' => $this->name,
            'position' => $this->spielerPosition,
            'status' => $this->status,
            'id' => $this->spielerId,
            'fertig' => $this->istFertig
        ];
    }
}
