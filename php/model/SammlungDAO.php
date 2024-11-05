<?php

interface SammlungDAO
{
    /*
     * Einfügen eines neuen Beitrags mit Verfasser-E-Mail-Adresse, Titel, Bild, Text und Ort
     * return: die ID des neuen Eintrags
     * mögliche Exceptions:
     * InternerFehlerException, wenn es einen internen Fehler gibt (z.B. beim Zugriff auf eine Datenbank)
     */
    public function createBeitrag(int $creator_id, string $title, string $picture, string $description, string $location, string $lat, string $lng);

    /*
     * ermitteln und liefern des Eintrags mit der angegebenen ID
     * return: Objekt der Klasse Beitrag
     * mögliche Exceptions:
     * FehlenderBeitragException, wenn es keinen Beitrag mit der angegebenen ID gibt
     * InternerFehlerException, wenn es einen internen Fehler gibt (z.B. beim Zugriff auf eine Datenbank)
     */
    public function readBeitrag(int $id);

    public function updateBeitrag(int $id, int $creator_id, string $title, string $picture, string $description, string $location, string $lat , string $lng): void;

    /*
     * löschen des Beitrags mit der angegebenen ID
     * return: void
     * mögliche Exceptions:
     * FehlenderBeitragException, wenn es keinen Beitrag mit der angegebenen ID gibt
     * InternerFehlerException, wenn es einen internen Fehler gibt (z.B. beim Zugriff auf eine Datenbank)
     */
    public function deleteBeitrag(int $id, int $creator_id): void;

    /*
     * ermitteln und liefern aller Beiträge
     * return: Array mit Objekten der Klasse Beitrag; kann auch leer sein
     * mögliche Exceptions:
     * InternerFehlerException, wenn es einen internen Fehler gibt (z.B. beim Zugriff auf eine Datenbank)
     */
    public function readAllBeitraege(): array;
}