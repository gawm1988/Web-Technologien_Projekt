<?php
session_start();
if (!isset($abs_path)) {
    require_once "../../path.php";
}

require_once $abs_path . "/php/model/Account.php";
require_once $abs_path . "/php/model/Accounts.php";
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
    $_SESSION["title"] = $_POST["title"];
    $_SESSION["description"] = $_POST["description"];
    $_SESSION["location"] = $_POST["location"];
    header("Location: ../../beitrag-neu.php");
    exit;
}

// Check if the CSRF token is valid
if ($_SESSION['csrf-token'] !== $_POST['csrf-token']) {
    $_SESSION["message"] = "invalid_csrf_token";
    $_SESSION["title"] = $_POST["title"];
    $_SESSION["description"] = $_POST["description"];
    $_SESSION["location"] = $_POST["location"];
    header("Location: ../../beitrag-neu.php");
    exit;
}

// Check if all parameters are set
if (!isset($_POST["title"]) || !isset($_FILES["picture"]) || !isset($_POST["description"]) || !isset($_POST["location"]) || !isset($_POST["submit"])) {
    $_SESSION["message"] = "missing_entry_parameters";
    $_SESSION["title"] = $_POST["title"];
    $_SESSION["description"] = $_POST["description"];
    $_SESSION["location"] = $_POST["location"];
    header("Location: ../../beitrag-neu.php");
    exit;
}

// Check if all required parameters are not empty
if (empty($_POST["title"]) || empty($_FILES["picture"]) || empty($_POST["description"]) || empty($_POST["location"])) {
    $_SESSION["message"] = "missing_required_entry_parameters";
    $_SESSION["title"] = $_POST["title"];
    $_SESSION["description"] = $_POST["description"];
    $_SESSION["location"] = $_POST["location"];
    header("Location: ../../beitrag-neu.php");
    exit;
}

try {
    if (isset($_FILES['picture']) && $_FILES['picture']['error'] == UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['picture']['tmp_name'];
        $fileName = $_FILES['picture']['name'];
        $fileSize = $_FILES['picture']['size'];
        $fileType = $_FILES['picture']['type'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        // Erlaubte Dateitypen (z.B. jpg, png, gif)
        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');

        // Überprüfen, ob die Dateiendung zulässig ist
        if (in_array($fileExtension, $allowedfileExtensions)) {
            // Verzeichnis, in dem die Datei gespeichert werden soll
            $uploadFileDir = $abs_path . "/assets/media/uploads/";

            // Sicherstellen, dass der Zielordner existiert
            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0777, true);
            }

            // Sicherstellen, dass der Dateiname eindeutig ist
            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;

            // Zielpfad für das Hochladen
            $dest_path = $uploadFileDir . $newFileName;

            // Datei in den Zielordner verschieben
            $success = move_uploaded_file($fileTmpPath, $dest_path);
            if (!$success) {
                $_SESSION["message"] = "failed_upload";
                $_SESSION["title"] = $_POST["title"];
                $_SESSION["description"] = $_POST["description"];
                $_SESSION["location"] = $_POST["location"];
                header("Location: ../../beitrag-neu.php");
                exit;
            }
        } else {
            $_SESSION["message"] = "wrong_type";
            $_SESSION["title"] = $_POST["title"];
            $_SESSION["description"] = $_POST["description"];
            $_SESSION["location"] = $_POST["location"];
            header("Location: ../../beitrag-neu.php");
            exit;
        }
    } else {
        $_SESSION["message"] = "failed_upload";
        $_SESSION["title"] = $_POST["title"];
        $_SESSION["description"] = $_POST["description"];
        $_SESSION["location"] = $_POST["location"];
        header("Location: ../../beitrag-neu.php");
        exit;
    }


    $address = Beitrag::getCoordinatesFromAddress(htmlspecialchars($_POST["location"]));

    $sammlungDAO = Sammlung::getInstance();
    $beitrag_id = $sammlungDAO->createBeitrag($_SESSION["account_id"], $_POST["title"], "assets/media/uploads/" . $newFileName, $_POST["description"], $_POST["location"], $address["lat"], $address["lng"]);
} catch (InternalErrorException $exc) {
    $_SESSION["message"] = "internal_error";
    header("Location: ../../beitrag-neu.php");
    exit;
} catch (Exception $exc) {
    $_SESSION["message"] = "unknown_error";
    header("Location: ../../beitrag-neu.php");
    exit;
}

$_SESSION["message"] = "new_entry";

header("Location: ../../index.php");
exit;

