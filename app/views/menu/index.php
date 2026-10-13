<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Menus</div>
    <div class="page-header">
        <h1>Manage Menus</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Menu</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Menu <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Name</th><th>Description</th><th>Actions</th></tr>
                <?php foreach($menus as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><?= htmlspecialchars($m['name']) ?></td>
                    <td><?= htmlspecialchars($m['description']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($m)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=menu_delete&id=<?= $m['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($menus)): ?><tr><td colspan="4" style="text-align:center;color:#999;padding:24px">No menus yet</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add Menu</h2>
        <form method="POST" action="index.php?action=menu_store">
            <div class="form-group"><label>Menu Name</label><input name="name" required placeholder="e.g. Breakfast"></div>
            <div class="form-group"><label>Description</label><textarea name="description" rows="3" placeholder="Short description"></textarea></div>
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
        <h2>Edit Menu</h2>
        <form method="POST" action="index.php?action=menu_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Menu Name</label><input name="name" id="edit-name" required></div>
            <div class="form-group"><label>Description</label><textarea name="description" id="edit-desc" rows="3"></textarea></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Cancel</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEdit(m) {
    document.getElementById('edit-id').value   = m.id;
    document.getElementById('edit-name').value = m.name;
    document.getElementById('edit-desc').value = m.description;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
