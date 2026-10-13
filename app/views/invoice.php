<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice – Order #<?= $order['id'] ?></title>
    <link rel="stylesheet" href="/FinalSoftware/assets/css/style.css">
    <style>
        body { background:#fff; font-family:'Segoe UI',sans-serif; }
        .invoice-wrap { max-width:700px; margin:40px auto; padding:40px; border:1px solid #ddd; border-radius:10px; }
        .invoice-header { display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:36px; }
        .invoice-logo   { font-size:1.6rem; font-weight:800; color:#e74c3c; }
        .invoice-meta   { text-align:right; font-size:0.88rem; color:#666; }
        .invoice-meta h2 { font-size:1.4rem; color:#2c3e50; margin-bottom:4px; }
        .divider        { border:none; border-top:2px solid #eee; margin:24px 0; }
        .info-grid      { display:grid; grid-template-columns:1fr 1fr; gap:20px; margin-bottom:28px; font-size:0.9rem; }
        .info-block label { font-weight:700; display:block; margin-bottom:4px; color:#888; font-size:0.78rem; text-transform:uppercase; letter-spacing:1px; }
        table { width:100%; border-collapse:collapse; font-size:0.9rem; margin-bottom:24px; }
        th { background:#f5f5f5; padding:10px 14px; text-align:left; font-weight:700; }
        td { padding:10px 14px; border-bottom:1px solid #f0f0f0; }
        .total-row td { font-weight:700; font-size:1rem; background:#fef9f9; border-top:2px solid #e74c3c; }
        .status-badge { display:inline-block; padding:4px 12px; border-radius:20px; font-size:0.8rem; font-weight:700; }
        .footer-note  { text-align:center; color:#aaa; font-size:0.8rem; margin-top:30px; }
    </style>
</head>
<body>
<div class="invoice-wrap">
    <div class="invoice-header">
        <div>
            <div class="invoice-logo">🍽️ FoodOrder</div>
            <div style="font-size:0.82rem;color:#999;margin-top:4px">Your favourite food, delivered fast</div>
        </div>
        <div class="invoice-meta">
            <h2>INVOICE</h2>
            <div>Invoice No: <strong>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong></div>
            <div>Date: <strong><?= date('d M Y') ?></strong></div>
            <div style="margin-top:8px">
                <span class="status-badge" style="background:<?= $order['status']=='delivered'?'#d5f5e3':($order['status']=='pending'?'#fdebd0':'#fdedec') ?>;color:<?= $order['status']=='delivered'?'#1e8449':($order['status']=='pending'?'#d35400':'#c0392b') ?>">
                    <?= strtoupper($order['status']) ?>
                </span>
            </div>
        </div>
    </div>

    <hr class="divider">

    <div class="info-grid">
        <div class="info-block">
            <label>Billed To</label>
            <strong><?= htmlspecialchars($order['user_name']) ?></strong>
        </div>
        <div class="info-block">
            <label>Order Reference</label>
            <strong>ORD-<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></strong>
        </div>
    </div>

    <table>
        <tr>
            <th>#</th>
            <th>Product</th>
            <th style="text-align:center">Qty</th>
            <th style="text-align:right">Price</th>
        </tr>
        <?php $i = 1; foreach($details as $d): ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= htmlspecialchars($d['product_name']) ?></td>
            <td style="text-align:center"><?= $d['quantity'] ?></td>
            <td style="text-align:right">$<?= number_format($d['price'],2) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if(empty($details)): ?>
        <tr><td colspan="4" style="text-align:center;color:#999">No items found for this order.</td></tr>
        <?php endif; ?>
        <tr class="total-row">
            <td colspan="3" style="text-align:right">TOTAL</td>
            <td style="text-align:right;color:#e74c3c">$<?= number_format($order['total_price'],2) ?></td>
        </tr>
    </table>

    <div style="text-align:right;margin-bottom:20px" class="no-print">
        <button onclick="window.print()" class="btn btn-primary">🖨 Print Invoice</button>
        <button onclick="window.close()" class="btn btn-secondary">Close</button>
    </div>

    <hr class="divider">
    <div class="footer-note">
        Thank you for your order! &nbsp;|&nbsp; FoodOrder &copy; <?= date('Y') ?><br>
        This is a computer-generated invoice and does not require a signature.
    </div>
</div>
</body>
</html>
