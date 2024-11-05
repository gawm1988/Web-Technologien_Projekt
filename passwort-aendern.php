<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";

// Check if the user is logged in
if (!isset($_SESSION["account_id"])) {
    $_SESSION["message"] = "missing_permission";
    header("Location: index.php");
    exit;
}

?>

<?php
require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Passwort ändern</title>
<link rel="stylesheet" type="text/css" href="./assets/css/anmeldung.css">
</head>
<body>

<?php
include_once $abs_path . "/php/include/cookies.php";
include_once $abs_path . "/php/include/nav.php";
?>
<main class="main">

    <section>

        <div class="alert">
            <noscript>
                <p>Um unsere Website korrekt nutzen Sie können, aktivieren Sie bitte <b><u>JavaScript</u></b> in Ihren
                    Browsereinstellungen.</p>
            </noscript>
            <?php include_once $abs_path . "/php/include/message.php" ?>
        </div>

        <h1>Passwort ändern</h1>

        <div class="form-container">
            <form action="php/controller/passwort-aendern-controller.php" method="POST">
                <div class="form-inputs">
                    <label for="password_old">Altes Passwort:</label>
                    <input type="password" id="password_old" name="password_old" maxlength="100"
                           placeholder="Altes Passwort eingeben"
                           required>
                    <label for="password_new">Neues Passwort:</label>
                    <input type="password" id="password_new" name="password_new" maxlength="100"
                           placeholder="Neues Passwort eingeben"
                           required>
                    <label for="password_new_repeat">Neues Passwort wiederholen:</label>
                    <input type="password" id="password_new_repeat" name="password_new_repeat" maxlength="100"
                           placeholder="Neues Passwort wiederholen"
                           required>
                    <input type="hidden" name="csrf-token" value="<?= htmlspecialchars($_SESSION["csrf-token"]) ?>">
                    <input type="submit" name="submit" class="button" value="Passwort ändern">
                </div>
            </form>
        </div>
    </section>

</main>

<?php include_once $abs_path . "/php/include/footer.php" ?>
</body>

</html>
