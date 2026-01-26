<?php
require_once __DIR__ . "/../models/DatabaseModel.php";

class CartController
{
    public static function Run()
    {
        session_start();
        require __DIR__ . "/../../cart.php";
    }
}
?>
