<?php
if (!isset($abs_path)) {
    require_once "../../path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";
require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";


try {

    // Kontaktierung des Models (Geschaeftslogik)
    $accountsDAO = Accounts::getInstance();
    $accounts = $accountsDAO->readAllAccounts();

} catch (InternerFehlerException $exc) {
    // Behandlung von potentiellen Fehlern der Geschaeftslogik
    $_SESSION["message"] = "internal_error";
}