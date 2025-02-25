<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spielmenü</title>
    <link rel="stylesheet" href="assets/css/styleMainMenu.css">
</head>
<body>
<div class="menu-container">
        <h1>Spielmenü</h1>
        <ul class="menu-list">
            <li><a href="#" id="startGame">Spielen</a></li>
            <li><a href="PHP/spielanleitung.php">Spielanleitung</a></li>
            <li><a href="PHP/einstellungen.php">Einstellungen</a></li>
            <li><a href="PHP/beenden.php">Beenden</a></li>
        </ul>
    </div>

    <!-- Pop-up 1: Spieleranzahl wählen -->
    <div id="popup-players" class="popup">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>Spieleranzahl wählen</h2>
            <select id="playerCount">
                <?php for ($i = 2; $i <= 10; $i++): ?>
                    <option value="<?= $i ?>"><?= $i ?> Spieler</option>
                <?php endfor; ?>
            </select>
            <button id="confirmPlayers">Weiter</button>
        </div>
    </div>

    <!-- Pop-up 2: Spielernamen eingeben -->
    <div id="popup-names" class="popup">
        <div class="popup-content">
            <span class="close-btn">&times;</span>
            <h2>Spielernamen eingeben</h2>
            <form id="nameForm">
                <div id="nameInputs"></div>
                <button type="submit">Spiel starten</button>
            </form>
        </div>
    </div>


<script src="assets/js/Spieleinstellung.js"></script>

</body>
</html>