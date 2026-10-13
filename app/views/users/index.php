<?php include __DIR__ . '/../partials/header.php'; ?>
<div class="container">
    <div class="breadcrumb"><a href="index.php?action=admin_dashboard">Dashboard</a> / Users</div>
    <div class="page-header">
        <h1>Manage Users</h1>
        <button class="btn btn-primary" onclick="openModal('modal-create')">+ Add User</button>
    </div>

    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success">User <?= htmlspecialchars($_GET['success']) ?> successfully.</div>
    <?php endif; ?>

    <div class="card">
        <div class="table-wrap">
            <table>
                <tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Actions</th></tr>
                <?php foreach($users as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><span class="badge badge-<?= $u['user_type_id']==1?'danger':'info' ?>"><?= htmlspecialchars($u['type_name']) ?></span></td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="openEdit(<?= htmlspecialchars(json_encode($u)) ?>)">Edit</button>
                        <a class="btn btn-sm btn-danger" href="index.php?action=user_delete&id=<?= $u['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if(empty($users)): ?><tr><td colspan="5" style="text-align:center;color:#999;padding:24px">No users found</td></tr><?php endif; ?>
            </table>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal-overlay" id="modal-create">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-create')">&times;</span>
        <h2>Add New User</h2>
        <form method="POST" action="index.php?action=user_store">
            <div class="form-group"><label>Full Name</label><input name="name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
            <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
            <div class="form-group">
                <label>Role</label>
                <select name="user_type_id" required>
                    <?php foreach($user_types as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['type_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-create')">Cancel</button>
                <button type="submit" class="btn btn-primary">Create User</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Modal -->
<div class="modal-overlay" id="modal-edit">
    <div class="modal">
        <span class="modal-close" onclick="closeModal('modal-edit')">&times;</span>
        <h2>Edit User</h2>
        <form method="POST" action="index.php?action=user_update">
            <input type="hidden" name="id" id="edit-id">
            <div class="form-group"><label>Full Name</label><input name="name" id="edit-name" required></div>
            <div class="form-group"><label>Email</label><input type="email" name="email" id="edit-email" required></div>
            <div class="form-group">
                <label>Role</label>
                <select name="user_type_id" id="edit-type" required>
                    <?php foreach($user_types as $t): ?>
                    <option value="<?= $t['id'] ?>"><?= htmlspecialchars($t['type_name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display:flex;gap:10px;justify-content:flex-end;margin-top:20px">
                <button type="button" class="btn btn-secondary" onclick="closeModal('modal-edit')">Cancel</button>
                <button type="submit" class="btn btn-warning">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
function openEdit(u) {
    document.getElementById('edit-id').value    = u.id;
    document.getElementById('edit-name').value  = u.name;
    document.getElementById('edit-email').value = u.email;
    document.getElementById('edit-type').value  = u.user_type_id;
    openModal('modal-edit');
}
</script>
<?php include __DIR__ . '/../partials/footer.php'; ?>
