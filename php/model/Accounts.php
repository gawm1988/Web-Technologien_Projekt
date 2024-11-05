<?php

require_once "AccountsPDOSQLite.php";

class Accounts
{
    public static function getInstance(): AccountsDAO
    {
        return AccountsPDOSQLite::getInstance();
    }
}