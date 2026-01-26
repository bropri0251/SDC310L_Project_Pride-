<?php
require_once __DIR__ . "/DatabaseModel.php";

class CartModel
{
    private static function GetSessionId()
    {
        return session_id();
    }

    public static function GetQtyInCart($productId)
    {
        $pdo = DatabaseModel::GetPDO();
        $sessionId = self::GetSessionId();

        $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE session_id = ? AND product_id = ?");
        $stmt->execute(array($sessionId, $productId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return intval($row["quantity"]);
        }
        return 0;
    }

    public static function SetCartQty($productId, $qty)
    {
        $pdo = DatabaseModel::GetPDO();
        $sessionId = self::GetSessionId();

        if ($qty < 0) {
            $qty = 0;
        }

        // Check if row exists
        $stmt = $pdo->prepare("SELECT cart_id FROM cart_items WHERE session_id = ? AND product_id = ?");
        $stmt->execute(array($sessionId, $productId));
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($qty === 0) {
            // DELETE
            $del = $pdo->prepare("DELETE FROM cart_items WHERE session_id = ? AND product_id = ?");
            $del->execute(array($sessionId, $productId));
            return;
        }

        if ($row) {
            // UPDATE
            $upd = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE session_id = ? AND product_id = ?");
            $upd->execute(array($qty, $sessionId, $productId));
        } else {
            // INSERT
            $ins = $pdo->prepare("INSERT INTO cart_items (product_id, quantity, session_id) VALUES (?, ?, ?)");
            $ins->execute(array($productId, $qty, $sessionId));
        }
    }

    public static function GetCartItems()
    {
        $pdo = DatabaseModel::GetPDO();
        $sessionId = self::GetSessionId();

        $stmt = $pdo->prepare("
            SELECT c.product_id, c.quantity, p.name, p.price
            FROM cart_items c
            INNER JOIN products p ON c.product_id = p.product_id
            WHERE c.session_id = ?
            ORDER BY c.product_id
        ");
        $stmt->execute(array($sessionId));
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function ClearCart()
    {
        $pdo = DatabaseModel::GetPDO();
        $sessionId = self::GetSessionId();

        $del = $pdo->prepare("DELETE FROM cart_items WHERE session_id = ?");
        $del->execute(array($sessionId));
    }

    public static function CalculateTotals($rows)
    {
        $itemsCount = 0;
        $preTaxTotal = 0.0;
        $tax = 0.0;
        $shipping = 0.0;
        $orderTotal = 0.0;

        foreach ($rows as $r) {
            $qty = intval($r["quantity"]);
            $price = floatval($r["price"]);

            $itemsCount += $qty;
            $preTaxTotal += ($price * $qty);
        }

        $tax = $preTaxTotal * 0.05;
        $shipping = $preTaxTotal * 0.10;
        $orderTotal = $preTaxTotal + $tax + $shipping;

        return array(
            'itemsCount' => $itemsCount,
            'preTaxTotal' => $preTaxTotal,
            'tax' => $tax,
            'shipping' => $shipping,
            'orderTotal' => $orderTotal
        );
    }
}
?>