<?php
$userId = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) total FROM enrollments WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$totalEnrollments = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'] ?? 0;

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) total FROM enrollments WHERE user_id = ? AND status_belajar = 'selesai'");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$completed = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'] ?? 0;

$stmt = mysqli_prepare($koneksi, "SELECT c.judul, u.nama_lengkap AS dosen, e.status_belajar, e.nilai_akhir, e.catatan_dosen, e.tgl_daftar FROM enrollments e JOIN courses c ON c.id = e.course_id JOIN users u ON u.id = c.teacher_id WHERE e.user_id = ? ORDER BY e.tgl_daftar DESC");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$courses = mysqli_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Mahasiswa</h1>
    <a href="layout.php?page=matakuliah" class="btn btn-primary btn-sm">Mata Kuliah Saya</a>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mata Kuliah Diikuti</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalEnrollments); ?></div></div></div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">Selesai</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($completed); ?></div></div></div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Progres Belajar Saya</h2></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead><tr><th>Mata Kuliah</th><th>Dosen</th><th>Status</th><th>Nilai</th><th>Catatan</th><th>Tanggal Daftar</th></tr></thead>
                <tbody>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                    <tr>
                        <td><?php echo e($course['judul']); ?></td>
                        <td><?php echo e($course['dosen']); ?></td>
                        <td><span class="badge badge-<?php echo $course['status_belajar'] === 'selesai' ? 'success' : 'info'; ?>"><?php echo e($course['status_belajar']); ?></span></td>
                        <td><?php echo $course['nilai_akhir'] !== null ? e($course['nilai_akhir']) : '-'; ?></td>
                        <td><?php echo e($course['catatan_dosen'] ?? '-'); ?></td>
                        <td><?php echo e($course['tgl_daftar']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
