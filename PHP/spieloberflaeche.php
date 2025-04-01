<?php
include_once 'spieler.php'; // Spieler-Klasse einbinden
include_once 'spiel.php';   // Spiel-Klasse einbinden

// -----------------
// Spielstatus übernehmen
// -----------------
$playerCount = isset($_GET['players']) ? intval($_GET['players']) : 2;
$names = isset($_GET['names']) ? explode(',', $_GET['names']) : [];
if(empty($names)) {
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
    $positions = array_fill(0, $playerCount, 0);
}

// -----------------------
// Spiel-Objekt erstellen und Zustand setzen
// -----------------------
$spiel = new Spiel($names);
foreach ($spiel->spieler as $i => $spielerObj) {
    $spiel->spieler[$i]->spielerPosition = isset($positions[$i]) ? intval($positions[$i]) : 0;
}

// -----------------------
// Aktionsverarbeitung: Würfelknopf wurde gedrückt
// -----------------------
$actionOutput = '';
if (isset($_GET['roll'])) {
    ob_start();
    $spiel->zug_starten($currentPlayer);
    $actionOutput = ob_get_clean();

    // Nach dem Zug des letzten Spielers wird die Runde erhöht
    if ($currentPlayer >= $playerCount - 1) {
        $round++;
        $currentPlayer = 0;
    } else {
        $currentPlayer++;
    }
}

// -----------------------
// Aktualisiere die Positionen für das Formular
// -----------------------
$newPositions = [];
foreach ($spiel->spieler as $spielerObj) {
    $newPositions[] = $spielerObj->spielerPosition;
}
$positionsString = implode(',', $newPositions);

// -----------------------
// Spielfeld-Definition
// -----------------------
$boardLength = 30; // Gesamtzahl der Felder
$columns = 5;      // Anzahl der Spalten
// Farben für die Spielsteine (nach Index des Spielers)
$colors = ["red", "blue", "green", "orange", "purple", "cyan", "magenta"];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>Spielbrett</title>
    <link rel="stylesheet" href="../assets/css/styleOberflaeche.css">
    <style>
        /* Spielfeld als Grid */
        .board-container {
            display: grid;
            grid-template-columns: repeat(<?= $columns ?>, 1fr);
            gap: 5px;
            margin: 20px 0;
        }
        .cell {
            position: relative;
            border: 1px solid #ccc;
            height: 60px;
            background-color: #f9f9f9;
        }
        .cell-number {
            position: absolute;
            top: 2px;
            left: 2px;
            font-size: 10px;
            color: #999;
        }
        /* Spielstein als farbiger Punkt */
        .game-piece {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin: 2px;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="btn" id="zurück">Zurück zum Hauptmenü</a>
    
    <h1>Spielbrett</h1>
    <p>Aktuelle Runde: <?= $round ?></p>
    <p>Aktueller Zug: <?= $names[$currentPlayer] ?></p>
    
    <!-- Anzeige des letzten Zuges -->
    <?php if (isset($_GET['roll'])): ?>
        <div class="zug-info">
            <?= $actionOutput ?>
        </div>
    <?php endif; ?>

    <!-- Anzeige des Spielfelds als Grid -->
    <div class="board-container">
        <?php
        for ($cell = 0; $cell < $boardLength; $cell++) {
            echo '<div class="cell">';
            // Optional: Feldnummer anzeigen
            echo '<span class="cell-number">' . $cell . '</span>';
            // Zeige in jeder Zelle alle Spielsteine, die an dieser Position stehen
            foreach ($spiel->spieler as $index => $spieler) {
                if ($spieler->spielerPosition == $cell) {
                    $color = $colors[$index % count($colors)];
                    echo '<div class="game-piece" style="background-color:' . $color . ';" title="' . $spieler->name . '"></div>';
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
        <input type="hidden" name="players" value="<?= htmlspecialchars($playerCount) ?>">
        <input type="hidden" name="names" value="<?= htmlspecialchars(implode(',', $names)) ?>">
        <input type="hidden" name="round" value="<?= $round ?>">
        <input type="hidden" name="current" value="<?= $currentPlayer ?>">
        <input type="hidden" name="positions" value="<?= htmlspecialchars($positionsString) ?>">
        <button type="submit" name="roll" value="1">Würfeln (<?= $names[$currentPlayer] ?>)</button>
    </form>
</body>
</html>
