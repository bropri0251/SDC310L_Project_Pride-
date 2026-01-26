<?php
require_once __DIR__ . "/../models/DatabaseModel.php";
require_once __DIR__ . "/../../products.php";

class CatalogController
{
    public static function Run()
    {
        session_start();
        require __DIR__ . "/../../catalog.php";
    }
}
?>
