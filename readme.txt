Anmeldedaten der dummy-user:
user: "admin@ol-skulpturen.de", pw: "admin"
user: "firstUser@mail.de", pw: "geheim" (gilt auch für die anderen dummy-user)

Informationen zur Endabgabe:

Eingebaute Funktionen:
    * Startseite: Weitere Beiträge laden (JS)
    * Einbindung von OpenStreetMap: Standort der Skulptur bzw. aller Skulpturen (Beitrag anzeigen / Karte),
        Standorte per Eingabe oder Mouseklick in Karte (Beitrag neu / bearbeiten)
    * Vorschaubild beim Upload (Beitrag neu / bearbeiten)

Sitemap:
    * Startseite (index)
    * Karte
    * Nutzerliste
    * Anmelden / Abmelden
    * Registrieren
    * Beitrag-neu
    * Beitrag-anzeigen
    * Beitrag-bearbeiten
    * Impressum
    * Datenschutz
    * Nutzungsbedingungen

Bekannte Fehler:
    * Wave Kontrast fehler auf Beitrag anzeigen oder Karte, das Popup hat lt Wave einen niedrigen Kontrast.
    * Beiträge können vom Admin nur übernommen, jedoch nicht zurückgegeben werden
    * Ob ein User einen Beitrag ändern darf, wird im Controller gecheckt, jedoch nicht mehr in der
        SammlungPDOSQLite. Dies war nötig, damit der Admin auch ändern / übernehmen kann.
    * Falls die Datei für den Aktivierungscode nicht erstellt wird, prüf bitte, ob der Ordner "verify"
            im Verzeichnis "php/controller/" liegt.
    * Registrierungs-Datei wird nicht gelöscht, wenn man bereits einen aktivierten Account hat
    * Beim Laden weiterer Beiträge verschwindet der Button nicht, wenn eine durch 3 teilbare
        Gesamtanzahl (Limit aktuell 3) von Beiträgen besteht
    * PW-ändern-Prozess wurde gemäß Aufgabenstellung nicht mit extra Nachricht implementiert


********************************

Informationen zu Abgabe 6:
- API: Leaflet / Nominatim zur Einbindung von OpenStreetMap (siehe Infos Abgabe 5)
- Cookies von FreePrivacyPolicy.com erstellt
- Datenschutz und Impressum mit www.e-Recht24.de erstellt
- Nutzungsbedingungen mit www.jurarat.de ertellt.
- Registrierungsprozess mit Besätitungsnachricht und Aktivierungscode

*********************************

Information zu Abgabe 5:
Implentierte Funktionen:
- Kartenfunktionen Leaflet / Nominatim (Vorgriff auf Abgabe 6):
    - Übersichtskarte zeigt alle Standorte der Skulpturen durch Marker auf einer openstreetmaps-Karte
    - Beiträge zeigen den Standort der Skulptur an
    - Beitrag neu / bearbeiten: User setzen den Standort durch Eingabe oder Klick auf die Karte

- Beiträge / Nutzer löschen:
    - Es wird eine Bestätigung angefordert, wenn man einen Beitrag (beitrag-anzeigen.php) oder Nutzer (nutzerliste.php) gelöscht werden soll
    - todo: automatische Blockierung Nutzer mit Beiträgen zu löschen (in PDO und JS einbauen!)

- Bildvorschau:
   - Beitrag neu / bearbeiten: es wird ein Vorschaubild des neu hochzuladen Bildes angezeigt.

- Weitere Beiträge laden (Fetch-API):
    - durch Click auf entsprechenden Button auf der Startseite werden jeweils 3 neue Beiträge geladen.
    - todo: Button verschwindet nicht, wenn es #beitraege mod limit = 0 Beiträge gibt.

- Responsive Nav-Leiste mit Burger-Menu


Behandelte Anmerkungen von Abgabe 4:
Neuer Account. Wenn ich dann versuche, einen meiner eingestellten Beiträge zu bearbeiten, erhalte ich die Meldung: "Sie haben keine Berechtigung, wenden Sie sich an den Admin!" (als Admin klappt es)
 - erledigt
updateBeitrag in SammlungPDOSQLite: es findet keine Überprüfung statt, ob der Beitrag auch von dem angegebenen Nutzer erstellt wurde
 - erledigt
unschön ist, dass ich beim Bearbeiten eines Beitrags immer unbedingt ein neues Bild angeben muss (siehe unten!)
 - erledigt

*********************************************

Information zu Abgabe 4:
Anmeldedaten der dummy-user:
user: "admin@mail.de", pw: "admin"
user: "firstUser@mail.de", pw: "geheim" (gilt auch für die anderen dummy-user)

