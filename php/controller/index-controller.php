<?php
session_start();
if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Beitrag.php";
require_once $abs_path . "/php/model/Sammlung.php";

try {

    // Kontaktierung des Models (Geschaeftslogik)
    $sammlungDAO = Sammlung::getInstance();
    $beitraege = $sammlungDAO->readAllBeitraege();

} catch (InternerFehlerException $exc) {
    // Behandlung von potentiellen Fehlern der Geschaeftslogik
    $_SESSION["message"] = "internal_error";
}
