<?php
include_once 'spieler.php';
header('Content-Type: application/json');

$input = json_decode(file_get_contents("php://input"), true);
if (!$input || !isset($input['name']) || !isset($input['spiel_id'])) {
    echo json_encode(['success' => false, 'error' => 'Ungültige Eingabedaten']);
    exit;
}

$spieler = new Spieler($input['name'], intval($input['spiel_id']));
echo json_encode([
    'success' => true,
    'spieler_id' => $spieler->spielerId,
    'spieler' => $spieler->getInfo()
]);
