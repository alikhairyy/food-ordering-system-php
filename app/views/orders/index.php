<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Orders</div>
    <div class="page-header">
        <h1>Manage Orders</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Order</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Order <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Customer</th><th>Total Price</th><th>Status</th><th>Actions</th></tr>
                <?php foreach($orders as $o): ?>
                <tr>
                    <td>#<?= $o['id'] ?></td>
                    <td><?= htmlspecialchars($o['user_name']) ?></td>
                    <td>$<?= number_format($o['total_price'],2) ?></td>
                    <td>
                        <span class="badge badge-<?= $o['status']=='delivered'?'success':($o['status']=='pending'?'warning':($o['status']=='cancelled'?'danger':'info')) ?>">
                            <?= ucfirst($o['status']) ?>
                        </span>
                    </td>
                    <td>
                        <a href="index.php?action=print_invoice&order_id=<?= $o['id'] ?>" class="btn btn-sm btn-info" target="_blank">Invoice</a>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($o)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=order_delete&id=<?= $o['id'] ?>" onclick="return confirm('Delete this order?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($orders)): ?><tr><td colspan="5" style="text-align:center;color:#999;padding:24px">No orders yet</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add Order</h2>
        <form method="POST" action="index.php?action=order_store">
            <div class="form-group">
                <label>Customer</label>
                <select name="user_id" required>
                    <option value="">-- Select User --</option>
                    <?php foreach($users as $u): ?>
                    <option value="<?= $u['id'] ?>"><?= htmlspecialchars($u['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group"><label>Total Price ($)</label><input type="number" name="total_price" step="0.01" min="0" required placeholder="0.00"></div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" required>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-edit')">&times;</span>
        <h2>Edit Order</h2>
        <form method="POST" action="index.php?action=order_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Total Price ($)</label><input type="number" name="total_price" id="edit-total" step="0.01" min="0" required></div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" id="edit-status" required>
                    <option value="pending">Pending</option>
                    <option value="processing">Processing</option>
                    <option value="delivered">Delivered</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Cancel</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEdit(o) {
    document.getElementById('edit-id').value     = o.id;
    document.getElementById('edit-total').value  = o.total_price;
    document.getElementById('edit-status').value = o.status;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