Beiträge können erstellt und vom Ersteller geändert bzw. gelöscht werden
- todo: neue Funktion, um Beiträge durch Admin auf den Admin-Account umzuhängen
- todo: beitrag-bearbeiten.php: image stylen und z.Zt. erforderlichen erneuten Upload des Bildes abstellen
- todo: beitrag-anzeigen.php: Buttons neu stylen

Accounts können erstellt und durch Admin gelöscht werden, Passwörter können geändert werden
- todo: Prozess für vergessene Passwörter implementieren (z.B. Mail an User mit neuem Passwort?!)
- todo: verhindern, dass der Admin sein eigenes Konto löschen kann (JulianHaase4/php/controller/nutzer-loeschen-controller.php?id=1)

Weitere todos:
- todo: Prüfen, ob alle Fehlermeldungen auf den angezeigten Seiten ausgeben werden können
- todo: Fehlermeldungen stylen
- todo: Überprüfung Admin durch boolesche Variable in Sessions ersetzen

*********************************************

Informationen zu Abgabe 3:
Da ich gerade im Urlaub bin, konnte ich nur eingeschränkt die Aufgaben bearbeiten. Dieses wird in den kommenden Wochen nachgeholt.
Bei dieser Abgabe auch noch keine Prüfung (WAVE, HTML-Validator, etc...)

- responsives Verhalten hergestellt, es fehlte die meta viewport Angabe im head in Abgabe 2
- php Grundstruktur für Beiträge und Accounts, einige Funktionen können mit der Fix-Umsetzung noch nicht implementiert werden:
    Beiträge:
    - Beiträge können erstellt werden, jedoch noch keine Speicherung in der Sammlung
    - hochgeladene Bilder müssen noch an die richtige Stelle verschoben werden, bisher nur im tmp gespeichert
    - Beiträge der Sammlung werden bei Aufruf der Startseite angezeigt, wenn Sammlung gefüllt, sollen initial 10-12
      Beiträge geladen werden, durch Button "weitere laden" sollen die nächsten 10-12 Beiträge folgen, usw. (Umsetzung folgt)
    - delete und update noch nicht implementiert
    Accounts:
    - Accounts können erstellt werden
    - Session Umsetzung für angemeldete User noch nicht vollständig
    - Nutzerliste (zur Zeit Aufruf nur über */nutzerliste.php) zeigt alle Accounts an, sowie deren zugehörige Beiträge.
    - todo: Nutzerliste Zugang nur für Admin
      erledigt
    - todo: Ggfs. UserName für Anmeldung benutzen (email-Adresse aus Datenschutzgründen unzulässig?!), oder Verfasser aus Beitrag anzeigen entfernen
      weiter prüfen!
    - todo: nutzer-loeschen-controller.php -
      erledigt
    - todo: crsf-token richtig verwenden -
      erledigt

Weitere todos:
- todo: Fehlerbehandlung überprüfen bzw. überarbeiten, Fehlermeldung auf Seite ausgeben (css dafür stylen) -
  teilweise erledigt
- todo: Sessionübergabe des angemeldeten Users -> Seitendarstellung anpassen (z.B. Navbar, Funktionen wie Beitrag erstellen / ändern,...)
  erledigt

*********************************************

Informationen zu Abgabe 2:
- CSS-Layout erstellt
- Responsives Verhalten für Auflösungen mit einer breite von +300px implementiert
- Hinweis: bei mir funktionierte das responsive Verhalten innerhalb des Entwicklertools von Chrome nicht vernünftig.
    Wenn ich das "responsive"-Symbol aktiviert habe, wurde die Seite beim Verkleinern der Abmessungen nur kleiner "herausgezoomt".
    Wenn ich außerhalb der Funktion in den Entwicklertools die größe durch Verschieben der Trennlinie verkleinert habe (Abmessungen wurden angezeigt),
    hat die Seite richtig responsiv reagiert. (Hast du einen Tipp für mich, was ich falsch eingestellt haben könnte?)
- Seiten mit w3c (HTML und CSS) Validator und WAVE geprüft: keine Fehler
- Da ich zur Zeit nicht in Oldenburg bin, kann ich die Bilder nicht gegen eigene tauschen. Das wird erst ab Abgabe 4 der Fall sein.

*********************************************

Informationen zu Abgabe 1:
- HTML-Grundstruktur erstellt
- Teilweise schon Container mit Klassen für späteres CSS-Layout angegeben
- Bilder müssen noch gegen eigene getauscht werden (sonst ggfs. Copyright Probleme)
- WAVE geprüft, keine Fehler, nur Hinweise zu Redundanzen, da bisher nur ein Beitrag erstellt und zu Testzwecken mehrfach angezeigt wurde
- Die Angabe von Weblinks (Attribut "Artikel" im ER-Diagramm im Planungsdokument) fliegt ggfs. noch raus