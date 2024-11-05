<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Beitrag.php";
require_once $abs_path . "/php/model/Sammlung.php";

// Check if the user is logged in
if (!isset($_SESSION["account_id"])) {
    $_SESSION["message"] = "missing_permission";
    header("Location: ../../index.php");
    exit;
}

// Check if the CSRF token is set
if (!isset($_SESSION['csrf-token']) || !isset($_POST['csrf-token'])) {
    $_SESSION["message"] = "missing_csrf_token";

    if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
        header("Location: ../../beitrag-anzeigen.php?id=" . urlencode($_POST["id"]));
    } else {
        header("Location: ../../index.php");
    }
    exit;
}

// Check if the CSRF token is valid
if ($_SESSION['csrf-token'] !== $_POST['csrf-token']) {
    $_SESSION["message"] = "invalid_csrf_token";

    if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
        header("Location: ../../beitrag-anzeigen.php?id=" . urlencode($_POST["id"]));
    } else {
        header("Location: ../../index.php");
    }
    exit;
}

// Check if all parameters are set
if (!isset($_POST["id"]) || !isset($_POST["submit"])) {
    $_SESSION["message"] = "missing_parameters";

    if (isset($_POST["id"]) && is_numeric($_POST["id"])) {
        header("Location: ../../beitrag-anzeigen.php?id=" . urlencode($_POST["id"]));
    } else {
        header("Location: ../../index.php");
    }
    exit;
}

// Check if all required parameters are not empty
if (!is_numeric($_POST["id"])) {
    $_SESSION["message"] = "missing_required_parameters";

    if (is_numeric($_POST["id"])) {
        header("Location: ../../beitrag.php?id=" . urlencode($_POST["id"]));
    } else {
        header("Location: ../../index.php");
    }
    exit;
}

try {
    $sammlungDAO = Sammlung::getInstance();
    $sammlungDAO->deleteBeitrag(intval($_POST["id"]), $_SESSION["account_id"]);
} catch (MissingEntryException $exc) {
    $_SESSION["message"] = "invalid_entry_id";
    header("Location: ../../index.php");
    exit;
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../index.php");
    exit;
}

$_SESSION["message"] = "delete_entry";

header("Location: ../../index.php");
exit;