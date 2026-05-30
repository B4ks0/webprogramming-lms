<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kategori'] ?? '');
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($nama)));

    if ($nama) {
        $stmt = db_prepare($koneksi, "INSERT INTO categories (nama_kategori, slug) VALUES (?, ?)");
        db_stmt_bind_param($stmt, 'ss', $nama, $slug);
        db_stmt_execute($stmt);
        header('Location: layout.php?page=categories&sukses=1');
        exit;
    }
    $error = 'Nama kategori wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Category</h1>
    <a href="layout.php?page=categories" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" required value="<?php echo e($_POST['nama_kategori'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
