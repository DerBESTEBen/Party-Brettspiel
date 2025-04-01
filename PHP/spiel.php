<?php
// spiel.php

// Spieler-Klasse einbinden (diese Datei enthält auch die Methode position_aktualisieren() – bitte ggf. den Fehler in der Methode beheben)
require_once 'spieler.php';

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
        $this->spieler[$spielerId]->status = true;
        return;
        }   

        // Würfeln
        $this->wurf = $this->wuerfeln();
        echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> würfelt: {$this->wurf}</p>";

        // Spieler bewegen – Aufruf der Methode position_aktualisieren aus Spieler.php
        $this->spieler[$spielerId]->position_aktualisieren($this->wurf);
        echo "<p>Neue Position von <strong>{$this->spieler[$spielerId]->name}</strong>: {$this->spieler[$spielerId]->spielerPosition}</p>";

        // Platzhalter für Feld-Auswertung
        $this->feld_auswerten($spielerId, $this->spieler[$spielerId]->spielerPosition);

        // Beispielhafte Siegbedingung: Erreicht ein Spieler Position 20 oder mehr, gewinnt er
        if ($this->spieler[$spielerId]->spielerPosition >= 20) {
            echo "<p>Spieler <strong>{$this->spieler[$spielerId]->name}</strong> hat gewonnen!</p>";
            $this->spiel_beenden();
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
        echo "<p>Feld {$spielerposition} wird für Spieler <strong>{$this->spieler[$spielerId]->name}</strong> ausgewertet.</p>";
        // Beispiel: Spieler muss auf Feld 7 eine Runde aussetzen
        if ($spielerposition === 7 || $spielerposition === 10 || $spielerposition === 3 || $spielerposition === 5 || $spielerposition === 9) {
            $this->spieler[$spielerId]->status = false;
            echo "<p><strong>{$this->spieler[$spielerId]->name}</strong> muss eine Runde aussetzen!</p>";
        }
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


// --- Interaktive Spieloberfläche ---

// Wir nutzen GET-Parameter, um den Spielstatus zwischen den Zügen zu übermitteln.
// Erwartete Parameter: players, names, round, current, positions
$playerCount = isset($_GET['players']) ? intval($_GET['players']) : 2;
$names = isset($_GET['names']) ? explode(',', $_GET['names']) : [];
if(empty($names)) {
    // Standardnamen, falls keine übergeben wurden
    $names = [];
    for ($i = 0; $i < $playerCount; $i++) {
        $names[] = "Spieler " . ($i + 1);
    }
}
$round = isset($_GET['round']) ? intval($_GET['round']) : 1;
$currentPlayer = isset($_GET['current']) ? intval($_GET['current']) : 0;
$positionsParam = isset($_GET['positions']) ? $_GET['positions'] : '';
if ($positionsParam !== '') {
    $positions = explode(',', $positionsParam);
} else {
    // Initialisiere Positionen aller Spieler mit 0
    $positions = array_fill(0, $playerCount, 0);
}

// Erstelle ein Spiel-Objekt und setze den Zustand der Spieler entsprechend.
$spiel = new Spiel($names);
foreach ($spiel->spieler as $i => $spielerObj) {
    $spiel->spieler[$i]->spielerPosition = isset($positions[$i]) ? intval($positions[$i]) : 0;
}

// Wird der "Würfeln"-Knopf gedrückt, soll der aktuelle Spieler seinen Zug machen.
$actionOutput = '';
if (isset($_GET['roll'])) {
    // Falls gerade ein Zug erfolgt, rufen wir die Zug-Methode des aktuellen Spielers auf.
    ob_start();
    $spiel->zug_starten($currentPlayer);
    $actionOutput = ob_get_clean();

    // Aktualisiere den Zustand: 
    // Nach dem Zug des letzten Spielers wird der Rundenzähler (außerhalb der Zug-Methode) hochgesetzt.
    if ($currentPlayer >= $playerCount - 1) {
        $round++;
        $currentPlayer = 0;
    } else {
        $currentPlayer++;
    }
}

// Aktualisiere die Positionen für die Übertragung im Formular.
$newPositions = [];
foreach ($spiel->spieler as $spielerObj) {
    $newPositions[] = $spielerObj->spielerPosition;
}
$positionsString = implode(',', $newPositions);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spiel - Rundenlogik</title>
</head>
<body>
    <h1>Spiel: Rundenlogik</h1>
    <p>Aktuelle Runde: <?= $round ?></p>
    <p>Aktueller Zug: <?= $names[$currentPlayer] ?></p>
    
    <!-- Anzeige des letzten Zuges (falls erfolgt) -->
    <?php if (isset($_GET['roll'])): ?>
        <?= $actionOutput ?>
    <?php endif; ?>

    <h2>Spielstand:</h2>
    <ul>
        <?php foreach ($spiel->spieler as $spieler): ?>
            <li><?= $spieler->name ?> – Position: <?= $spieler->spielerPosition ?></li>
        <?php endforeach; ?>
    </ul>

    <!-- Formular für den nächsten Zug -->
    <form method="get" action="">
        <!-- Übergebe alle notwendigen Spielzustandswerte als versteckte Felder -->
        <input type="hidden" name="players" value="<?= htmlspecialchars($playerCount) ?>">
        <input type="hidden" name="names" value="<?= htmlspecialchars(implode(',', $names)) ?>">
        <input type="hidden" name="round" value="<?= $round ?>">
        <input type="hidden" name="current" value="<?= $currentPlayer ?>">
        <input type="hidden" name="positions" value="<?= htmlspecialchars($positionsString) ?>">
        <button type="submit" name="roll" value="1">Würfeln (<?= $names[$currentPlayer] ?>)</button>
    </form>
</body>
</html>
