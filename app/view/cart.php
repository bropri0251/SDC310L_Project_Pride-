<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <title>Cart</title>
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

        .hero{
            margin-top: 18px;
            padding: 18px;
            border: 1px solid var(--border);
            background: linear-gradient(180deg, rgba(18,26,51,.86), rgba(18,26,51,.62));
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display:flex;
            align-items:flex-start;
            justify-content:space-between;
            gap: 14px;
            flex-wrap: wrap;
        }
        .hero h2{
            margin:0 0 6px 0;
            font-size: 26px;
        }
        .hero p{
            margin:0;
            color: var(--muted);
            line-height: 1.5;
            max-width: 720px;
        }

        .summary-pill{
            display:inline-flex;
            align-items:center;
            justify-content:center;
            gap:8px;
            padding: 10px 12px;
            border-radius: 999px;
            border: 1px solid var(--border);
            background: rgba(255,255,255,.04);
            color: var(--text);
            font-weight: 800;
        }

        .grid{
            display:grid;
            grid-template-columns: 1fr 420px;
            gap: 14px;
            margin-top: 14px;
            align-items:start;
        }
        @media (max-width: 980px){
            .grid{ grid-template-columns: 1fr; }
        }

        .card{
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
            min-width: 860px;
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

        .money{ font-weight:800; }
        .muted{ color: var(--muted); }

        .totals{
            border: 1px solid var(--border);
            background: rgba(18,26,51,.70);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            padding: 14px;
        }
        .totals h3{
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .row{
            display:flex;
            justify-content:space-between;
            gap: 10px;
            padding: 7px 0;
            border-bottom: 1px dashed rgba(255,255,255,.10);
        }
        .row:last-of-type{ border-bottom: none; }
        .row strong{ font-weight: 800; }

        button{
            border: 1px solid var(--border);
            background: rgba(255,255,255,.04);
            color: var(--text);
            padding: 10px 12px;
            border-radius: 12px;
            cursor:pointer;
            font-weight: 800;
            width: 100%;
            margin-top: 10px;
        }
        button:hover{
            background: rgba(255,255,255,.07);
        }
        .btn-checkout{
            border-color: rgba(50,213,131,.28);
            background: rgba(50,213,131,.14);
        }
        .btn-checkout:hover{
            background: rgba(50,213,131,.20);
        }

        .empty{
            margin-top: 14px;
            padding: 16px;
            border: 1px solid var(--border);
            background: rgba(18,26,51,.60);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .empty h3{ margin: 0 0 6px 0; }
        .empty p{ margin: 0; color: var(--muted); }

        .footnote{
            margin-top: 10px;
            color: var(--muted);
            font-size: 12px;
        }
    </style>
</head>
<body>

<div class="topbar">
    <div class="topbar-inner">
        <div class="brand">
            <h1>SimpleStore</h1>
            <div class="sub">Cart • Week 3 Database Support</div>
        </div>
        <div class="nav">
            <a class="pill" href="index.php?page=catalog">← Continue Shopping</a>
            <a class="pill" href="index.php?page=cart"><strong>Cart</strong></a>
        </div>
    </div>
</div>

<div class="wrap">

    <div class="hero">
        <div>
            <h2>Your Shopping Cart</h2>
            <p>
                Items in your cart are stored in the database for your current session.
                Review totals below and use checkout to clear your cart.
            </p>
        </div>

        <div class="summary-pill">
            Total Items: <?php echo $totals['itemsCount']; ?>
        </div>
    </div>

    <?php if (count($cartItems) === 0): ?>
        <div class="empty">
            <h3>Cart is empty</h3>
            <p>Add a few items from the catalog to see order totals and checkout.</p>
        </div>
    <?php else: ?>

        <div class="grid">
            <div class="card">
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:110px;">Product ID</th>
                                <th>Product Name</th>
                                <th style="width:170px;">Quantity Ordered</th>
                                <th style="width:190px;">Product Cost</th>
                                <th style="width:190px;">Product Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($cartItems as $r): ?>
                            <?php
                                $qty = intval($r["quantity"]);
                                $price = floatval($r["price"]);
                                $lineTotal = $price * $qty;
                            ?>
                            <tr>
                                <td><?php echo intval($r["product_id"]); ?></td>
                                <td><strong><?php echo htmlspecialchars($r["name"]); ?></strong></td>
                                <td><?php echo $qty; ?></td>
                                <td class="money">$<?php echo number_format($price, 2); ?></td>
                                <td class="money">$<?php echo number_format($lineTotal, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="totals">
                <h3>Order Summary</h3>

                <div class="row">
                    <span class="muted">Total of items ordered</span>
                    <strong><?php echo $totals['itemsCount']; ?></strong>
                </div>

                <div class="row">
                    <span class="muted">Pre-tax total</span>
                    <strong>$<?php echo number_format($totals['preTaxTotal'], 2); ?></strong>
                </div>

                <div class="row">
                    <span class="muted">Tax (5%)</span>
                    <strong>$<?php echo number_format($totals['tax'], 2); ?></strong>
                </div>

                <div class="row">
                    <span class="muted">Shipping & Handling (10%)</span>
                    <strong>$<?php echo number_format($totals['shipping'], 2); ?></strong>
                </div>

                <div class="row">
                    <span class="muted">Order Total</span>
                    <strong>$<?php echo number_format($totals['orderTotal'], 2); ?></strong>
                </div>

                <form method="post" action="index.php?page=cart">
                    <input type="hidden" name="action" value="checkout" />
                    <button class="btn-checkout" type="submit">Check Out (Clear Cart + Return to Catalog)</button>
                </form>

                <div class="footnote">
                    Checkout clears cart_items for this session and returns to the catalog page.
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>

</body>
</html>