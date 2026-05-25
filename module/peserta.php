<?php
require_once __DIR__ . '/_akademik.php';

$courseId = (int) ($_GET['course_id'] ?? 0);
$courses = course_query_for_role($koneksi);

if ($courseId === 0) {
    $firstCourse = mysqli_fetch_assoc($courses);
    if ($firstCourse) {
        $courseId = (int) $firstCourse['id'];
    }
    $courses = course_query_for_role($koneksi);
}

if ($courseId > 0 && !can_manage_course($koneksi, $courseId)) {
    echo '<div class="alert alert-danger">Mata kuliah tidak bisa diakses.</div>';
    return;
}

$students = mysqli_query($koneksi, "SELECT id, nama_lengkap, email FROM users WHERE role='mahasiswa' ORDER BY nama_lengkap");

$stmt = mysqli_prepare($koneksi, "SELECT e.*, u.nama_lengkap, u.email FROM enrollments e JOIN users u ON u.id = e.user_id WHERE e.course_id = ? ORDER BY u.nama_lengkap");
mysqli_stmt_bind_param($stmt, "i", $courseId);
mysqli_stmt_execute($stmt);
$participants = mysqli_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Peserta Mata Kuliah</h1>
    <a href="layout.php?page=matakuliah" class="btn btn-secondary btn-sm">Kembali ke MK</a>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Data peserta berhasil diproses.</div>
<?php endif; ?>

<form class="card shadow mb-4" method="get">
    <input type="hidden" name="page" value="peserta">
    <div class="card-body">
        <div class="form-row align-items-end">
            <div class="col-md-8">
                <label>Mata Kuliah</label>
                <select name="course_id" class="form-control">
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($course['id']); ?>" <?php echo $courseId === (int) $course['id'] ? 'selected' : ''; ?>><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <button class="btn btn-primary" type="submit">Pilih MK</button>
            </div>
        </div>
    </div>
</form>

<?php if ($courseId > 0): ?>
<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Enroll Mahasiswa</h2></div>
    <div class="card-body">
        <form action="module/simpan_peserta.php" method="post">
            <input type="hidden" name="course_id" value="<?php echo e($courseId); ?>">
            <div class="form-row align-items-end">
                <div class="col-md-8">
                    <label>Mahasiswa</label>
                    <select name="user_id" class="form-control" required>
                        <?php while ($student = mysqli_fetch_assoc($students)): ?>
                            <option value="<?php echo e($student['id']); ?>"><?php echo e($student['nama_lengkap']); ?> - <?php echo e($student['email']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-md-4 mt-3 mt-md-0">
                    <button class="btn btn-primary" type="submit">Tambahkan ke MK</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Daftar Peserta</h2></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Status</th>
                        <th>Nilai Akhir</th>
                        <th>Catatan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($participant = mysqli_fetch_assoc($participants)): ?>
                    <tr>
                        <td><?php echo e($participant['nama_lengkap']); ?><br><small><?php echo e($participant['email']); ?></small></td>
                        <td>
                            <form action="module/update_peserta.php" method="post" class="mb-0">
                                <input type="hidden" name="id" value="<?php echo e($participant['id']); ?>">
                                <input type="hidden" name="course_id" value="<?php echo e($courseId); ?>">
                                <select name="status_belajar" class="form-control form-control-sm">
                                    <option value="aktif" <?php echo $participant['status_belajar'] === 'aktif' ? 'selected' : ''; ?>>Belum selesai</option>
                                    <option value="selesai" <?php echo $participant['status_belajar'] === 'selesai' ? 'selected' : ''; ?>>Selesai</option>
                                </select>
                        </td>
                        <td>
                                <input type="number" name="nilai_akhir" class="form-control form-control-sm" min="0" max="100" step="0.01" value="<?php echo e($participant['nilai_akhir']); ?>">
                        </td>
                        <td>
                                <textarea name="catatan_dosen" class="form-control form-control-sm" rows="2"><?php echo e($participant['catatan_dosen']); ?></textarea>
                        </td>
                        <td>
                                <button class="btn btn-success btn-sm mb-1" type="submit">Simpan</button>
                            </form>
                            <a href="module/hapus_peserta.php?id=<?php echo e($participant['id']); ?>&course_id=<?php echo e($courseId); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus mahasiswa dari MK ini?')">Hapus</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php endif; ?>
