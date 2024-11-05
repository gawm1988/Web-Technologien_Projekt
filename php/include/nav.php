<!--Banner erstellt unter Verwendung von Pictogrammen von Microsoft (Office)-->
<img src="assets/media/banner.png" alt="Banner">
<nav>
    <div class="menu-toggle" id="mobile-menu">
        <span class="menu-icon">&#9776;</span> <!-- Hamburger-Icon -->
    </div>
    <div class="nav-items" id="nav-items">
        <div class="nav-item">
            <a href="index.php">Startseite</a>
        </div>
        <div class="nav-item">
            <a href="karte.php">Karte</a>
        </div>
        <?php if (isset($_SESSION["account_id"]) && $_SESSION["account_id"] === 1): ?>
            <div class="nav-item">
                <a href="nutzerliste.php">Nutzerliste</a>
            </div>
        <?php endif; ?>
        <?php if (isset($_SESSION["account_id"])): ?>
            <div class="nav-item">
                <a href="php/controller/abmelden-controller.php?csrf-token=<?= urlencode($_SESSION['csrf-token']) ?>">Abmelden</a>
            </div>
            <div class="nav-item">
                <a href="passwort-aendern.php">Passwort ändern</a>
            </div>
            <?php if ($_SESSION["account_id"] !== 1) : ?>
                <div class="nav-item">
                    <a href="mailto:admin@ol-skulpturen.de?subject=Konto%20löschen%20User%20user@mail.de&body=Beiträge%20anonym%20bestehen%20lassen?%0D%0A%0D%0Anein%0D%0A%0D%0Aja%0D%0A%0D%0A%0D%0A%0D%0A---Unzutreffendes%20bitte%20löschen---">Konto
                        löschen</a>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="nav-item">
                <a href="anmeldung.php">Anmelden</a>
            </div>
            <div class="nav-item">
                <a href="registrierung.php">Registrieren</a>
            </div>
        <?php endif; ?>
    </div>

    <noscript>
        <div class="nav-items-noscript" id="nav-items-noscript">
            <div class="nav-item">
                <a href="index.php">Startseite</a>
            </div>
            <div class="nav-item">
                <a href="karte.php">Karte</a>
            </div>
            <?php if (isset($_SESSION["account_id"]) && $_SESSION["account_id"] === 1): ?>
                <div class="nav-item">
                    <a href="nutzerliste.php">Nutzerliste</a>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION["account_id"])): ?>
                <div class="nav-item">
                    <a href="php/controller/abmelden-controller.php?csrf-token=<?= urlencode($_SESSION['csrf-token']) ?>">Abmelden</a>
                </div>
                <div class="nav-item">
                    <a href="passwort-aendern.php">Passwort ändern</a>
                </div>
                <div class="nav-item">
                    <a href="mailto:admin@ol-skulpturen.de?subject=Konto%20löschen%20User%20user@mail.de&body=Beiträge%20anonym%20bestehen%20lassen?%0D%0A%0D%0Anein%0D%0A%0D%0Aja%0D%0A%0D%0A%0D%0A%0D%0A---Unzutreffendes%20bitte%20löschen---">Konto
                        löschen</a>
                </div>
            <?php else: ?>
                <div class="nav-item">
                    <a href="anmeldung.php">Anmelden</a>
                </div>
                <div class="nav-item">
                    <a href="registrierung.php">Registrieren</a>
                </div>
            <?php endif; ?>
        </div>
    </noscript>


</nav>

<script>
    document.getElementById('mobile-menu').addEventListener('click', function () {
        var navItems = document.getElementById('nav-items');
        if (navItems.classList.contains('show')) {
            navItems.classList.remove('show');
        } else {
            navItems.classList.add('show');
        }
    });
</script>