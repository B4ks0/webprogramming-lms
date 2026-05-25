<?php
$users = db_query($koneksi, "SELECT id, nama_lengkap, email, role, created_at FROM users ORDER BY role, nama_lengkap");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Manajemen Pengguna</h1>
    <a href="layout.php?page=tambah_user" class="btn btn-primary btn-sm"><i class="fas fa-user-plus"></i> Tambah User</a>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Data pengguna berhasil diproses.</div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = db_fetch_assoc($users)): ?>
                    <tr>
                        <td><?php echo e($user['nama_lengkap']); ?></td>
                        <td><?php echo e($user['email']); ?></td>
                        <td><span class="badge badge-primary text-capitalize"><?php echo e($user['role']); ?></span></td>
                        <td><?php echo e($user['created_at']); ?></td>
                        <td>
                            <a href="layout.php?page=ubah_user&id=<?php echo e($user['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <?php if ((int) $user['id'] !== (int) $_SESSION['user_id']): ?>
                                <a href="admin/hapus_user.php?id=<?php echo e($user['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini? Data kelas/enrollment terkait juga dapat ikut terhapus.')">Hapus</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
