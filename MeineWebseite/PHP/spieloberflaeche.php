<?php
// Anzahl der Spieler aus GET-Parameter abrufen
$playerCount = isset($_GET['players']) ? (int)$_GET['players'] : 2;
$names = isset($_GET['names']) ? explode(",", $_GET['names']) : [];
?>
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielbrett</title>
    <link rel="stylesheet" href="..\assets\css\style.css">
</head>
<body>
    <h1>Spiel läuft mit <?= $playerCount ?> Spielern!</h1>
    <!-- <div class="board-container">
        <div class="field start">START</div>
        <div class="field drink">Alle trinken</div>
        <div class="field rule">REGEL</div>
        <div class="field action">GROUP SHOT</div>
        <div class="field drink">Wasserfall</div>
        <div class="field rule">Kategorie</div>
        <div class="field drink">Trink 2 Schlucke</div>
        <div class="field action">Question Master</div>
        <div class="field drink">Beide Nachbarn trinken</div>
        <div class="field action">Gastgeber trinkt</div>
        <div class="field rule">REGEL</div>
        <div class="field action">Daumenking</div>
        <div class="field drink">Alle trinken</div>
        <div class="field drink">Wasserpause!</div>
        <div class="field action">Nochmal würfeln</div>
        <div class="field rule">REGEL</div>
        <div class="field drink">Alle trinken</div>
        <div class="field rule">REGEL</div>
        <div class="field action">GROUP SHOT</div>
        <div class="field drink">Wasserfall</div>
        <div class="field rule">Kategorie</div>
        <div class="field drink">Trink 2 Schlucke</div>
        <div class="field action">Question Master</div>
        <div class="field drink">Beide Nachbarn trinken</div>
        <div class="field action">Gastgeber trinkt</div>
        <div class="field rule">REGEL</div>
        <div class="field action">Daumenking</div>
        <div class="field drink">Alle trinken</div>
        <div class="field drink">Wasserpause!</div>
        <div class="field action">Nochmal würfeln</div>
        <div class="field rule">REGEL</div>
        <div class="field drink">Alle trinken</div>
        <div class="field rule">REGEL</div>
        <div class="field action">GROUP SHOT</div>
        <div class="field drink">Wasserfall</div>
        <div class="field rule">Kategorie</div>
        <div class="field drink">Trink 2 Schlucke</div>
        <div class="field action">Question Master</div>
        <div class="field drink">Beide Nachbarn trinken</div>
        <div class="field action">Gastgeber trinkt</div>
        <div class="field rule">REGEL</div>
        <div class="field rule">REGEL</div>
    </div> -->
    <a href="..\index.php" class="btn">Zurück zum Hauptmenü</a>
</body>
</html>
