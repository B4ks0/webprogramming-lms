<?php
$courses = db_query($koneksi, "SELECT id, judul FROM courses ORDER BY judul ASC");
$mahasiswaList = db_query($koneksi, "SELECT id, nama_lengkap FROM users WHERE role='mahasiswa' ORDER BY nama_lengkap ASC");
$jadwalList = db_query($koneksi, "
    SELECT j.id, CONCAT(c.judul, ' - ', j.hari, ' ', TIME_FORMAT(j.jam_mulai,'%H:%i'), '-', TIME_FORMAT(j.jam_selesai,'%H:%i'), ' (', k.nama_kelas, ')') AS label
    FROM jadwal j
    JOIN courses c ON c.id = j.course_id
    JOIN kelas k ON k.id = j.kelas_id
    ORDER BY j.hari, j.jam_mulai
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId   = (int)($_POST['user_id'] ?? 0);
    $courseId = (int)($_POST['course_id'] ?? 0);
    $jadwalId = $_POST['jadwal_id'] !== '' ? (int)$_POST['jadwal_id'] : null;
    $tanggal  = $_POST['tanggal'] ?? '';
    $status   = $_POST['status'] ?? 'hadir';
    $ket      = trim($_POST['keterangan'] ?? '');

    if ($userId && $courseId && $tanggal) {
        $stmt = db_prepare($koneksi, "INSERT INTO absensi (user_id, course_id, jadwal_id, tanggal, status, keterangan) VALUES (?,?,?,?,?,?)");
        db_stmt_bind_param($stmt, 'iiisss', $userId, $courseId, $jadwalId, $tanggal, $status, $ket);
        db_stmt_execute($stmt);
        header('Location: layout.php?page=absensi&sukses=1');
        exit;
    }
    $error = 'Mahasiswa, course, dan tanggal wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Absensi</h1>
    <a href="layout.php?page=absensi" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>
<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Mahasiswa</label>
                <select name="user_id" class="form-control" required>
                    <option value="">-- Pilih Mahasiswa --</option>
                    <?php while ($m = db_fetch_assoc($mahasiswaList)): ?>
                        <option value="<?php echo e($m['id']); ?>" <?php echo ($_POST['user_id'] ?? '') == $m['id'] ? 'selected' : ''; ?>>
                            <?php echo e($m['nama_lengkap']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Mata Kuliah / Course</label>
                <select name="course_id" class="form-control" required>
                    <option value="">-- Pilih Course --</option>
                    <?php while ($c = db_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($c['id']); ?>" <?php echo ($_POST['course_id'] ?? '') == $c['id'] ? 'selected' : ''; ?>>
                            <?php echo e($c['judul']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Jadwal (Opsional)</label>
                <select name="jadwal_id" class="form-control">
                    <option value="">-- Pilih Jadwal --</option>
                    <?php while ($j = db_fetch_assoc($jadwalList)): ?>
                        <option value="<?php echo e($j['id']); ?>" <?php echo ($_POST['jadwal_id'] ?? '') == $j['id'] ? 'selected' : ''; ?>>
                            <?php echo e($j['label']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Tanggal</label>
                <input type="date" name="tanggal" class="form-control" required value="<?php echo e($_POST['tanggal'] ?? date('Y-m-d')); ?>">
            </div>
            <div class="form-group">
                <label>Status Kehadiran</label>
                <select name="status" class="form-control" required>
                    <?php foreach (['hadir','izin','sakit','alpha'] as $s): ?>
                        <option value="<?php echo $s; ?>" <?php echo ($_POST['status'] ?? 'hadir') === $s ? 'selected' : ''; ?>>
                            <?php echo ucfirst($s); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control" placeholder="Opsional" value="<?php echo e($_POST['keterangan'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
