<<<<<<< HEAD:PHP/spieloberflaeche.php
<<<<<<<< HEAD:PHP/spieloberflaeche.php
=======
>>>>>>> bceaec6325b52213e3faa19fdc9ecf64e8c97c9a:MeineWebseite/PHP/spieloberflaeche.php
<?php
include_once 'spieler.php'; // Spieler-Klasse einbinden

// Prüfen, ob Spieler-Daten übergeben wurden
if (isset($_GET['names']) && isset($_GET['players'])) {
    $names = explode(",", $_GET['names']); // Namen aus Query-String holen
    $spielerAnzahl = intval($_GET['players']);

    $spielerListe = [];

    foreach ($names as $index => $name) {
        $spielerListe[] = new Spieler(urldecode($name), $index); // Spiele-ID 1 als Beispiel
    }

    // Test-Ausgabe der Spieler
    foreach ($spielerListe as $spieler) {
        echo $spieler->getInfo() . "<br>";
    }
} else {
    echo "Keine Spieler-Daten erhalten.";
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielbrett</title>
    <link rel="stylesheet" href="..\assets\css\styleOberflaeche.css">
</head>
<body>
    <!--<h1>Spiel läuft mit <?= $playerCount ?> Spielern!</h1>-->
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
    <a href="..\index.php" class="btn" id="zurück">Zurück zum Hauptmenü</a>

</body>
</html>
<<<<<<< HEAD:PHP/spieloberflaeche.php
========
>>>>>>>> bceaec6325b52213e3faa19fdc9ecf64e8c97c9a:MeineWebseite/PHP/spiel.php
=======
>>>>>>> bceaec6325b52213e3faa19fdc9ecf64e8c97c9a:MeineWebseite/PHP/spieloberflaeche.php
