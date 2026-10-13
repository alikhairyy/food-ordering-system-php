<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Products</div>
    <div class="page-header">
        <h1>Manage Products</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Product</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Product <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Name</th><th>Price</th><th>Menu</th><th>Actions</th></tr>
                <?php foreach($products as $p): ?>
                <tr>
                    <td><?= $p['id'] ?></td>
                    <td><?= htmlspecialchars($p['name']) ?></td>
                    <td>$<?= number_format($p['price'],2) ?></td>
                    <td><?= htmlspecialchars($p['menu_name']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($p)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=product_delete&id=<?= $p['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($products)): ?><tr><td colspan="5" style="text-align:center;color:#999;padding:24px">No products yet</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add Product</h2>
        <form method="POST" action="index.php?action=product_store">
            <div class="form-group"><label>Product Name</label><input name="name" required placeholder="e.g. Grilled Chicken"></div>
            <div class="form-group"><label>Price ($)</label><input type="number" name="price" step="0.01" min="0" required placeholder="0.00"></div>
            <div class="form-group">
                <label>Menu Category</label>
                <select name="menu_id" required>
                    <option value="">-- Select Menu --</option>
                    <?php foreach($menus as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                    <?php endforeach; ?>
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
        <h2>Edit Product</h2>
        <form method="POST" action="index.php?action=product_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Product Name</label><input name="name" id="edit-name" required></div>
            <div class="form-group"><label>Price ($)</label><input type="number" name="price" id="edit-price" step="0.01" min="0" required></div>
            <div class="form-group">
                <label>Menu Category</label>
                <select name="menu_id" id="edit-menu" required>
                    <?php foreach($menus as $m): ?>
                    <option value="<?= $m['id'] ?>"><?= htmlspecialchars($m['name']) ?></option>
                    <?php endforeach; ?>
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
function openEdit(p) {
    document.getElementById('edit-id').value    = p.id;
    document.getElementById('edit-name').value  = p.name;
    document.getElementById('edit-price').value = p.price;
    document.getElementById('edit-menu').value  = p.menu_id;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
