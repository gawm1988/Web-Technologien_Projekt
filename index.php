<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";
/**
 * @var Beitrag[] $beitraege
 */
if (isset($_GET['load_all'])) {
    $loadAll = true;
} else {
    $loadAll = false;
};
?>

<?php
// Begrenzte Anzahl der Beiträge, wenn nicht `load_all` aktiv ist
if (!$loadAll) {
    $initialLimit = 3;
    $beitraege = array_slice($beitraege, 0, $initialLimit);
}
?>


<?php
require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Startseite</title>
<link rel="stylesheet" type="text/css" href="./assets/css/index.css">


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

        <h1>Skulpturen</h1>


        <?php if (empty($beitraege)): ?>
            Keine Einträge vorhanden.

        <?php else: ?>
            <div class="sculpture-container">
                <?php foreach ($beitraege as $beitrag): ?>


                    <div class="sculpture-card">
                        <a href="beitrag-anzeigen.php?id=<?= urlencode($beitrag->getId()) ?>">
                            <img src="<?= htmlspecialchars($beitrag->getPicture()) ?>"
                                 alt="<?= htmlspecialchars($beitrag->getTitle()) ?>"><br>
                            <div class="card-title"><?= htmlspecialchars($beitrag->getTitle()) ?></div>
                        </a>
                    </div>


                <?php endforeach; ?>
            </div>

        <?php endif; ?>


        <div class="buttons">
            <?php if (isset($_SESSION["account_id"])): ?>
                <div class="button"><a href="beitrag-neu.php">Neuen Beitrag verfassen</a></div>
            <?php endif;
            if (!$loadAll) : ?>
                <div class="button" id="load-more-button"><a href="javascript:void(0);">Weitere Beiträge laden</a></div>
                <noscript>
                    <div class="button"><a href="?load_all=true">Alle Beiträge anzeigen</a></div>
                </noscript>
            <?php endif; ?>
        </div>


    </section>
</main>

<!--Skript für die "weitere Beiträge laden"-Funktion-->
<script src="./assets/js/beitraege-laden.js"></script>


<?php
require_once $abs_path . "/php/include/footer.php";
?>

</body>

</html>