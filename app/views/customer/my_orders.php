<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="page-header">
        <h1>My Orders</h1>
        <a href="index.php?action=browse_menu" class="btn btn-primary">+ New Order</a>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Your order has been placed successfully! We'll prepare it right away.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>Order #</th><th>Total</th><th>Status</th><th>Actions</th></tr>
                <?php foreach(array_reverse($my_orders) as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td>$<?= number_format($o['total_price'],2) ?></td>
                    <td>
                        <span class="badge badge-<?= $o['status']=='delivered'?'success':($o['status']=='pending'?'warning':($o['status']=='cancelled'?'danger':'info')) ?>">
                            <?= ucfirst($o['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?action=print_invoice&order_id=<?= $o['id'] ?>" class="btn btn-sm btn-info" target="_blank">🖨 Invoice</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($my_orders)): ?>
                <tr><td colspan="4" style="text-align:center;color:#999;padding:28px">
                    You haven't placed any orders yet. <a href="index.php?action=browse_menu">Order now!</a>
                </td></tr>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<?php include __DIR__ . '/../partials/footer.php'; ?>
