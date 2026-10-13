<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Order Details</div>
    <div class="page-header">
        <h1>Order Details</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Detail</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Order detail <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Order ID</th><th>Product</th><th>Quantity</th><th>Price</th><th>Actions</th></tr>
                <?php foreach($details as $d): ?>
                <tr>
                    <td><?= $d['id'] ?></td>
                    <td>#<?= $d['order_id'] ?></td>
                    <td><?= htmlspecialchars($d['product_name']) ?></td>
                    <td><?= $d['quantity'] ?></td>
                    <td>$<?= number_format($d['price'],2) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($d)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=order_detail_delete&id=<?= $d['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($details)): ?><tr><td colspan="6" style="text-align:center;color:#999;padding:24px">No order details yet</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add Order Detail</h2>
        <form method="POST" action="index.php?action=order_detail_store">
            <div class="form-group">
                <label>Order</label>
                <select name="order_id" required>
                    <option value="">-- Select Order --</option>
                    <?php foreach($orders as $o): ?>
                    <option value="<?= $o['id'] ?>">Order #<?= $o['id'] ?> – <?= htmlspecialchars($o['user_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Product</label>
                <select name="product_id" required>
                    <option value="">-- Select Product --</option>
                    <?php foreach($products as $p): ?>
                    <option value="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>"><?= htmlspecialchars($p['name']) ?> – $<?= number_format($p['price'],2) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group"><label>Quantity</label><input type="number" name="quantity" id="qty" min="1" required placeholder="1" oninput="calcPrice()"></div>
                <div class="form-group"><label>Price ($)</label><input type="number" name="price" id="price" step="0.01" min="0" required placeholder="0.00"></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create')">Cancel</button>
                <button type="submit" class="btn btn-primary">Add Detail</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-edit')">&times;</span>
        <h2>Edit Order Detail</h2>
        <form method="POST" action="index.php?action=order_detail_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-row">
                <div class="form-group"><label>Quantity</label><input type="number" name="quantity" id="edit-qty" min="1" required></div>
                <div class="form-group"><label>Price ($)</label><input type="number" name="price" id="edit-price" step="0.01" min="0" required></div>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Cancel</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
document.querySelector('[name="product_id"]').addEventListener('change', calcPrice);
function calcPrice() {
    var sel = document.querySelector('[name="product_id"]');
    var qty = parseInt(document.getElementById('qty').value) || 1;
    var price = parseFloat(sel.options[sel.selectedIndex].dataset.price) || 0;
    document.getElementById('price').value = (price * qty).toFixed(2);
}
function openEdit(d) {
    document.getElementById('edit-id').value    = d.id;
    document.getElementById('edit-qty').value   = d.quantity;
    document.getElementById('edit-price').value = d.price;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
