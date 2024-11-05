<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";


if (isset($_SESSION["account_id"])) {
$_SESSION["message"] = "already_logged_in";
header("Location: ./index.php"); // replace with error page if implemented
exit;
}

$email = isset($_SESSION["email"]) ? $_SESSION["email"] : "";
unset($_SESSION["email"]);

?>

<?php
require_once $abs_path . "/php/include/head.php";
?>

    <title>Oldenburger Skulpturen - Anmelden</title>
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
                <p>Um unsere Website korrekt nutzen Sie können, aktivieren Sie bitte <b><u>JavaScript</u></b> in Ihren Browsereinstellungen.</p>
            </noscript>
            <?php include_once $abs_path . "/php/include/message.php" ?>
        </div>

        <h1>Anmelden</h1>

        <div class="form-container">
            <form action="php/controller/anmelden-controller.php" method="POST">
                <div class="form-inputs">
                    <label for="email">E-Mail:</label>
                    <input type="email" id="email" name="email" maxlength="100" placeholder="E-Mail-Adresse eingeben"
                           value="<?= htmlspecialchars($email) ?>" required>
                    <label for="password">Passwort:</label>
                    <input type="password" id="password" name="password" maxlength="100" placeholder="Passwort eingeben"
                           required>
                    <input type="submit" class="button" name="submit" value="Anmelden">
                </div>
            </form>
        </div>
        <div class="buttons">
            <div class="button"><a href="registrierung.php">Registrieren</a></div>
            <!--Passwort vergessen implementieren (laut Aufgabenstellung nicht erforderlich)-->
            <div class="button"><a href="anmeldung.php">Passwort vergessen</a></div>
        </div>

    </section>

</main>

<?php include_once $abs_path . "/php/include/footer.php" ?>
</body>

</html>
