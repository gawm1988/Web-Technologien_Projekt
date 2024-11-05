<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";

// Check if all parameters are set
if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["submit"])) {
    $_SESSION["message"] = "missing_login_parameters";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../anmeldung.php");
    exit;
}

// Check if all required parameters are not empty
if (empty($_POST["email"]) || empty($_POST["password"])) {
    $_SESSION["message"] = "missing_required_login_parameters";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../anmeldung.php");
    exit;
}

try {
    $accountsDAO = Accounts::getInstance();

    $email = $_POST["email"];
    $password = $_POST["password"];

    $account = $accountsDAO->readAccountByEmail($email);
    if ($account->checkPassword($password)) {
        if (!$account->getActivated()) {
            $_SESSION["message"] = "account_not_activated";
            header("Location: ../../registrierung.php");
            exit;
        }

        $_SESSION["account_id"] = $account->getId();
        $_SESSION["csrf-token"] = uniqid(more_entropy: true);
    } else {
        $_SESSION["message"] = "invalid_credentials";
        header("Location: ../../anmeldung.php");
        exit;
    }
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../anmeldung.php");
    exit;
} catch (MissingEntryException $exc) {
    $_SESSION["message"] = "account_not_found";
    header("Location: ../../anmeldung.php");
    exit;
}

header("Location: ../../index.php");
exit;