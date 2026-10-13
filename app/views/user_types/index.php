<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / User Types</div>
    <div class="page-header">
        <h1>Manage User Types</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add Type</button>
    </div>
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">User type <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>
    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Type Name</th><th>Actions</th></tr>
                <?php foreach($types as $t): ?>
                <tr>
                    <td><?= $t['id'] ?></td>
                    <td><?= htmlspecialchars($t['type_name']) ?></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= $t['id'] ?>,'<?= addslashes($t['type_name']) ?>')">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=user_type_delete&id=<?= $t['id'] ?>" onclick="return confirm('Delete?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>

<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add User Type</h2>
        <form method="POST" action="index.php?action=user_type_store">
            <div class="form-group"><label>Type Name</label><input name="type_name" required placeholder="e.g. Admin, Customer"></div>
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
        <h2>Edit User Type</h2>
        <form method="POST" action="index.php?action=user_type_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Type Name</label><input name="type_name" id="edit-name" required></div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Cancel</button>
                <button type="submit" class="btn btn-warning">Update</button>
            </div>
        </form>
    </div>
</div>
<script>
function openEdit(id, name) {
    document.getElementById('edit-id').value   = id;
    document.getElementById('edit-name').value = name;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
