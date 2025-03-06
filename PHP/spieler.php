<?php
class Spieler {
    public string $name;
    public int $position;
    public bool $status;
    public int $spieleId;
    public bool $istFertig;

    // Konstruktor zum Erstellen eines Spielers
    public function __construct(string $name, int $spieleId) {
        $this->name = $name;
        $this->position = 0;   // Startposition
        $this->status = true;  // Aktiv
        $this->spieleId = $spieleId;
        $this->istFertig = false;
    }

    // Funktion zum Anzeigen der Spieler-Daten (Debugging)
    public function getInfo() {
        return "Name: {$this->name}, Position: {$this->position}, Status: " . 
               ($this->status ? "Aktiv" : "Inaktiv") . 
               ", Spiele-ID: {$this->spieleId}, Ist Fertig: " . 
               ($this->istFertig ? "Ja" : "Nein");
    }
}
?>
