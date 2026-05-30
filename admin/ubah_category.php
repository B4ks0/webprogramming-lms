<?php
$id = (int)($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM categories WHERE id = ?");
db_stmt_bind_param($stmt, 'i', $id);
db_stmt_execute($stmt);
$result = db_stmt_get_result($stmt);
$cat = db_fetch_assoc($result);

if (!$cat) {
    header('Location: layout.php?page=categories');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama_kategori'] ?? '');
    $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', trim($nama)));

    if ($nama) {
        $stmt2 = db_prepare($koneksi, "UPDATE categories SET nama_kategori=?, slug=? WHERE id=?");
        db_stmt_bind_param($stmt2, 'ssi', $nama, $slug, $id);
        db_stmt_execute($stmt2);
        header('Location: layout.php?page=categories&sukses=1');
        exit;
    }
    $error = 'Nama kategori wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Category</h1>
    <a href="layout.php?page=categories" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Nama Kategori</label>
                <input type="text" name="nama_kategori" class="form-control" required value="<?php echo e($_POST['nama_kategori'] ?? $cat['nama_kategori']); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
