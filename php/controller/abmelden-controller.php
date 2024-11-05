<?php
session_start();

// Check if the CSRF token is set
if (!isset($_SESSION['csrf-token']) || !isset($_GET['csrf-token'])) {
    $_SESSION["message"] = "missing_csrf_token";
    header("Location: ../../index.php");
    exit;
}

// Check if the CSRF token is valid
if ($_SESSION['csrf-token'] !== $_GET['csrf-token']) {
    $_SESSION["message"] = "invalid_csrf_token";
    header("Location: ../../index.php");
    exit;
}

unset($_SESSION["account_id"]);

session_destroy();
header("Location: ../../index.php");
exit;