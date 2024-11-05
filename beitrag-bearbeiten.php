<?php

if (!isset($abs_path)) {
    require_once "path.php";
}

require_once $abs_path . "/php/controller/beitrag-anzeigen-controller.php";
/** @var Beitrag $beitrag
 * @var bool $eigentuemer
 * @var bool $admin
 */

if (!$eigentuemer) {
    if (!$admin) {
        $_SESSION["message"] = "missing_permission";
        header("Location: index.php");
        exit;
    }
}

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

        <h1>Beitrag bearbeiten</h1>

        <div class="form-container">
            <form method="post" enctype="multipart/form-data" action="php/controller/beitrag-bearbeiten-controller.php">

                <div class="form-inputs">
                    <label for="title">Titel:</label>
                    <input type="text" id="title" name="title" placeholder="Geben Sie einen Titel ein"
                           value="<?= htmlspecialchars($beitrag->getTitle()) ?>" required>
                    <label for="picture">Neues Bild hochladen:</label>

                    <!--todo: css für Bild anpassen-->
                    <img src="<?= htmlspecialchars($beitrag->getPicture()) ?>"
                         alt="<?= htmlspecialchars($beitrag->getTitle()) ?>">
                    <label for="upload-new-picture">
                        <input type="checkbox" id="upload-new-picture" name="upload-new-picture">
                        Neues Bild hochladen
                    </label>
                    <div id="picture-upload-container" style="display: none">
                        <input type="file" id="picture" name="picture" class="button" accept="image/*" multiple
                               onChange="fileThumbnail(this.files);">
                        <div>
                            <span>Bildvorschau:</span>
                            <div id="thumbnail"></div>
                        </div>
                        <label for="copyright">
                            <input type="checkbox" id="copyright" name="copyright">
                            Hiermit bestätige ich, dass ich das Foto veröffentlichen darf.
                        </label>
                    </div>

                    <label for="description">Kurzbeschreibung:</label>
                    <textarea id="description" name="description"
                              required><?= htmlspecialchars($beitrag->getDescription()) ?></textarea>
                    <label for="location">Ort:</label>
                    <input type="text" id="location" name="location"
                           placeholder="Bitte den Standort eingeben oder auf der Karte auswählen"
                           value="<?= htmlspecialchars($beitrag->getLocation()) ?>" required>
                    <div id="map" style="height: 400px;"></div>

                    <input type="hidden" name="csrf-token" value="<?= htmlspecialchars($_SESSION['csrf-token']) ?>"/>
                    <input type="hidden" name="id" value="<?= htmlspecialchars($beitrag->getId()) ?>">
                    <input type="submit" id="submit" name="submit" class="button" value="Aktualisieren">
                </div>
            </form>
        </div>
    </section>
</main>

<script>
    let beitrag = <?php echo json_encode($beitrag->toArray()); ?>
    // Leaflet-Karte initialisieren
    var map = initMap(beitrag.lat, beitrag.lng, 16);
    const marker = L.marker([beitrag.lat, beitrag.lng]).addTo(map);

    const popup = L.popup();
    const locationInput = document.getElementById('location');

    map.on('click', function (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        reverseGeocode(lat, lng, popup, locationInput);
        popup.openOn(map)
    });
</script>

<script>
    document.getElementById('upload-new-picture').addEventListener('change', function () {
        var uploadContainer = document.getElementById('picture-upload-container');
        var copyrightCheckbox = document.getElementById('copyright');
        if (this.checked) {
            uploadContainer.style.display = 'block';  // Zeige den Upload-Container
            copyrightCheckbox.setAttribute('required', 'required');  // Copyright required machen
        } else {
            uploadContainer.style.display = 'none';  // Verstecke den Upload-Container
            copyrightCheckbox.removeAttribute('required');  // Copyright optional machen
        }
    });

</script>

<?php
require_once $abs_path . "/php/include/footer.php";
?>

</body>

</html>
