<?php
$list = db_query($koneksi, "
    SELECT j.*, c.judul AS course, k.nama_kelas
    FROM jadwal j
    JOIN courses c ON c.id = j.course_id
    JOIN kelas k ON k.id = j.kelas_id
    ORDER BY FIELD(j.hari,'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'), j.jam_mulai ASC
");
$sukses = $_GET['sukses'] ?? '';
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Jadwal</h1>
    <a href="layout.php?page=tambah_jadwal" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Jadwal
    </a>
</div>

<?php if ($sukses === '1'): ?><div class="alert alert-success">Data berhasil disimpan.</div><?php endif; ?>
<?php if ($sukses === 'hapus'): ?><div class="alert alert-success">Data berhasil dihapus.</div><?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr><th>#</th><th>Course</th><th>Kelas</th><th>Hari</th><th>Jam</th><th>Ruangan</th><th>Aksi</th></tr>
                </thead>
                <tbody>
                <?php $no = 1; while ($row = db_fetch_assoc($list)): ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo e($row['course']); ?></td>
                        <td><?php echo e($row['nama_kelas']); ?></td>
                        <td><?php echo e($row['hari']); ?></td>
                        <td><?php echo substr($row['jam_mulai'],0,5) . ' - ' . substr($row['jam_selesai'],0,5); ?></td>
                        <td><?php echo e($row['ruangan'] ?? '-'); ?></td>
                        <td>
                            <a href="layout.php?page=ubah_jadwal&id=<?php echo e($row['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="layout.php?page=hapus_jadwal&id=<?php echo e($row['id']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus jadwal ini?')">
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
