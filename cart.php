<?php
session_start();
require_once "products.php";

$products = GetProducts();

if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array();
}

// Handle checkout: clear cart, return to catalog
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    if ($action === "checkout") {
        $_SESSION["cart"] = array();
        header("Location: catalog.php");
        exit;
    }
}

// Build cart rows
$cart = $_SESSION["cart"];
$items = array(); // each: id, name, qty, cost, total
$itemsCount = 0;
$preTaxTotal = 0.0;

foreach ($cart as $productId => $qty) {
    $pid = intval($productId);
    $q = intval($qty);

    if ($q >= 1 && isset($products[$pid])) {
        $cost = floatval($products[$pid]["cost"]);
        $lineTotal = $cost * $q;

        $items[] = array(
            "id" => $pid,
            "name" => $products[$pid]["name"],
            "qty" => $q,
            "cost" => $cost,
            "total" => $lineTotal
        );

        $itemsCount += $q;
        $preTaxTotal += $lineTotal;
    }
}

// Totals per requirements
$tax = $preTaxTotal * 0.05;           // 5% tax
$shipping = $preTaxTotal * 0.10;      // 10% shipping & handling
$orderTotal = $preTaxTotal + $tax + $shipping;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Cart</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 18px; }
        table { border-collapse: collapse; width: 100%; margin-bottom: 16px; }
        th, td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
        th { background: #f3f3f3; text-align: left; }
        .nav { margin-bottom: 14px; }
        .nav a { margin-right: 10px; }
        .totals { max-width: 420px; border: 1px solid #ccc; padding: 12px; }
        .row { display: flex; justify-content: space-between; padding: 4px 0; }
        .actions { margin-top: 12px; }
    </style>
</head>
<body>

<div class="nav">
    <a href="catalog.php">Continue Shopping (Catalog)</a>
    <a href="cart.php">Cart</a>
</div>

<h2>Shopping Cart</h2>

<?php if (count($items) === 0): ?>
    <p>Your cart is empty.</p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Product ID</th>
                <th>Product Name</th>
                <th>Quantity Ordered</th>
                <th>Product Cost (Individual)</th>
                <th>Product Total</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $it): ?>
            <tr>
                <td><?php echo $it["id"]; ?></td>
                <td><?php echo htmlspecialchars($it["name"]); ?></td>
                <td><?php echo $it["qty"]; ?></td>
                <td>$<?php echo number_format($it["cost"], 2); ?></td>
                <td>$<?php echo number_format($it["total"], 2); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <div class="totals">
        <div class="row"><strong>Total items ordered</strong><span><?php echo $itemsCount; ?></span></div>
        <div class="row"><strong>Pre-tax total</strong><span>$<?php echo number_format($preTaxTotal, 2); ?></span></div>
        <div class="row"><strong>Tax (5%)</strong><span>$<?php echo number_format($tax, 2); ?></span></div>
        <div class="row"><strong>Shipping & Handling (10%)</strong><span>$<?php echo number_format($shipping, 2); ?></span></div>
        <div class="row"><strong>Order Total</strong><span>$<?php echo number_format($orderTotal, 2); ?></span></div>

        <div class="actions">
            <form method="post">
                <input type="hidden" name="action" value="checkout" />
                <button type="submit">Check Out (Clear Cart + Return to Catalog)</button>
            </form>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
