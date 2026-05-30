<?php
$id = (int)($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM kelas WHERE id = ?");
db_stmt_bind_param($stmt, 'i', $id);
db_stmt_execute($stmt);
$result = db_stmt_get_result($stmt);
$kelas = db_fetch_assoc($result);

if (!$kelas) {
    header('Location: layout.php?page=kelas');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama_kelas'] ?? '');
    $kode   = trim($_POST['kode_kelas'] ?? '');
    $kapasitas = (int)($_POST['kapasitas'] ?? 30);

    if ($nama && $kode) {
        $stmt2 = db_prepare($koneksi, "UPDATE kelas SET nama_kelas=?, kode_kelas=?, kapasitas=? WHERE id=?");
        db_stmt_bind_param($stmt2, 'ssii', $nama, $kode, $kapasitas, $id);
        db_stmt_execute($stmt2);
        header('Location: layout.php?page=kelas&sukses=1');
        exit;
    }
    $error = 'Nama kelas dan kode wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Ruang Kelas</h1>
    <a href="layout.php?page=kelas" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" required value="<?php echo e($_POST['nama_kelas'] ?? $kelas['nama_kelas']); ?>">
            </div>
            <div class="form-group">
                <label>Kode Kelas</label>
                <input type="text" name="kode_kelas" class="form-control" required value="<?php echo e($_POST['kode_kelas'] ?? $kelas['kode_kelas']); ?>">
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" min="1" value="<?php echo e($_POST['kapasitas'] ?? $kelas['kapasitas']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
