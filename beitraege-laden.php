<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";
/**
 * @var Beitrag[] $beitraege
 */

// Offset und Limit für das Nachladen
$offset = isset($_GET['offset']) ? intval($_GET['offset']) : 0;
$limit = 3;  // Immer 3 Beiträge nachladen

// Beiträge ab dem Offset laden
$beitraege = array_slice($beitraege, $offset, $limit);

// JSON-Ausgabe der geladenen Beiträge
$response = [];
foreach ($beitraege as $beitrag) {
    $response[] = [
        'id' => $beitrag->getId(),
        'title' => htmlspecialchars($beitrag->getTitle()),
        'picture' => htmlspecialchars($beitrag->getPicture())
    ];
}

// JSON zurückgeben
header('Content-Type: application/json');
echo json_encode($response);