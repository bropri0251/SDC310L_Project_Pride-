<?php
require_once __DIR__ . "/../../db.php";

class DatabaseModel
{
    public static function GetPDO()
    {
        global $pdo;
        return $pdo;
    }
}
?>
