<?php
session_start();
require_once "db.php";
require_once "products.php";

$sessionId = session_id();
$products = GetProducts();

// Get quantity for one product from DB
function GetQtyInCart($productId)
{
    global $pdo, $sessionId;

    $stmt = $pdo->prepare("SELECT quantity FROM cart_items WHERE session_id = ? AND product_id = ?");
    $stmt->execute(array($sessionId, $productId));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row) {
        return intval($row["quantity"]);
    }
    return 0;
}

// Upsert helper (insert or update)
function SetCartQty($productId, $qty)
{
    global $pdo, $sessionId;

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

// Handle POST actions
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $action = isset($_POST["action"]) ? $_POST["action"] : "";
    $productId = isset($_POST["product_id"]) ? intval($_POST["product_id"]) : 0;

    if ($productId > 0 && isset($products[$productId])) {
        $currentQty = GetQtyInCart($productId);

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
        SetCartQty($productId, $currentQty);
    }

    header("Location: catalog.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <style>
        :root{
            --bg:#0b1020;
            --panel:#121a33;
            --panel2:#0f1730;
            --text:#e8ecf7;
            --muted:#aab4d4;
            --border:rgba(255,255,255,.10);
            --accent:#7aa2ff;
            --good:#32d583;
            --bad:#ff6b6b;
            --shadow: 0 10px 30px rgba(0,0,0,.35);
            --radius:16px;
        }

        *{ box-sizing:border-box; }
        body{
            margin:0;
            font-family: Arial, Helvetica, sans-serif;
            background: radial-gradient(1200px 600px at 10% 0%, rgba(122,162,255,.18), transparent 60%),
                        radial-gradient(900px 500px at 90% 10%, rgba(50,213,131,.14), transparent 55%),
                        var(--bg);
            color: var(--text);
        }

        a{ color: var(--accent); text-decoration:none; }
        a:hover{ text-decoration:underline; }

        .wrap{
            width:min(1200px, calc(100% - 32px));
            margin:0 auto;
            padding: 22px 0 32px;
        }

        /* Top bar */
        .topbar{
            position: sticky;
            top:0;
            z-index: 10;
            background: rgba(11,16,32,.72);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border);
        }
        .topbar-inner{
            width:min(1200px, calc(100% - 32px));
            margin:0 auto;
            padding: 14px 0;
            display:flex;
            align-items:center;
            justify-content:space-between;
            gap:12px;
        }
        .brand{
            display:flex;
            flex-direction:column;
            gap:2px;
        }
        .brand h1{
            margin:0;
            font-size: 18px;
            letter-spacing:.2px;
        }
        .brand .sub{
            color: var(--muted);
            font-size: 12px;
        }

        .nav{
            display:flex;
            gap:10px;
            flex-wrap: wrap;
            align-items:center;
        }
        .pill{
            display:inline-flex;
            align-items:center;
            gap:8px;
            padding: 9px 12px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.04);
            color: var(--text);
        }
        .pill strong{ font-weight:700; }

        /* Header */
        .hero{
            margin-top: 18px;
            padding: 18px 18px;
            border: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(18,26,51,.86), rgba(18,26,51,.62));
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .hero h2{
            margin:0 0 6px 0;
            font-size: 26px;
        }
        .hero p{
            margin:0;
            color: var(--muted);
            line-height: 1.5;
        }

        /* Table container */
        .card{
            margin-top: 14px;
            border: 1px solid var(--border);
            background: rgba(18,26,51,.70);
            border-radius: var(--radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-wrap{
            overflow:auto;
        }

        table{
            border-collapse: collapse;
            width: 100%;
            min-width: 980px;
        }

        thead th{
            position: sticky;
            top: 0;
            background: rgba(15,23,48,.92);
            backdrop-filter: blur(6px);
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 12px 12px;
            text-align:left;
        }

        tbody td{
            border-bottom: 1px solid rgba(255,255,255,.06);
            padding: 12px 12px;
            vertical-align: top;
            color: var(--text);
        }

        tbody tr:hover td{
            background: rgba(255,255,255,.03);
        }

        .money{ font-weight:700; }
        .desc{ color: var(--muted); max-width: 520px; }
        .qty-badge{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            min-width: 34px;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.04);
            font-weight: 700;
        }

        /* Actions */
        .actions{
            white-space: nowrap;
        }
        .actions form{
            display:inline-block;
            margin: 2px;
        }

        button{
            border: 1px solid var(--border);
            background: rgba(255,255,255,.04);
            color: var(--text);
            padding: 8px 10px;
            border-radius: 10px;
            cursor:pointer;
            font-weight: 700;
        }
        button:hover{
            background: rgba(255,255,255,.07);
        }

        .btn-add{ border-color: rgba(50,213,131,.28); background: rgba(50,213,131,.14); }
        .btn-add:hover{ background: rgba(50,213,131,.20); }

        .btn-remove{ border-color: rgba(255,107,107,.28); background: rgba(255,107,107,.12); }
        .btn-remove:hover{ background: rgba(255,107,107,.18); }

        .btn-small{
            padding: 8px 10px;
            width: 36px;
            text-align:center;
        }

        .setqty{
            display:inline-flex;
            align-items:center;
            gap:8px;
            margin-left: 6px;
            padding: 6px 8px;
            border-radius: 12px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.03);
        }

        input[type="number"]{
            width: 74px;
            padding: 8px 10px;
            border-radius: 10px;
            border: 1px solid var(--border);
            background: rgba(0,0,0,.20);
            color: var(--text);
            outline: none;
        }
        input[type="number"]:focus{
            border-color: rgba(122,162,255,.55);
            box-shadow: 0 0 0 3px rgba(122,162,255,.18);
        }

        .footer-note{
            margin-top: 10px;
            color: var(--muted);
            font-size: 12px;
        }

        @media (max-width: 700px){
            .hero h2{ font-size: 22px; }
            .topbar-inner{ flex-direction: column; align-items:flex-start; }
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-inner">
        <div class="brand">
            <h1>Online Sales Store</h1>
        </div>
        <div class="nav">
            <a class="pill" href="catalog.php"><strong>Catalog</strong></a>
            <a class="pill" href="cart.php">Go to Cart →</a>
        </div>
    </div>
</div>

<div class="wrap">

    <div class="hero">
        <h2>Product Catalog</h2>
        <p>
            Text-only catalog. Use the controls to add/remove items and adjust quantity.
            Quantities are stored in the database using your current session.
        </p>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:90px;">Product ID</th>
                        <th style="width:220px;">Product Name</th>
                        <th>Product Description</th>
                        <th style="width:140px;">Product Cost</th>
                        <th style="width:210px;">Qty in Cart</th>
                        <th style="width:340px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($products as $p): ?>
                    <?php $qty = GetQtyInCart($p["id"]); ?>
                    <tr>
                        <td><?php echo $p["id"]; ?></td>
                        <td><strong><?php echo htmlspecialchars($p["name"]); ?></strong></td>
                        <td class="desc"><?php echo htmlspecialchars($p["description"]); ?></td>
                        <td class="money">$<?php echo number_format($p["cost"], 2); ?></td>
                        <td><span class="qty-badge"><?php echo $qty; ?></span></td>
                        <td class="actions">
                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                                <input type="hidden" name="action" value="add" />
                                <button class="btn-add" type="submit">Add</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                                <input type="hidden" name="action" value="dec" />
                                <button class="btn-small" type="submit">−</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                                <input type="hidden" name="action" value="inc" />
                                <button class="btn-small" type="submit">+</button>
                            </form>

                            <form method="post">
                                <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                                <input type="hidden" name="action" value="remove" />
                                <button class="btn-remove" type="submit">Remove</button>
                            </form>

                            <form method="post" class="setqty">
                                <input type="hidden" name="product_id" value="<?php echo $p["id"]; ?>" />
                                <input type="hidden" name="action" value="set" />
                                <span style="color:var(--muted); font-size:12px; font-weight:700;">Set Qty</span>
                                <input type="number" name="qty" min="0" value="<?php echo $qty; ?>" />
                                <button type="submit">Update</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="footer-note">
        Tip: Add a few items, then click <strong>Go to Cart</strong> to verify totals + checkout.
    </div>

</div>

</body>
</html>
