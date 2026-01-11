<?php
require_once "db.php";

function GetProducts()
{
    global $pdo;

    $stmt = $pdo->query("SELECT product_id, name, description, price FROM products ORDER BY product_id");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $products = array();

    foreach ($rows as $r) {
        $id = intval($r["product_id"]);
        $products[$id] = array(
            "id" => $id,
            "name" => $r["name"],
            "description" => $r["description"],
            "cost" => floatval($r["price"])
        );
    }

    return $products;
}
?>
