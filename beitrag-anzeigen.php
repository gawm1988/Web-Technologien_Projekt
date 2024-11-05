<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/beitrag-anzeigen-controller.php";
/** @var Beitrag $beitrag
 * @var bool $eigentuemer
 * @var bool $admin
 */

require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Beitrag</title>
<link rel="stylesheet" type="text/css" href="./assets/css/beitrag.css">


<!-- Einbindung von leaflet-->
<?php
require_once $abs_path . "/php/include/leaflet.php";
?>


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

        <h1><?= htmlspecialchars($beitrag->getTitle()) ?></h1>
        <div class="content-container">
            <div class="details-image">
                <h2>Bild:</h2>
                <!--Foto bisher aus dem Internet kopiert, Quelle: https://de.m.wiktionary.org/wiki/Datei:Eber-Skulptur_am_Eingang_des_Eversten_Holzes_im_Oldenburg-Eversten_-_DSCF1057.JPG.
            todo: gegen eigene Bilder austauschen.-->
                <img src="<?= htmlspecialchars($beitrag->getPicture()) ?>"
                     alt="<?= htmlspecialchars($beitrag->getTitle()) ?>">
            </div>
            <!--Der Ort wird später noch durch die Einbindung von OpenStreetMap angepinnt-->

            <div class="details-description">
                <h2>Beschreibung:</h2>
                <div class="info-box">
                    <!--todo: Zeilenumbrüche einbauen!-->
                    <p><?= htmlspecialchars($beitrag->getDescription()) ?></p>
                </div>
            </div>


            <div class="details-location">
                <h2>Ort:</h2>

                <noscript>
                    <div class="info-box">
                        <p><?= htmlspecialchars($beitrag->getLocation()) ?></p>
                    </div>
                </noscript>

                <div class="sculpture-location">
                    <div id="map"></div>
                </div>
            </div>

        </div>

        <div class="buttons">
            <?php if ($admin && $admin != $eigentuemer) : ?>
                <form action="php/controller/beitrag-bearbeiten-controller.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($beitrag->getId()) ?>">
                    <input type="hidden" name="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf-token']) ?>">
                    <input type="hidden" name="title" value="<?= htmlspecialchars($beitrag->getTitle()) ?>">
                    <input type="hidden" name="description" value="<?= htmlspecialchars($beitrag->getDescription()) ?>">
                    <input type="hidden" name="location" value="<?= htmlspecialchars($beitrag->getLocation()) ?>">
                    <input type="submit" name="submit" value="Beitrag übernehmen" class="submit-button">
                </form>
            <?php endif;

            if ($eigentuemer) : ?>
                <div class="button">
                    <a href="beitrag-bearbeiten.php?id=<?= urlencode($beitrag->getId()) ?>">Beitrag bearbeiten</a>
                </div>
                <form action="php/controller/beitrag-loeschen-controller.php" method="post">
                    <input type="hidden" name="id" value="<?= htmlspecialchars($beitrag->getId()) ?>">
                    <input type="hidden" name="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf-token']) ?>">
                    <input type="submit" name="submit" value="Beitrag löschen" class="submit-button">
                </form>
            <?php else: ?>
                <div class="button">
                    <a href="mailto:admin@ol-skulpturen.de?subject=Beitrag%20melden&body=Bitte%20Titel%20angeben:%0D%0A%0D%0AWas%20soll%20geändert%20werden?">Beitrag
                        melden</a>
                </div>
            <?php endif; ?>
        </div>

    </section>
</main>

<!-- JavaScript zur Ausgabe der Standort-Pins auf der Karte-->
<script>
    let beitrag = <?php echo json_encode($beitrag->toArray()); ?>
    // Leaflet-Karte initialisieren
    var map = L.map('map').setView([beitrag.lat, beitrag.lng], 16);

    // Tile-Layer für die Karte hinzufügen (OpenStreetMap)
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    const marker = L.marker([beitrag.lat, beitrag.lng]).bindPopup('<b>' + beitrag.location + '</b>').addTo(map).openPopup();
</script>

<!-- JavaScript Bestätigung vor dem Löschen eines Beitrags-->
<script>
    document.querySelector('form[action="php/controller/beitrag-loeschen-controller.php"]').addEventListener('submit', function (e) {
        if (!confirm('Möchten Sie diesen Beitrag wirklich löschen?')) {
            e.preventDefault();
        }
    });
</script>

<?php
require_once $abs_path . "/php/include/footer.php";
?>

</body>

</html>