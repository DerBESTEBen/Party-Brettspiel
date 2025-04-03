<?php
class Spieler {
    public string $name;
    public int $spielerPosition;
    public bool $istFertig;
    public int $spielerId;
    public bool $status;


    // Konstruktor zum Erstellen eines Spielers
    public function __construct(string $name, int $spielerId) {
        $this->name = $name;
        $this->spielerPosition = 0;
        $this->status = true;  // Aktiv
        $this->spielerId = $spielerId;
        $this->istFertig = false;
    }

    public function position_aktualisieren(int $felder): void {
        $this->spielerPosition += $felder;
    }
    
    //(Debugging)
    public function getInfo() {
        return "Name: {$this->name}, Position: {$this->spielerPosition}, Status: " .
               ($this->status ? "Aktiv" : "Inaktiv") .
               ", Spiele-ID: {$this->spielerId}, Ist Fertig: " .
               ($this->istFertig ? "Ja" : "Nein");
    }
}
?>