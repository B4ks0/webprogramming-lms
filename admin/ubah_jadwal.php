<?php
$id = (int)($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM jadwal WHERE id = ?");
db_stmt_bind_param($stmt, 'i', $id);
db_stmt_execute($stmt);
$result = db_stmt_get_result($stmt);
$jadwal = db_fetch_assoc($result);

if (!$jadwal) {
    header('Location: layout.php?page=jadwal');
    exit;
}

$courses = db_query($koneksi, "SELECT id, judul FROM courses ORDER BY judul ASC");
$kelasList = db_query($koneksi, "SELECT id, nama_kelas FROM kelas ORDER BY nama_kelas ASC");
$hariList = ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $courseId   = (int)($_POST['course_id'] ?? 0);
    $kelasId    = (int)($_POST['kelas_id'] ?? 0);
    $hari       = $_POST['hari'] ?? '';
    $jamMulai   = $_POST['jam_mulai'] ?? '';
    $jamSelesai = $_POST['jam_selesai'] ?? '';
    $ruangan    = trim($_POST['ruangan'] ?? '');

    if ($courseId && $kelasId && $hari && $jamMulai && $jamSelesai) {
        $stmt2 = db_prepare($koneksi, "UPDATE jadwal SET course_id=?, kelas_id=?, hari=?, jam_mulai=?, jam_selesai=?, ruangan=? WHERE id=?");
        db_stmt_bind_param($stmt2, 'iissssi', $courseId, $kelasId, $hari, $jamMulai, $jamSelesai, $ruangan, $id);
        db_stmt_execute($stmt2);
        header('Location: layout.php?page=jadwal&sukses=1');
        exit;
    }
    $error = 'Semua field wajib diisi.';
}

$post = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST : $jadwal;
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Jadwal</h1>
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
                        <option value="<?php echo e($c['id']); ?>" <?php echo $post['course_id'] == $c['id'] ? 'selected' : ''; ?>>
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
                        <option value="<?php echo e($k['id']); ?>" <?php echo $post['kelas_id'] == $k['id'] ? 'selected' : ''; ?>>
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
                        <option value="<?php echo $h; ?>" <?php echo $post['hari'] === $h ? 'selected' : ''; ?>>
                            <?php echo $h; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Mulai</label>
                        <input type="time" name="jam_mulai" class="form-control" required value="<?php echo e(substr($post['jam_mulai'],0,5)); ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Jam Selesai</label>
                        <input type="time" name="jam_selesai" class="form-control" required value="<?php echo e(substr($post['jam_selesai'],0,5)); ?>">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>Ruangan</label>
                <input type="text" name="ruangan" class="form-control" value="<?php echo e($post['ruangan'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
