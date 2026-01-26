<?php
require_once __DIR__ . "/DatabaseModel.php";

class ProductModel
{
    public static function GetProducts()
    {
        $pdo = DatabaseModel::GetPDO();
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
}
?>