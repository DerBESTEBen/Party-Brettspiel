<?php
include_once 'spieler.php';
include_once 'spieldfelder.php';
include_once 'sonderfelder.php';
include_once 'aufgabenFelder.php';

class Spiel {
    public int $rundenCounter;
    /** @var Spieler[] */
    public array $spieler;
    private int $wurf;
    private bool $spielLaeuft;

    public function __construct(array $spielerNamen) {
        $this->rundenCounter = 0;
        $this->wurf = 0;
        $this->spielLaeuft = true;
        $this->spieler = [];

        foreach ($spielerNamen as $index => $name) {
            $this->spieler[] = new Spieler($name, $index);
        }
        $this->spielfelder = new Spielfelder();
        $this->spielfelder->felder_initialisieren();
    }


    public function runden_initialisieren(): void {
        $this->rundenCounter++; //Counter zählt hoch für jede Runde
        $this->wurf = 0;
        echo "<h2>Runde {$this->rundenCounter}</h2>";
    }

    public function zug_starten(int $spielerId): void {
        if (!$this->spielLaeuft) {
            echo "<p>Das Spiel ist bereits beendet.</p>";
            return;
        }

        // Prüfe anhand der Eigenschaft 'status', ob der Spieler ziehen darf
        if (!$this->spieler_status_pruefen($spielerId)) {
            echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> darf nicht ziehen.</p>";
            // Jetzt wieder aktiv für nächste Runde
            // $this->spieler[$spielerId]->status = true;
            return;
        }
        else{
            // Würfeln
            $this->wurf = $this->wuerfeln();
            echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> würfelt: {$this->wurf}</p>";

            // Spieler bewegen
            $this->spieler[$spielerId]->position_aktualisieren($this->wurf);
            echo "<p>Neue Position von <strong>{$this->spieler[$spielerId]->name}</strong>: {$this->spieler[$spielerId]->spielerPosition}</p>";

            // Feldlogik
            $this->feld_auswerten($spielerId, $this->spieler[$spielerId]->spielerPosition);

            // Siegbedingung
            if ($this->spieler[$spielerId]->spielerPosition >= 20) {
                echo "<p>Spieler <strong>{$this->spieler[$spielerId]->name}</strong> hat gewonnen!</p>";
                $this->spiel_beenden();
            }
        }
    }

    /**
     * true, wenn der Spieler aktiv ist (ziehen darf)
     */
    public function spieler_status_pruefen(int $spielerId): bool {
        return $this->spieler[$spielerId]->status;
    }

    /**
     * Simuliert einen Würfelwurf (Zahl zwischen 1 und 6).
     */
    public function wuerfeln(): int {
        return rand(1, 6);
    }

    /**
     * Wertet das Feld aus, auf dem der Spieler gelandet ist.
     * (Erweiterbar um spezielle Logik.)
     */
    public function feld_auswerten(int $spielerId, int $spielerposition): void {
        $typ = $this->spielfelder->getFeldTyp($spielerposition);
        $feld = $this->spielfelder->getFeldObjekt($spielerposition);

        echo "<p>Feld {$spielerposition} analysiert (Typ: {$typ})</p>";

        if ($typ === "sonder" && $feld instanceof Sonderfeld) {
            switch ($feld->aktion) {
                case "aussetzen":
                    $this->spieler[$spielerId]->status = false;
                    echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> muss eine Runde aussetzen!</p>";
                    break;
                case "zurück":
                    $this->spieler[$spielerId]->spielerPosition = max(0, $this->spieler[$spielerId]->spielerPosition - 2);
                    echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> geht zwei Felder zurück.</p>";
                    break;
                case "spiel_beenden":
                    $this->spiel_beenden();
                    break;
                default:
                    echo "<p>Unbekannte Aktion auf Sonderfeld.</p>";
                    break;
            }
        }

        if ($typ === "aufgabe" && $feld instanceof Aufgabenfeld) {
            echo "<p>Aufgabe für <strong>{$this->spieler[$spielerId]->name}</strong>: {$feld->beschreibung}</p>";
        }

        if ($typ === "normal") {
            echo "<p>Normales Feld – nichts passiert.</p>";
        }
    /**  Beispiel: Spieler muss auf Feld 7 eine Runde aussetzen
        *if ($spielerposition === 7 || $spielerposition === 10 || $spielerposition === 3 || $spielerposition === 5 || $spielerposition === 9) {
        *    $this->spieler[$spielerId]->status = false;
        *    echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> muss eine Runde aussetzen!</p>";
        *}
    *if ($feldTyp === "sonderfeld") {
    *    $sonder = new Sonderfelder($spielerposition, "zurück");
    *    $sonder->aktion_ausführen($this->spieler[$spielerId]);
    *}

    *if ($feldTyp === "aufgabe") {
    *    $aufgabe = new Aufgaben($spielerposition, "Löse die Frage: Was ist 2 + 2?");
    *    echo "<p>Aufgabe für {$this->spieler[$spielerId]->name}: {$aufgabe->beschreibung}</p>";
    *    // Aufgabenbearbeitung z. B. über Eingabe/Bestätigung
    *}
    */
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
