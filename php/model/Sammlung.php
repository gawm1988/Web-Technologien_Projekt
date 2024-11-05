<?php
require_once "SammlungPDOSQLite.php";

class Sammlung
{
    public static function getInstance(): SammlungDAO
    {
        return SammlungPDOSQLite::getInstance();
    }
}