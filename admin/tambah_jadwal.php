<?php
$courses = db_query($koneksi, "SELECT id, judul FROM courses ORDER BY judul ASC");
$kelasList = db_query($koneksi, "SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId = (int)($_POST['course_id'] ?? 0);
    $kelasId  = (int)($_POST['kelas_id'] ?? 0);
    $hari     = $_POST['hari'] ?? '';
    $jamMulai = $_POST['jam_mulai'] ?? '';
    $jamSelesai = $_POST['jam_selesai'] ?? '';
    $ruangan  = trim($_POST['ruangan'] ?? '');

    if ($courseId && $kelasId && $hari && $jamMulai && $jamSelesai) {
        $stmt = db_prepare($koneksi, "INSERT INTO jadwal (course_id, kelas_id, hari, jam_mulai, jam_selesai, ruangan) VALUES (?, ?, ?, ?, ?, ?)");
        db_stmt_bind_param($stmt, 'iissss', $courseId, $kelasId, $hari, $jamMulai, $jamSelesai, $ruangan);
        db_stmt_execute($stmt);
        header('Location: layout.php?page=jadwal&sukses=1');
        exit;
    }
    $error = 'Semua field wajib diisi.';
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Jadwal</h1>
    <a href="layout.php?page=jadwal" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <?php if (!empty($error)): ?><div class="alert alert-danger"><?php echo e($error); ?></div><?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label>Course</label>
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
                <label>Ruang Kelas</label>
                <select name="kelas_id" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php while ($k = db_fetch_assoc($kelasList)): ?>
                        <option value="<?php echo e($k['id']); ?>" <?php echo ($_POST['kelas_id'] ?? '') == $k['id'] ? 'selected' : ''; ?>>
                            <?php echo e($k['nama_kelas']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Hari</label>
                <select name="hari" class="form-control" required>
                    <option value="">-- Pilih Hari --</option>
                    <?php foreach ($hariList as $h): ?>
                        <option value="<?php echo $h; ?>" <?php echo ($_POST['hari'] ?? '') === $h ? 'selected' : ''; ?>>
                            <?php echo $h; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required value="<?php echo e($_POST['jam_mulai'] ?? ''); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required value="<?php echo e($_POST['jam_selesai'] ?? ''); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Ruangan</label>
                <input type="text" name="ruangan" class="form-control" placeholder="cth: Lab 1, Gedung A-101" value="<?php echo e($_POST['ruangan'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
</div>
