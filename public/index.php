<?php
$page = isset($_GET["page"]) ? $_GET["page"] : "catalog";

require_once __DIR__ . "/../app/controller/CatalogController.php";
require_once __DIR__ . "/../app/controller/CartController.php";

if ($page === "cart") {
    CartController::Run();
} else {
    CatalogController::Run();
}
