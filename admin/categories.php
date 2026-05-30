<?php
$list = db_query($koneksi, "SELECT * FROM categories ORDER BY nama_kategori ASC");
$sukses = $_GET['sukses'] ?? '';
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Categories</h1>
    <a href="layout.php?page=tambah_category" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Category
    </a>
</div>

<?php if ($sukses === '1'): ?><div class="alert alert-success">Data berhasil disimpan.</div><?php endif; ?>
<?php if ($sukses === 'hapus'): ?><div class="alert alert-success">Data berhasil dihapus.</div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>#</th><th>Nama Kategori</th><th>Slug</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = db_fetch_assoc($list)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo e($row['nama_kategori']); ?></td>
                        <td><?php echo e($row['slug']); ?></td>
                        <td>
                            <a href="layout.php?page=ubah_category&id=<?php echo e($row['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="layout.php?page=hapus_category&id=<?php echo e($row['id']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus kategori ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
