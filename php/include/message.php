<?php if (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_entry_id"): ?>
    <p>
        Der angegebene Skulpturenbeitrag kann leider nicht gefunden werden.
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "internal_error"): ?>
    <p>
        Es ist ein interner Fehler aufgetreten.
        Bitte versuchen Sie es erneut oder kontaktieren Sie den Administrator.
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_parameters"): ?>
    <p>
        Fehler beim Aufruf der Seite: Es fehlen notwendige Parameter!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "new_entry"): ?>
    <p>
        Neuer Eintrag wurde hinzugefügt!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "update_entry"): ?>
    <p>
        Eintrag wurde aktualisiert!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "delete_entry"): ?>
    <p>
        Eintrag wurde gelöscht!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "update_password"): ?>
    <p>
        Das Passwort wurde aktualisiert!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "missing_permission"): ?>
    <p>
        Sie haben keine Berechtigung, wenden Sie sich an den Admin!
    </p>

<?php elseif (isset($_SESSION["message"]) &&
    ($_SESSION["message"] == "missing_login_parameters" || $_SESSION["message"] == "missing_required_login_parameters")): ?>
    <p>
        Bitte alle erforderlichen Daten (Username, Password) eingeben!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "invalid_credentials"): ?>
    <p>
        Eingabedaten sind nicht korrekt. Bitte versuchen Sie es erneut.
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "account_not_found"): ?>
    <p>
        Eingabedaten sind nicht korrekt. Bitte versuchen Sie es erneut.
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "missing_csrf_token"): ?>
    <p>
        Fehlendes CSRF-Token!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "invalid_csrf_token"): ?>
    <p>
        Ungültiges CSRF-Token!
    </p>
<?php elseif (isset($_SESSION["message"]) &&
    ($_SESSION["message"] === "missing_required_entry_parameters" || $_SESSION["message"] === "missing_parameters")): ?>
    <p>
        Bitte alle erforderlichen Daten (Titel, Beschreibung, Standort) eingeben!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "unknown_error"): ?>
    <p>
        Ein unbekannter Fehler ist aufgetreten!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "wrong_type"): ?>
    <p>
        Unerlaubter Dateityp. Die Datei muss ein Bild sein (jpg, gif, png, jpeg)!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "failed_upload"): ?>
    <p>
        Ein unerwarteter Fehler ist aufgetreten. Bitte erneut versuchen oder den Admin kontaktieren!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "blocked_entry"): ?>
    <p>
        Admin-Accounts können nicht gelöscht werden!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "password_mismatch"): ?>
    <p>
        Die Passwörter stimmen nicht überein!
    </p>
<?php elseif (isset($_SESSION["message"]) &&
    ($_SESSION["message"] == "missing_required_register_parameters" || $_SESSION["message"] == "missing_register_parameters")) : ?>
    <p>
        Bitte alle erforderlichen Daten (E-Mail-Adresse, Password, Passwort wiederholen) eingeben!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "wrong_email"): ?>
    <p>
        Bitte eine gültige E-Mail-Adresse eingeben!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "email_already_exists"): ?>
    <p>
        Die von Ihnen eingegebenen Anmeldedaten konnten nicht verarbeitet werden. Bitte überprüfen Sie Ihre
        Eingaben und versuchen Sie es erneut.
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] === "missing_checkbox"): ?>
    <p>
        Um sich zu registrieren, müssen Sie die Allgemeinen Geschäftsbedingungen akzeptieren!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] = "account_not_activated"): ?>
    <p>
        Das Nutzerkonto ist nicht aktiviert!
    </p>
<?php elseif (isset($_SESSION["message"]) && $_SESSION["message"] == "new_account"): ?>
    <p>
        Konto erfolgreich hinzugefügt, bitte bestätigen Sie Ihre E-Mail-Adresse!
    </p>
<?php endif;
unset($_SESSION["message"]);
?>
