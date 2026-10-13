<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Role-Menu Mapping</div>
    <div class="page-header">
        <h1>Role–Menu Mapping</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Mapping</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">Mapping <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>User Type</th><th>Menu</th><th>Actions</th></tr>
                <?php foreach($mappings as $m): ?>
                <tr>
                    <td><?= $m['id'] ?></td>
                    <td><span class="badge badge-info"><?= htmlspecialchars($m['type_name']) ?></span></td>
                    <td><?= htmlspecialchars($m['menu_name']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($m)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=usertype_menu_delete&id=<?= $m['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($mappings)): ?><tr><td colspan="4" style="text-align:center;color:#999;padding:24px">No mappings yet</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add Role-Menu Mapping</h2>
        <form method="POST" action="index.php?action=usertype_menu_store">
            <div class="form-group">
                <label>User Type</label>
                <select name="user_type_id" required>
                    <option value="">-- Select Role --</option>
                    <?php foreach($user_types as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['type_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Menu</label>
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
        <h2>Edit Mapping</h2>
        <form method="POST" action="index.php?action=usertype_menu_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group">
                <label>User Type</label>
                <select name="user_type_id" id="edit-type" required>
                    <?php foreach($user_types as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['type_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Menu</label>
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
function openEdit(m) {
    document.getElementById('edit-id').value   = m.id;
    document.getElementById('edit-type').value = m.user_type_id;
    document.getElementById('edit-menu').value = m.menu_id;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
