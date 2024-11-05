<?php
if (!isset($abs_path)) {
    require_once "path.php";
}
require_once $abs_path . "/php/controller/index-controller.php";
/* @var Sammlung $beitraege */

$beitraegeArray = [];
foreach ($beitraege as $beitrag) {
    $beitraegeArray[] = $beitrag->toArray();
}
?>

<?php
require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Karte</title>
<link rel="stylesheet" type="text/css" href="./assets/css/karte.css">

<!-- Einbindung von leaflet-->
<?php
require_once $abs_path . "/php/include/leaflet.php";
?>
<script src="assets/js/karte.js"></script>
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

        <h1>Karte</h1>

        <noscript>
            <div class="buttons">
                <div class="button"><a href="index.php?load_all=true">Alle Beiträge anzeigen</a></div>
            </div>
        </noscript>

        <div id="map" style="height: 400px;"></div>


    </section>

</main>

<!-- JavaScript zur Ausgabe der Standort-Pins auf der Karte-->
<script>
    // Karte initialisieren
    var map = initMap(53.143450, 8.214552, 12);

    // JSON-Daten (id, title, location, lat, lng) vom PHP-Backend
    let beitraege = <?php echo json_encode($beitraegeArray); ?>;

    // Marker für die Beiträge auf der Karte hinzufügen
    addMarkersToMap(map, beitraege);
</script>

<?php
require_once $abs_path . "/php/include/footer.php";
?>

</body>

</html>
