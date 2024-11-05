<?php

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/index-controller.php";

if (!isset($_SESSION["account_id"])) {
    $_SESSION["message"] = "missing_permission";
    header("Location: index.php");
    exit;
}


$title = $_SESSION["title"] ?? "";
$description = $_SESSION["description"] ?? "";
$location = $_SESSION["location"] ?? "";
unset($_SESSION["title"]);
unset($_SESSION["description"]);
unset($_SESSION["location"]);

require_once $abs_path . "/php/include/head.php";
?>

<title>Oldenburger Skulpturen - Neuer Beitrag</title>
<link rel="stylesheet" type="text/css" href="./assets/css/beitrag-neu.css">

<!-- Einbindung von leaflet-->
<?php
require_once $abs_path . "/php/include/leaflet.php";
?>
<script src="assets/js/karte.js"></script>

<!-- Einbindung eines Vorschaubildes-->
<script src="./assets/js/bildvorschau.js"></script>

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

        <h1>Neuer Beitrag</h1>

        <div class="form-container">
            <form method="post" enctype="multipart/form-data" action="php/controller/beitrag-neu-controller.php">

                <div class="form-inputs">
                    <label for="title">Titel:</label>
                    <input type="text" id="title" name="title" placeholder="Geben Sie einen Titel ein"
                           value="<?= htmlspecialchars($title) ?>" required>
                    <label for="picture">Bild hochladen:</label>
                    <input type="file" id="picture" name="picture" class="button" accept="image/*" multiple
                           onChange="fileThumbnail(this.files);" required>
                    <div>
                        <span>Bildvorschau:</span>
                        <div id="thumbnail"></div>
                    </div>
                    <label for="description">Kurzbeschreibung:</label>
                    <textarea id="description" name="description"
                              required><?= htmlspecialchars($description) ?></textarea>
                    <label for="location">Ort:</label>
                    <input type="text" id="location" name="location"
                           value="<?= htmlspecialchars($location) ?>"
                           placeholder="Bitte den Standort eingeben oder auf der Karte auswählen" required>
                    <div id="map" style="height: 400px;"></div>

                    <label for="copyright">
                        <input type="checkbox" id="copyright" name="copyright" required>
                        Hiermit bestätige ich, dass ich das Foto veröffentlichen darf.
                    </label>
                    <input type="hidden" name="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf-token']) ?>"/>
                    <input type="submit" id="submit" name="submit" class="button" value="Erstellen">
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    var map = initMap(53.143450, 8.214552, 12);

    const popup = L.popup();
    const locationInput = document.getElementById('location');

    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        reverseGeocode(lat, lng, popup, locationInput);
    });
</script>


<?php
require_once $abs_path . "/php/include/footer.php";
?>

</body>

</html>
