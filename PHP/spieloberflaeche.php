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
// Größe der Spielfelder festlegen
// Basiswert 50px, plus 10px pro Spieler
$zellenGroesse = 50 + ($anzahlSpieler * 10);

// -----------------------
// Spielfeld-Definition
$spielfeldLaenge = 30; // Gesamtzahl der Felder
$spalten = 5;          // Anzahl der Spalten
// Farbliste für die Spielsteine (nach Index des Spielers)
$farben = ["red", "blue", "green", "orange", "purple", "cyan", "magenta"];

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
</head>
<body>
    <a href="../index.php" class="btn" id="zurück">Zurück zum Hauptmenü</a>
    
    <h1>Spielbrett</h1>
    <p>Aktuelle Runde: <?= $runde ?></p>
    <p>Aktueller Zug: <?= $spielernamen[$aktuellerSpieler] ?></p>
    
    <!-- Ausgabe des letzten Zuges -->
    <?php if (isset($_GET['roll'])): ?>
        <div class="zug-info">
            <?= $aktionsAusgabe ?>
        </div>
    <?php endif; ?>

    <!-- Anzeige des Spielfelds als Grid -->
    <div class="board-container" style="
         --cell-size: <?= $zellenGroesse ?>px;
         --columns: <?= $spalten ?>;
         width: calc(var(--cell-size) * var(--columns) + (var(--columns) - 1) * 5px);
         ">
        <?php
        for ($feld = 0; $feld < $spielfeldLaenge; $feld++) {
            echo '<div class="cell">';
            echo '<span class="cell-number">' . $feld . '</span>';
            foreach ($spiel->spieler as $index => $spieler) {
                if ($spieler->spielerPosition == $feld) {
                    $farbe = $farben[$index % count($farben)];
                    echo '<div class="game-piece" style="background-color:' . $farbe . ';" title="' . $spieler->name . '"></div>';
                }
            }
            echo '</div>';
        }
        ?>
    </div>

    <!-- Anzeige des Spielstands -->
    <h2>Spielstand:</h2>
    <ul>
        <?php foreach ($spiel->spieler as $spieler): ?>
            <li><?= $spieler->name ?> – Position: <?= $spieler->spielerPosition ?></li>
        <?php endforeach; ?>
    </ul>

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
