<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";

// Check if the correct user is logged in
if (!isset($_SESSION["account_id"])) {
    $_SESSION["message"] = "missing_permission";
    header("Location: ../../index.php");
    exit;
}

// Check if the CSRF token is set
if (!isset($_SESSION['csrf-token']) || !isset($_POST['csrf-token'])) {
    $_SESSION["message"] = "missing_csrf_token";
    header("Location: ../../passwort-aendern.php");
    exit;
}

// Check if the CSRF token is valid
if ($_SESSION['csrf-token'] !== $_POST['csrf-token']) {
    $_SESSION["message"] = "invalid_csrf_token";
    header("Location: ../../passwort-aendern.php");
    exit;
}

// Check if all parameters are set
if (!isset($_POST["password_old"]) || !isset($_POST["password_new"]) || !isset($_POST["password_new_repeat"]) || !isset($_POST["submit"])) {
    $_SESSION["message"] = "missing_parameters";
    header("Location: ../../passwort-aendern.php");
    exit;
}

// Check if all required parameters are not empty
if (empty($_POST["password_old"]) || empty($_POST["password_new"]) || empty($_POST["password_new_repeat"])) {
    $_SESSION["message"] = "missing_required_parameters";
    header("Location: ../../passwort-aendern.php");
    exit;
}

// Check if the passwords match
if ($_POST["password_new"] !== $_POST["password_new_repeat"]) {
    $_SESSION["message"] = "password_mismatch";
    header("Location: ../../passwort-aendern.php");
    exit;
}

// Define the password validation regex for 8+ characters, uppercase, lowercase, number, and special character
$passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';

// Check if the new password meets the requirements
if (!preg_match($passwordPattern, $_POST["password_new"])) {
    $_SESSION["message"] = "password_invalid_format";
    header("Location: ../../passwort-aendern.php");
    exit;
}

try {
    $accountsDAO = Accounts::getInstance();

    $id = $_SESSION["account_id"];
    $account = $accountsDAO->readAccount($id);
    $email = $account->getEmail();
    $password_old = $_POST["password_old"];
    $password_new = $_POST["password_new"];

    if ($account->checkPassword($password_old)) {
        $accountsDAO->updateAccount($id, $email, $password_old, $password_new);
    } else {
        $_SESSION["message"] = "invalid_credentials";
        header("Location: ../../passwort-aendern.php");
        exit;
    }
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../passwort-aendern.php");
    exit;
}

$_SESSION["message"] = "update_password";
header("Location: ../../index.php");
exit;