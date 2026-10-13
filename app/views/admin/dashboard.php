<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb">Dashboard</div>
    <div class="page-header"><h1>Admin Dashboard</h1></div>

    <div class="stats-grid">
        <div class="stat-card red">
            <span class="stat-label">Total Users</span>
            <span class="stat-value"><?= count($users) ?></span>
        </div>
        <div class="stat-card green">
            <span class="stat-label">Total Orders</span>
            <span class="stat-value"><?= count($orders) ?></span>
        </div>
        <div class="stat-card blue">
            <span class="stat-label">Total Products</span>
            <span class="stat-value"><?= count($products) ?></span>
        </div>
        <div class="stat-card orange">
            <span class="stat-label">Total Revenue</span>
            <span class="stat-value">$<?= number_format($total_revenue, 2) ?></span>
        </div>
    </div>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px">
        <!-- Recent Orders -->
        <div class="card">
            <div class="page-header" style="margin-bottom:14px">
                <h1 style="font-size:1.1rem">Recent Orders</h1>
                <a href="index.php?action=orders" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-wrap">
                <table>
                    <tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th></th></tr>
                    <?php foreach(array_slice($orders, -5) as $o): ?>
                    <tr>
                        <td>#<?= $o['id'] ?></td>
                        <td><?= htmlspecialchars($o['user_name']) ?></td>
                        <td>$<?= number_format($o['total_price'],2) ?></td>
                        <td>
                            <span class="badge badge-<?= $o['status']=='delivered'?'success':($o['status']=='pending'?'warning':'info') ?>">
                                <?= ucfirst($o['status']) ?>
                            </span>
                        </td>
                        <td><a href="index.php?action=print_invoice&order_id=<?= $o['id'] ?>" class="btn btn-sm btn-info" target="_blank">Invoice</a></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($orders)): ?><tr><td colspan="5" style="text-align:center;color:#999;padding:20px">No orders yet</td></tr><?php endif; ?>
                </table>
            </div>
        </div>

        <!-- Menu overview -->
        <div class="card">
            <div class="page-header" style="margin-bottom:14px">
                <h1 style="font-size:1.1rem">Menus</h1>
                <a href="index.php?action=menu" class="btn btn-sm btn-primary">Manage</a>
            </div>
            <div class="table-wrap">
                <table>
                    <tr><th>Name</th><th>Description</th></tr>
                    <?php foreach($menus as $m): ?>
                    <tr>
                        <td><?= htmlspecialchars($m['name']) ?></td>
                        <td><?= htmlspecialchars($m['description']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php if(empty($menus)): ?><tr><td colspan="2" style="text-align:center;color:#999;padding:20px">No menus yet</td></tr><?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
