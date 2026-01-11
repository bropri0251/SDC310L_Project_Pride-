<?php
session_start();
require_once "products.php";

$products = GetProducts();

// Ensure cart exists in session
if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = array(); // productId => qty
}

// Helper: get qty in cart (default 0)
function GetQty($productId)
{
    if (isset($_SESSION["cart"][$productId])) {
        return intval($_SESSION["cart"][$productId]);
    }
    return 0;
}

// Handle actions (add, remove, inc, dec, set)
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;

    if ($productId > 0 && isset($products[$productId])) {
        $currentQty = GetQty($productId);

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

        // Limit qty to 0 or more
        if ($currentQty < 0) {
            $currentQty = 0;
        }

        if ($currentQty === 0) {
            if (isset($_SESSION["cart"][$productId])) {
                unset($_SESSION["cart"][$productId]);
            }
        } else {
            $_SESSION["cart"][$productId] = $currentQty;
        }
    }

    // Prevent re-post on refresh
    header("Location: catalog.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Catalog</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 18px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 10px; vertical-align: top; }
        th { background: #f3f3f3; text-align: left; }
        .actions form { display: inline-block; margin: 2px; }
        .nav { margin-bottom: 14px; }
        .nav a { margin-right: 10px; }
        input[type="number"] { width: 70px; }
    </style>
</head>
<body>

<div class="nav">
    <a href="catalog.php">Catalog</a>
    <a href="cart.php">Go to Cart</a>
</div>

<h2>Product Catalog</h2>
<p>Text-only catalog. Use the buttons to add/remove items and adjust quantity.</p>

<table>
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Product Description</th>
            <th>Product Cost</th>
            <th>Quantity Currently in Cart</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($products as $p): ?>
        <?php $qty = GetQty($p["id"]); ?>
        <tr>
            <td><?php echo $p["id"]; ?></td>
            <td><?php echo htmlspecialchars($p["name"]); ?></td>
            <td><?php echo htmlspecialchars($p["description"]); ?></td>
            <td>$<?php echo number_format($p["cost"], 2); ?></td>
            <td><?php echo $qty; ?></td>
            <td class="actions">
                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                    <input type="hidden" name="action" value="add" />
                    <button type="submit">Add</button>
                </form>

                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                    <input type="hidden" name="action" value="dec" />
                    <button type="submit">-</button>
                </form>

                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                    <input type="hidden" name="action" value="inc" />
                    <button type="submit">+</button>
                </form>

                <form method="post">
                    <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                    <input type="hidden" name="action" value="remove" />
                    <button type="submit">Remove</button>
                </form>

                <form method="post" style="margin-left:6px;">
                    <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                    <input type="hidden" name="action" value="set" />
                    <label>Set Qty:</label>
                    <input type="number" name="qty" min="0" value="<?php echo $qty; ?>" />
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
