<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";

$email = $_SESSION["email"] ?? "";
unset($_SESSION["email"]);
?>

<?php
require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Registrierung</title>
<link rel="stylesheet" type="text/css" href="./assets/css/registrierung.css">
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

        <h1>Registrieren</h1>

        <div class="form-container">
            <form action="php/controller/registrieren-controller.php" method="POST">
                <div class="form-inputs">
                    <label for="email">E-Mail:</label>
                    <input type="email" id="email" name="email" maxlength="100" placeholder="E-Mail-Adresse eingeben"
                           value="<?= htmlspecialchars($email) ?>" required>

                    <label for="password">Passwort:</label>
                    <input type="password" id="password" name="password" minlength="8" maxlength="100"
                           placeholder="Passwort eingeben" required>

                    <label for="password_repeat">Passwort wiederholen:</label>
                    <input type="password" id="password_repeat" name="password_repeat" minlength="8" maxlength="100"
                           placeholder="Passwort wiederholen" required>

                    <label for="terms_of_use" class="terms">
                        <input type="checkbox" id="terms_of_use" name="terms_of_use" required>
                        Ich habe die <a href="nutzungsbedingungen.php" target="_blank">Nutzungsbedingungen</a> gelesen
                        und stimme diesen zu.
                    </label>

                    <label for="data_privacy" class="terms">
                        <input type="checkbox" id="data_privacy" name="data_privacy" required>
                        Ich stimme der Verarbeitung meiner Daten gemäß der <a href="datenschutz.php" target="_blank">Datenschutzerklärung</a>
                        zu und erkläre mich damit einverstanden, dass meine Nutzung des Dienstes den genannten
                        Bedingungen unterliegt.
                    </label>

                    <input type="submit" name="submit" class="button" value="Registrieren">
                </div>
            </form>
        </div>
        <div class="buttons">
            <div class="button"><a href="anmeldung.php">Benutzerkonto vorhanden</a></div>
        </div>
    </section>

</main>

<?php include_once $abs_path . "/php/include/footer.php" ?>
</body>

</html>