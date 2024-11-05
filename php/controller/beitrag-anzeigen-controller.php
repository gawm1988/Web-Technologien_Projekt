<?php
session_start();
if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Beitrag.php";
require_once $abs_path . "/php/model/Sammlung.php";

// Ueberpruefung der Parameter
if (!isset($_GET["id"]) || !is_numeric($_GET["id"])) {
    $_SESSION["message"] = "invalid_entry_id";
    header("Location: index.php");
    exit;
}

try {
    // Aufbereitung der Daten fuer die Kontaktierung des Models
    $id = intval($_GET["id"]);

    // Kontaktierung des Models (Geschaeftslogik)
    $sammlung = Sammlung::getInstance();
    $beitrag = $sammlung->readBeitrag($id);
    $eigentuemer = isset($_SESSION["account_id"]) && $beitrag->getCreator()->getId() === $_SESSION["account_id"];
    $admin = isset($_SESSION["account_id"]) && $_SESSION["account_id"] === 1;

} catch (MissingEntryException $exc) {
    $_SESSION["message"] = "invalid_entry_id";
    header("Location: index.php");
    exit;
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: index.php");
    exit;
}
