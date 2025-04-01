<?php
include_once 'spieler.php'; // Spieler-Klasse einbinden

class Spiel {
    public int $rundenCounter;
    /** @var Spieler[] */
    public array $spieler;
    private int $wurf;
    private bool $spielLaeuft;

    /**
     * Konstruktor: Erzeugt ein Spiel mit einem Array von Spielernamen.
     * Jeder Spieler erhält eine eindeutige Spieler-ID (entsprechend dem Array-Index).
     *
     * @param array $spielerNamen Array mit Spielernamen
     */
    public function __construct(array $spielerNamen) {
        $this->rundenCounter = 0;
        $this->wurf = 0;
        $this->spielLaeuft = true;
        $this->spieler = [];

        foreach ($spielerNamen as $index => $name) {
            $this->spieler[] = new Spieler($name, $index);
        }
    }

    /**
     * Initialisiert eine neue Runde, indem der Rundenzähler hochgezählt wird.
     */
    public function runden_initialisieren(): void {
        $this->rundenCounter++;
        $this->wurf = 0;
        echo "<h2>Runde {$this->rundenCounter}</h2>";
    }

    /**
     * Führt den Zug für einen bestimmten Spieler aus.
     * Dabei wird geprüft, ob der Spieler ziehen darf (Status aus Spieler.php).
     *
     * @param int $spielerId Index des Spielers im Array (0-basiert)
     */
    public function zug_starten(int $spielerId): void {
        if (!$this->spielLaeuft) {
            echo "<p>Das Spiel ist bereits beendet.</p>";
            return;
        }
        if (!$this->spieler_status_pruefen($spielerId)) {
            echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> darf nicht ziehen.</p>";
            return;
        }
        // Würfeln
        $this->wurf = $this->wuerfeln();
        echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> würfelt: {$this->wurf}</p>";

        // Spieler bewegen – Aufruf der Methode position_aktualisieren aus Spieler.php
        $this->spieler[$spielerId]->position_aktualisieren($this->spieler[$spielerId]->spielerPosition, $this->wurf);
        echo "<p>Neue Position von <strong>{$this->spieler[$spielerId]->name}</strong>: {$this->spieler[$spielerId]->spielerPosition}</p>";

        // Feld auswerten (Platzhalter für erweiterte Logik)
        $this->feld_auswerten($spielerId, $this->spieler[$spielerId]->spielerPosition);

        // Siegbedingung: Erreicht ein Spieler Position 20 oder mehr, gewinnt er
        if ($this->spieler[$spielerId]->spielerPosition >= 20) {
            echo "<p>Spieler <strong>{$this->spieler[$spielerId]->name}</strong> hat gewonnen!</p>";
            $this->spiel_beenden();
        }
    }

    /**
     * Prüft, ob der Spieler ziehen darf, basierend auf seinem Status.
     *
     * @param int $spielerId
     * @return bool true, wenn der Spieler aktiv ist
     */
    public function spieler_status_pruefen(int $spielerId): bool {
        return $this->spieler[$spielerId]->status;
    }

    /**
     * Simuliert einen Würfelwurf (Zahl zwischen 1 und 6).
     *
     * @return int Gewürfelte Zahl
     */
    public function wuerfeln(): int {
        return rand(1, 6);
    }

    /**
     * Wertet das Feld aus, auf dem der Spieler gelandet ist.
     * (Erweiterbar um spezielle Logik.)
     *
     * @param int $spielerId
     * @param int $spielerposition
     */
    public function feld_auswerten(int $spielerId, int $spielerposition): void {
        echo "<p>Feld {$spielerposition} wird für Spieler <strong>{$this->spieler[$spielerId]->name}</strong> ausgewertet.</p>";
    }

    /**
     * Beendet das Spiel.
     */
    public function spiel_beenden(): void {
        $this->spielLaeuft = false;
        echo "<p>Das Spiel ist beendet!</p>";
    }

    /**
     * Gibt den aktuellen Spielstand aus.
     */
    public function counter(): void {
        echo "<p>Aktuelle Runde: <strong>{$this->rundenCounter}</strong></p>";
        foreach ($this->spieler as $spieler) {
            echo "<p>Spieler <strong>{$spieler->name}</strong>: Position <strong>{$spieler->spielerPosition}</strong></p>";
        }
    }
}
?>
