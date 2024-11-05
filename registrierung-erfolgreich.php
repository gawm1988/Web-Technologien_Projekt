<?php
session_start();

if (!isset($abs_path)) {
    require_once "path.php";
}

if (empty($_SESSION["file"])) {
    header("Location: ./index.php");
    exit;
}

if (isset($_SESSION["account_id"])) {
    header("Location: ./index.php");
    exit;
}

require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Startseite</title>
<link rel="stylesheet" type="text/css" href="./assets/css/registrierung.css">


</head>

<body>

<?php
require_once $abs_path . "/php/include/cookies.php";
require_once $abs_path . "/php/include/nav.php";
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

        <div class="registry-success">
            <p>Sie erhalten in Kürze einen Aktivierungscode per E-Mail. Geben Sie diesen hier in, um ihr Konto zu
                aktivieren.</p>
            <p><a href="<?= htmlspecialchars("php/controller/" . $_SESSION['file']) ?>" target="_blank">Weitere
                    Informationen
                    finden Sie in der <span class="link">Datei</span>.</a></p>

            <form action="php/controller/registrieren-abschliessen-controller.php" method="POST">
                <div class="registry-success-form">
                    <label for="code">Aktivierungscode:</label><br>
                    <input type="text" id="code" name="code" placeholder="Bitte den Aktivierungscode eingeben" required>
                </div>
                <div class="buttons">
                    <button type="submit" name="submit" class="button">Abschicken</button>
                </div>
            </form>
        </div>
    </section>
</main>

<?php include_once $abs_path . "/php/include/footer.php"; ?>

</body>
</html>
