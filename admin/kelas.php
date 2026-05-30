<?php
$kelasList = db_query($koneksi, "SELECT * FROM kelas ORDER BY nama_kelas ASC");
$sukses = $_GET['sukses'] ?? '';
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ruang Kelas</h1>
    <a href="layout.php?page=tambah_kelas" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Kelas
    </a>
</div>

<?php if ($sukses === '1'): ?><div class="alert alert-success">Data berhasil disimpan.</div><?php endif; ?>
<?php if ($sukses === 'hapus'): ?><div class="alert alert-success">Data berhasil dihapus.</div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Kelas</th>
                        <th>Kode Kelas</th>
                        <th>Kapasitas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($k = db_fetch_assoc($kelasList)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo e($k['nama_kelas']); ?></td>
                        <td><?php echo e($k['kode_kelas']); ?></td>
                        <td><?php echo e($k['kapasitas']); ?></td>
                        <td>
                            <a href="layout.php?page=ubah_kelas&id=<?php echo e($k['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="layout.php?page=hapus_kelas&id=<?php echo e($k['id']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus kelas ini?')">
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
