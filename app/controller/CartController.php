<?php
require_once __DIR__ . "/../model/CartModel.php";

class CartController
{
    public static function Run()
    {
        session_start();

        // Handle POST actions
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $action = isset($_POST["action"]) ? $_POST["action"] : "";

            if ($action === "checkout") {
                CartModel::ClearCart();
                header("Location: index.php?page=catalog");
                exit;
            }
        }

        // Get data for view
        $cartItems = CartModel::GetCartItems();
        $totals = CartModel::CalculateTotals($cartItems);

        // Include view
        require __DIR__ . "/../view/cart.php";
    }
}
?>
