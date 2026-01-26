<?php
require_once __DIR__ . "/../model/ProductModel.php";
require_once __DIR__ . "/../model/CartModel.php";

class CatalogController
{
    public static function Run()
    {
        session_start();

        // Handle POST actions
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = isset($_POST["action"]) ? $_POST["action"] : "";
            $productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;

            $products = ProductModel::GetProducts();
            if ($productId > 0 && isset($products[$productId])) {
                $currentQty = CartModel::GetQtyInCart($productId);

                if ($action === "add" || $action === "inc") {
                    $currentQty = $currentQty + 1;
                } elseif ($action === "dec") {
                    $currentQty = $currentQty - 1;
                } elseif ($action === "remove") {
                    $currentQty = 0;
                } elseif ($action === "set") {
                    $newQty = isset($_POST["qty"]) ? intval($_POST["qty"]) : 0;
                    $currentQty = $newQty;
                }

                // limit to 0 or more + write to DB
                if ($currentQty < 0) {
                    $currentQty = 0;
                }
                CartModel::SetCartQty($productId, $currentQty);
            }

            header("Location: index.php?page=catalog");
            exit;
        }

        // Get data for view
        $products = ProductModel::GetProducts();
        $cartQtys = array();
        foreach ($products as $p) {
            $cartQtys[$p["id"]] = CartModel::GetQtyInCart($p["id"]);
        }

        // Include view
        require __DIR__ . "/../view/catalog.php";
    }
}
?>
