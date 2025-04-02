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
// -----------------
// Finish-Orders übernehmen (0 = nicht fertig)
$finishParameter = isset($_GET['finish']) ? $_GET['finish'] : '';
if ($finishParameter !== '') {
    $finishOrders = explode(',', $finishParameter);
} else {
    $finishOrders = array_fill(0, $anzahlSpieler, 0);
}

// -----------------------
// Feste Zellengröße (120px, unabhängig von der Spieleranzahl)
$zellenGroesse = 120;

// -----------------------
// Spielfeld-Definition
$spielfeldLaenge = 30; // Gesamtzahl der Felder (Ziel ist Feld 29)
$spalten = 5;          // Anzahl der Spalten
// Erweiterte Farbliste für die Spielsteine
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
    // Setze fertig, falls FinishOrder != 0
    $spiel->spieler[$i]->istFertig = ($finishOrders[$i] != 0);
}

// -----------------------
// Falls der aktuelle Spieler bereits fertig ist, überspringe ihn
while ($spiel->spieler[$aktuellerSpieler]->istFertig) {
    if ($aktuellerSpieler >= $anzahlSpieler - 1) {
        $runde++;
        $aktuellerSpieler = 0;
    } else {
        $aktuellerSpieler++;
    }
}

// -----------------------
// Aktionsverarbeitung: Würfelknopf wurde gedrückt
$aktionsAusgabe = '';
if (isset($_GET['roll'])) {
    ob_start();
    $spiel->zug_starten($aktuellerSpieler);
    $aktionsAusgabe = ob_get_clean();
    
    // Wenn der Spieler das Ziel erreicht (Feld 29), markiere ihn als fertig, falls noch nicht geschehen
    if ($spiel->spieler[$aktuellerSpieler]->spielerPosition >= $spielfeldLaenge - 1 && $finishOrders[$aktuellerSpieler] == 0) {
        // Ermittlung der nächsten Finish-Nummer (kleinster > 0, also max + 1)
        $finishCounter = max($finishOrders) + 1;
        $finishOrders[$aktuellerSpieler] = $finishCounter;
        $spiel->spieler[$aktuellerSpieler]->istFertig = true;
        // Position fixieren
        $spiel->spieler[$aktuellerSpieler]->spielerPosition = $spielfeldLaenge - 1;
    }
    
    // Nach dem Zug: Überspringe alle fertiggestellten Spieler
    $startSpieler = $aktuellerSpieler;
    do {
        if ($aktuellerSpieler >= $anzahlSpieler - 1) {
            $runde++;
            $aktuellerSpieler = 0;
        } else {
            $aktuellerSpieler++;
        }
        if ($aktuellerSpieler == $startSpieler) break;
    } while ($spiel->spieler[$aktuellerSpieler]->istFertig);
}

// -----------------------
// Aktualisiere die Positionen für das Formular
$neuePositionen = [];
foreach ($spiel->spieler as $spielerObj) {
    $neuePositionen[] = $spielerObj->spielerPosition;
}
$positionenString = implode(',', $neuePositionen);
$finishString = implode(',', $finishOrders);
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title></title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --cell-size: <?= $zellenGroesse ?>px;
            --columns: <?= $spalten ?>;
        }
    </style>
</head>
<body>
    <a href="../index.php" class="btn" id="zurück">Zurück zum Hauptmenü</a>
    
    <h1></h1>
    <p>Aktuelle Runde: <?= $runde ?></p>
    <p>Aktueller Zug: <?= $spielernamen[$aktuellerSpieler] ?></p>
    
    <?php /* if (isset($_GET['roll'])): ?>
        <div class="zug-info">
            <?= $aktionsAusgabe ?>
        </div>
    <?php endif; */ ?>

    <div class="board-container">
        <?php
        for ($feld = 0; $feld < $spielfeldLaenge; $feld++) {
            echo '<div class="cell">';
            echo '<span class="cell-number">' . $feld . '</span>';
            $tokens = [];
            foreach ($spiel->spieler as $index => $spieler) {
                if ($spieler->spielerPosition == $feld) {
                    $tokens[] = ['index' => $index, 'name' => $spieler->name, 'fertig' => $spieler->istFertig];
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

    <!-- Rangliste -->
    <?php
    // Kopie des Spieler-Arrays, sortiert: Fertiggestellte Spieler nach FinishOrder (kleinste zuerst),
    // und aktive Spieler nach aktueller Position (absteigend).
    $sortierteSpieler = $spiel->spieler;
    usort($sortierteSpieler, function($a, $b) use ($finishOrders) {
        $finishA = $finishOrders[$a->spielerId];
        $finishB = $finishOrders[$b->spielerId];
        if ($finishA != 0 && $finishB != 0) {
            return $finishA - $finishB;
        } elseif ($finishA != 0) {
            return -1;
        } elseif ($finishB != 0) {
            return 1;
        } else {
            return $b->spielerPosition - $a->spielerPosition;
        }
    });
    ?>
    <div class="ranking-list">
        <h2>Rangliste</h2>
        <?php
        $rank = 1;
        foreach ($sortierteSpieler as $spieler) {
            $farbe = $farben[$spieler->spielerId % count($farben)];
            echo '<div class="ranking-entry">';
            echo '<div class="ranking-color" style="background-color:' . $farbe . ';"></div>';
            echo '<span>' . $rank . '. ' . $spieler->name . ' – ';
            if ($finishOrders[$spieler->spielerId] != 0) {
                echo "Ziel (Platz " . $finishOrders[$spieler->spielerId] . ")";
            } else {
                echo $spieler->spielerPosition;
            }
            echo '</span>';
            echo '</div>';
            $rank++;
        }
        ?>
    </div>

    <form method="get" action="">
        <input type="hidden" name="players" value="<?= htmlspecialchars($anzahlSpieler) ?>">
        <input type="hidden" name="names" value="<?= htmlspecialchars(implode(',', $spielernamen)) ?>">
        <input type="hidden" name="round" value="<?= $runde ?>">
        <input type="hidden" name="current" value="<?= $aktuellerSpieler ?>">
        <input type="hidden" name="positions" value="<?= htmlspecialchars($positionenString) ?>">
        <input type="hidden" name="finish" value="<?= htmlspecialchars($finishString) ?>">
        <button type="submit" name="roll" value="1">Würfeln</button>
    </form>
    
    <!-- Aufgabenfeld-Pop-up -->
    <!-- Pop-up für Aufgabenfeld -->
    <div id="aufgabenPopup" class="popup" style="display: none;">
        <div class="popup-content">
            <h2 id="popup-title">Aufgabe</h2>
            <p id="aufgabenText"></p>
            <button class = "aufgabenBtn" id="aufgabeJa">Ja</button>
            <button class = "aufgabenBtn" id="aufgabeNein">Nein</button>
        </div>
    </div>

    <script src="../assets/js/spieloberflaeche.js"></script>

</body>
</html>
