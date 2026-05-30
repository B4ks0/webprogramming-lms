<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama   = trim($_POST['nama_kelas'] ?? '');
    $kode   = trim($_POST['kode_kelas'] ?? '');
    $kapasitas = (int)($_POST['kapasitas'] ?? 30);

    if ($nama && $kode) {
        $stmt = db_prepare($koneksi, "INSERT INTO kelas (nama_kelas, kode_kelas, kapasitas) VALUES (?, ?, ?)");
        db_stmt_bind_param($stmt, 'ssi', $nama, $kode, $kapasitas);
        db_stmt_execute($stmt);
        header('Location: layout.php?page=kelas&sukses=1');
        exit;
    }
    $error = 'Nama kelas dan kode wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Ruang Kelas</h1>
    <a href="layout.php?page=kelas" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Kelas</label>
                <input type="text" name="nama_kelas" class="form-control" required value="<?php echo e($_POST['nama_kelas'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Kode Kelas</label>
                <input type="text" name="kode_kelas" class="form-control" required value="<?php echo e($_POST['kode_kelas'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Kapasitas</label>
                <input type="number" name="kapasitas" class="form-control" min="1" value="<?php echo e($_POST['kapasitas'] ?? 30); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
