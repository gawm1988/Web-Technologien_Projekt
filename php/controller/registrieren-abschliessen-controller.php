<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";

try {
    if (isset($_POST["code"]) && is_string($_POST["code"])) {
        if (isset($_SESSION['activation_code']) && $_SESSION["activation_code"] == $_POST["code"]) {
            unset($_SESSION['activation_code']);
            $accountsDAO = Accounts::getInstance();
            $accountsDAO->activateAccount($_SESSION["account_to_activate"]);

            //Registrierungsdatei löschen
            if (!unlink($_SESSION["file"])) {
                $_SESSION["message"] = "internal_error";
                header("Location: ../../registrierung.php");
                exit;
            }
        }
    }
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../registrierung.php");
    exit;
}

$_SESSION["message"] = "new_account";
unset($_SESSION["account_to_activate"]);
unset($_SESSION["file"]);

header("Location: ../../anmeldung.php");
exit;

