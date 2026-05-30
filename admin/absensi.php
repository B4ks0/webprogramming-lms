<?php
$courseFilter = (int)($_GET['course_id'] ?? 0);
$mahasiswaFilter = (int)($_GET['user_id'] ?? 0);
$sukses = $_GET['sukses'] ?? '';

$courses = db_query($koneksi, "SELECT id, judul FROM courses ORDER BY judul ASC");
$mahasiswaList = db_query($koneksi, "SELECT id, nama_lengkap FROM users WHERE role='mahasiswa' ORDER BY nama_lengkap ASC");

$where = "WHERE 1=1";
if ($courseFilter) $where .= " AND a.course_id = $courseFilter";
if ($mahasiswaFilter) $where .= " AND a.user_id = $mahasiswaFilter";

$list = db_query($koneksi, "
    SELECT a.*, u.nama_lengkap AS mahasiswa, c.judul AS course,
           CONCAT(j.hari, ' ', TIME_FORMAT(j.jam_mulai,'%H:%i'), '-', TIME_FORMAT(j.jam_selesai,'%H:%i')) AS sesi
    FROM absensi a
    JOIN users u ON u.id = a.user_id
    JOIN courses c ON c.id = a.course_id
    LEFT JOIN jadwal j ON j.id = a.jadwal_id
    $where
    ORDER BY a.tanggal DESC, c.judul ASC
");

$stats = db_fetch_assoc(db_query($koneksi, "
    SELECT
        SUM(status='hadir') AS hadir,
        SUM(status='izin')  AS izin,
        SUM(status='sakit') AS sakit,
        SUM(status='alpha') AS alpha
    FROM absensi a $where
"));
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Absensi</h1>
    <a href="layout.php?page=tambah_absensi" class="btn btn-primary btn-sm">
        <i class="fas fa-plus"></i> Tambah Absensi
    </a>
</div>

<?php if ($sukses === '1'): ?><div class="alert alert-success">Data absensi berhasil disimpan.</div><?php endif; ?>
<?php if ($sukses === 'hapus'): ?><div class="alert alert-success">Data absensi berhasil dihapus.</div><?php endif; ?>

<!-- Summary Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card border-left-success shadow py-2">
            <div class="card-body py-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hadir</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['hadir'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-info shadow py-2">
            <div class="card-body py-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Izin</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['izin'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-warning shadow py-2">
            <div class="card-body py-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Sakit</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['sakit'] ?? 0; ?></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-left-danger shadow py-2">
            <div class="card-body py-2">
                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Alpha</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $stats['alpha'] ?? 0; ?></div>
            </div>
        </div>
    </div>
</div>

<!-- Filter -->
<div class="card shadow mb-4">
    <div class="card-header py-2"><strong>Filter</strong></div>
    <div class="card-body py-2">
        <form method="get" class="form-inline">
            <input type="hidden" name="page" value="absensi">
            <select name="course_id" class="form-control form-control-sm mr-2">
                <option value="">-- Semua Course --</option>
                <?php while ($c = db_fetch_assoc($courses)): ?>
                    <option value="<?php echo e($c['id']); ?>" <?php echo $courseFilter == $c['id'] ? 'selected' : ''; ?>>
                        <?php echo e($c['judul']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <select name="user_id" class="form-control form-control-sm mr-2">
                <option value="">-- Semua Mahasiswa --</option>
                <?php while ($m = db_fetch_assoc($mahasiswaList)): ?>
                    <option value="<?php echo e($m['id']); ?>" <?php echo $mahasiswaFilter == $m['id'] ? 'selected' : ''; ?>>
                        <?php echo e($m['nama_lengkap']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <button type="submit" class="btn btn-primary btn-sm mr-1"><i class="fas fa-filter"></i> Filter</button>
            <a href="layout.php?page=absensi" class="btn btn-secondary btn-sm">Reset</a>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-sm">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>Mahasiswa</th>
                        <th>Course / Mata Kuliah</th>
                        <th>Sesi (Hari &amp; Jam)</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $statusBadge = ['hadir'=>'success','izin'=>'info','sakit'=>'warning','alpha'=>'danger'];
                $no = 1;
                while ($row = db_fetch_assoc($list)):
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo e($row['mahasiswa']); ?></td>
                        <td><?php echo e($row['course']); ?></td>
                        <td><?php echo e($row['sesi'] ?? '-'); ?></td>
                        <td><?php echo e($row['tanggal']); ?></td>
                        <td>
                            <span class="badge badge-<?php echo $statusBadge[$row['status']] ?? 'secondary'; ?>">
                                <?php echo strtoupper(e($row['status'])); ?>
                            </span>
                        </td>
                        <td><?php echo e($row['keterangan'] ?? '-'); ?></td>
                        <td>
                            <a href="layout.php?page=ubah_absensi&id=<?php echo e($row['id']); ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="layout.php?page=hapus_absensi&id=<?php echo e($row['id']); ?>"
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Hapus data absensi ini?')">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
