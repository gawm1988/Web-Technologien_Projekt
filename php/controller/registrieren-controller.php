<?php
session_start();

if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";
require_once $abs_path . "/php/model/EmailAlreadyExistsException.php";


// Check if all parameters are set
if (!isset($_POST["email"]) || !isset($_POST["password"]) || !isset($_POST["password_repeat"]) || !isset($_POST["submit"])) {
    $_SESSION["message"] = "missing_register_parameters";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}

// Check if all required parameters are not empty
if (empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["password_repeat"])) {
    $_SESSION["message"] = "missing_required_register_parameters";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}

// Check if the email is valid
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    $_SESSION["message"] = "wrong_email";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}

// Check if the passwords match
if ($_POST["password"] !== $_POST["password_repeat"]) {
    $_SESSION["message"] = "password_mismatch";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}


// Define the password validation regex for 8+ characters, uppercase, lowercase, number, and special character
$passwordPattern = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\W_]).{8,}$/';

// Check if the new password meets the requirements
if (!preg_match($passwordPattern, $_POST["password_new"])) {
    $_SESSION["message"] = "password_invalid_format";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}

try {

    if ($_POST['terms_of_use'] !== 'on' || $_POST['data_privacy'] !== 'on') {
        throw new MissingCheckboxException();
    }

    $accountsDAO = Accounts::getInstance();
    $_SESSION["activation_code"] = Account::generateRandomString(32);

    $existingAccount = $accountsDAO->readAccountByEmail($_POST["email"]);
    $id = $existingAccount->getID();

    if ($existingAccount->getActivated() === true) {
        file_put_contents(
            "verify/" . $_POST["email"] . ".txt",
            "Sie sind bereits registriert!" .
            "\n\n\nBitte ignorieren Sie die E-Mail, falls Sie nicht versucht haben, sich zu registrieren." .
            "\n\n\nFalls Sie Ihr Passwort vergessen haben, können Sie auf der Anmeldeseite ein neues Passwort anfordern.");

    } else {
        file_put_contents(
            "verify/" . $_POST["email"] . ".txt",
            "Ihr Aktivierungscode lautet: " . $_SESSION["activation_code"] .
            "\n\n\nBitte ignorieren Sie die E-Mail, falls Sie nicht versucht haben, sich zu registrieren." .
            "\n\n\nDiese Mail wurde automatisch verschickt!");
    }

    $_SESSION["account_to_activate"] = $id;
    $_SESSION["file"] = "verify/" . $_POST["email"] . ".txt";

} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
} catch (MissingEntryException) {
    $accountsDAO = Accounts::getInstance();
    $id = $accountsDAO->createAccount($_POST["email"], $_POST["password"]);

    file_put_contents(
        "verify/" . $_POST["email"] . ".txt",
        "Ihr Aktivierungscode lautet: " . $_SESSION["activation_code"] .
        "\n\n\nBitte ignorieren Sie die E-Mail, falls Sie nicht versucht haben, sich zu registrieren." .
        "\n\n\nDiese Mail wurde automatisch verschickt!");

    $_SESSION["account_to_activate"] = $id;
    $_SESSION["file"] = "verify/" . $_POST["email"] . ".txt";
} catch (MissingCheckboxException $exc) {
    $_SESSION["message"] = "missing_checkbox";
    $_SESSION["email"] = $_POST["email"];
    header("Location: ../../registrierung.php");
    exit;
}

$_SESSION["message"] = "new_entry";

header("Location: ../../registrierung-erfolgreich.php");
exit;