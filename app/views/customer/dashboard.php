<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Customer') ?>!</h1>
        <a href="index.php?action=browse_menu" class="btn btn-primary">Browse Menu & Order</a>
    </div>

    <div class="stats-grid">
        <div class="stat-card blue">
            <span class="stat-label">My Orders</span>
            <span class="stat-value"><?= count($my_orders) ?></span>
        </div>
        <div class="stat-card green">
            <span class="stat-label">Total Spent</span>
            <span class="stat-value">$<?php
                $spent = 0;
                foreach($my_orders as $o) $spent += $o['total_price'];
                echo number_format($spent, 2);
            ?></span>
        </div>
        <div class="stat-card orange">
            <span class="stat-label">Menu Categories</span>
            <span class="stat-value"><?= count($menus) ?></span>
        </div>
        <div class="stat-card red">
            <span class="stat-label">Available Items</span>
            <span class="stat-value"><?= count($products) ?></span>
        </div>
    </div>

    <div class="card">
        <div class="page-header" style="margin-bottom:14px">
            <h1 style="font-size:1.1rem">My Recent Orders</h1>
            <a href="index.php?action=my_orders" class="btn btn-sm btn-primary">View All</a>
        </div>
        <div class="table-wrap">
            <table>
                <tr><th>Order #</th><th>Total</th><th>Status</th><th>Invoice</th></tr>
                <?php
                $recent = array_slice(array_reverse(array_values($my_orders)), 0, 5);
                foreach($recent as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td>$<?= number_format($o['total_price'],2) ?></td>
                    <td><span class="badge badge-<?= $o['status']=='delivered'?'success':($o['status']=='pending'?'warning':($o['status']=='cancelled'?'danger':'info')) ?>"><?= ucfirst($o['status']) ?></span></td>
                    <td><a href="index.php?action=print_invoice&order_id=<?= $o['id'] ?>" class="btn btn-sm btn-info" target="_blank">🖨 Print</a></td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($my_orders)): ?>
                <tr><td colspan="4" style="text-align:center;color:#999;padding:24px">
                    No orders yet. <a href="index.php?action=browse_menu">Browse the menu</a> to place your first order!
                </td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
