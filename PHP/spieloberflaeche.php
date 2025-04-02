<?php
include_once 'spieler.php'; // Spieler-Klasse einbinden
include_once 'spiel.php';   // Spiel-Klasse einbinden

// -----------------
// Spielstatus übernehmen
// -----------------
$anzahlSpieler = isset($_GET['players']) ? intval($_GET['players']) : 2;
$spielernamen = isset($_GET['names']) ? explode(',', $_GET['names']) : [];
if (empty($spielernamen)) {
    for ($i = 0; $i < $anzahlSpieler; $i++) {
        $spielernamen[] = "Spieler " . ($i + 1);
    }
}
$runde = isset($_GET['round']) ? intval($_GET['round']) : 1;
$aktuellerSpieler = isset($_GET['current']) ? intval($_GET['current']) : 0;
$positionenParameter = isset($_GET['positions']) ? $_GET['positions'] : '';
if ($positionenParameter !== '') {
    $positionen = explode(',', $positionenParameter);
} else {
    $positionen = array_fill(0, $anzahlSpieler, 0);
}

// -----------------------
// Festgelegte Zellengröße (unabhängig von der Spieleranzahl)
// -----------------------
$zellenGroesse = 120; // Zellen sind konstant 120px groß

// -----------------------
// Spielfeld-Definition
$spielfeldLaenge = 30; // Gesamtzahl der Felder
$spalten = 5;          // Anzahl der Spalten
// Erweiterte Farbliste für die Spielsteine (nach Index des Spielers)
$farben = [
    "red", "blue", "green", "orange", "purple", "cyan", "magenta",
    "yellow", "pink", "brown", "lime", "turquoise", "violet", "indigo",
    "gold", "silver", "coral", "teal", "navy", "maroon"
];

// -----------------------
// Spiel-Objekt erstellen und Zustand setzen
$spiel = new Spiel($spielernamen);
foreach ($spiel->spieler as $i => $spielerObj) {
    $spiel->spieler[$i]->spielerPosition = isset($positionen[$i]) ? intval($positionen[$i]) : 0;
}

// -----------------------
// Aktionsverarbeitung: Würfelknopf wurde gedrückt
$aktionsAusgabe = '';
if (isset($_GET['roll'])) {
    ob_start();
    $spiel->zug_starten($aktuellerSpieler);
    $aktionsAusgabe = ob_get_clean();

    // Nach dem Zug des letzten Spielers wird die Runde erhöht
    if ($aktuellerSpieler >= $anzahlSpieler - 1) {
        $runde++;
        $aktuellerSpieler = 0;
    } else {
        $aktuellerSpieler++;
    }
}

// -----------------------
// Aktualisiere die Positionen für das Formular
$neuePositionen = [];
foreach ($spiel->spieler as $spielerObj) {
    $neuePositionen[] = $spielerObj->spielerPosition;
}
$positionenString = implode(',', $neuePositionen);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spielbrett</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>

    </style>
</head>
<body>
    <a href="../index.php" class="btn" id="zurück">Zurück zum Hauptmenü</a>
    
    <h1></h1>
    <p>Aktuelle Runde: <?= $runde ?></p>
    <p>Aktueller Zug: <?= $spielernamen[$aktuellerSpieler] ?></p>
    
    <!-- Debug: Ausgabe des letzten Zuges -->
    <?php /* if (isset($_GET['roll'])): ?>
        <div class="zug-info">
            <?= $aktionsAusgabe ?>
        </div>
    <?php endif; */ ?>

    <!-- Anzeige des Spielfelds als Grid -->
    <div class="board-container">
        <?php
        for ($feld = 0; $feld < $spielfeldLaenge; $feld++) {
            echo '<div class="cell">';
            echo '<span class="cell-number">' . $feld . '</span>';
            $tokens = [];
            foreach ($spiel->spieler as $index => $spieler) {
                if ($spieler->spielerPosition == $feld) {
                    $tokens[] = ['index' => $index, 'name' => $spieler->name];
                }
            }
            if (!empty($tokens)) {
                echo '<div class="game-piece-container">';
                foreach ($tokens as $token) {
                    $farbe = $farben[$token['index'] % count($farben)];
                    echo '<div class="game-piece" style="background-color:' . $farbe . ';" title="' . $token['name'] . '"></div>';
                }
                echo '</div>';
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Rangliste anzeigen -->
    <?php
    // Erstelle eine Kopie des Spieler-Arrays und sortiere nach Position (absteigend)
    $spielerArray = $spiel->spieler;
    usort($spielerArray, function($a, $b) {
        return $b->spielerPosition - $a->spielerPosition;
    });
    ?>
    <div class="ranking-list">
        <h2>Rangliste</h2>
        <ul>
        <?php
        $rank = 1;
        foreach ($spielerArray as $spieler) {
            // Die Farbe eines Spielers basiert auf seinem Originalindex (spielerId)
            $farbe = $farben[$spieler->spielerId % count($farben)];
            echo '<li>';
            echo '<div class="ranking-color" style="background-color:' . $farbe . ';"></div>';
            echo $rank . '. ' . $spieler->name . ' (Pos: ' . $spieler->spielerPosition . ')';
            echo '</li>';
            $rank++;
        }
        ?>
        </ul>
    </div>

    <!-- Formular für den nächsten Zug (nur EIN Würfelknopf) -->
    <form method="get" action="">
        <input type="hidden" name="players" value="<?= htmlspecialchars($anzahlSpieler) ?>">
        <input type="hidden" name="names" value="<?= htmlspecialchars(implode(',', $spielernamen)) ?>">
        <input type="hidden" name="round" value="<?= $runde ?>">
        <input type="hidden" name="current" value="<?= $aktuellerSpieler ?>">
        <input type="hidden" name="positions" value="<?= htmlspecialchars($positionenString) ?>">
        <button type="submit" name="roll" value="1">Würfeln (<?= $spielernamen[$aktuellerSpieler] ?>)</button>
    </form>
</body>
</html>
