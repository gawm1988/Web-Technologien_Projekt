<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/accounts-index-controller.php";
/** @var Beitrag[] $beitraege
 * @var Account[] $accounts
 */

if (!($_SESSION["account_id"] === 1)) {
    header("Location: index.php");
    exit;
}

?>

<?php
require_once $abs_path . "/php/include/head.php";
?>


<title>Oldenburger Skulpturen - Nutzerliste</title>
<link rel="stylesheet" type="text/css" href="./assets/css/nutzerliste.css">

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

        <h1>Nutzerliste</h1>

        <?php if (empty($accounts)): ?>
            Keine Einträge vorhanden.
        <?php else: ?>
            <ol class="user-list">
                <?php foreach ($accounts as $account): ?>
                    <li class="user-details">
                        <span class="user-email"><?= htmlspecialchars($account->getEmail()) ?></span>

                        <?php if (!($account->getId() === 1)) : ?>
                            <div class="buttons">
                                <span class="button"><a href="mailto:<?= htmlspecialchars($account->getEmail()) ?>">Nachricht</a></span>
                                <span class="button"><a
                                            href="php/controller/nutzer-loeschen-controller.php?id=<?= urlencode($account->getID()) ?>"
                                            class="delete-link">Löschen</a></span>
                            </div>
                        <?php endif; ?>

                        <ul class="user-content">
                            <?php foreach ($beitraege as $beitrag): ?>
                                <?php if ($beitrag->getCreator()->getId() === $account->getId()): ?>
                                    <li>
                                        <a href="beitrag-anzeigen.php?id=<?= urlencode($beitrag->getId()) ?>">
                                            <?= htmlspecialchars($beitrag->getTitle()) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                <?php endforeach; ?>
            </ol>
        <?php endif; ?>
    </section>
</main>

<!-- JavaScript Bestätigung vor dem Löschen eines Nutzers-->
<script>
    const deleteLinks = document.querySelectorAll('.delete-link');

    deleteLinks.forEach(function (link) {
        link.addEventListener('click', function (event) {
            // Bestätigungsdialog anzeigen
            const confirmation = confirm('Möchten Sie diesen Nutzer wirklich löschen? Nicht übernommene Beiträge können nicht mehr bearbeitet werden. Diese Aktion kann nicht rückgängig gemacht werden.');
            // Wenn der Admin nicht bestätigt, die Standardaktion verhindern
            if (!confirmation) {
                event.preventDefault();
            }
        });
    });
</script>

<?php
require_once $abs_path . "/php/include/footer.php";
?>
</body>

</html>
