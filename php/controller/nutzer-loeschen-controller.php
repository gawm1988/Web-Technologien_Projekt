<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";

// Check if the user is logged in AND user is admin
if (!($_SESSION["account_id"] === 1)) {
    $_SESSION["message"] = "missing_permission";
    header("Location: ../../index.php");
    exit;
}

// Check if all parameters are set
if (!isset($_GET["id"])) {
    $_SESSION["message"] = "missing_parameters";
    header("Location: ../../nutzerliste.php");
    exit;
}

// Check if all required parameters are not empty
if (!is_numeric($_GET["id"])) {
    $_SESSION["message"] = "missing_required_parameters";
    header("Location: ../../nutzerliste.php");
    exit;
}

// Admin account can not be deleted
if ($_GET["id"] === 1) {
    $_SESSION["message"] = "blocked_entry";
    header("Location: ../../nutzerliste.php");
    exit;
}

try {
    $accountsDAO = Accounts::getInstance();
    $accountsDAO->deleteAccount(intval($_GET["id"]));
} catch (MissingEntryException $exc) {
    $_SESSION["message"] = "invalid_entry_id";
    header("Location: ../../nutzerliste.php");
    exit;
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../nutzerliste.php");
    exit;
}

$_SESSION["message"] = "delete_entry";

header("Location: ../../nutzerliste.php");
exit;
