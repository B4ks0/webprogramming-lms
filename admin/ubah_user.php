<?php
$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT id, nama_lengkap, email, role FROM users WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$user) {
    echo '<div class="alert alert-danger">User tidak ditemukan.</div>';
    return;
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit User</h1>
    <a href="layout.php?page=users" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="admin/edit_user.php" method="post">
            <input type="hidden" name="id" value="<?php echo e($user['id']); ?>">
            <div class="form-group">
                <label>Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="form-control" value="<?php echo e($user['nama_lengkap']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="<?php echo e($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" class="form-control" minlength="6">
                <small class="form-text text-muted">Kosongkan jika password tidak diubah.</small>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="role" class="form-control" required>
                    <option value="mahasiswa" <?php echo $user['role'] === 'mahasiswa' ? 'selected' : ''; ?>>Mahasiswa</option>
                    <option value="dosen" <?php echo $user['role'] === 'dosen' ? 'selected' : ''; ?>>Dosen</option>
                    <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
</div>
