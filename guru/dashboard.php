<?php
$userId = (int) $_SESSION['user_id'];
$stmt = mysqli_prepare($koneksi, "SELECT COUNT(*) total FROM courses WHERE teacher_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$totalCourses = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'] ?? 0;

$stmt = mysqli_prepare($koneksi, "SELECT COUNT(e.id) total FROM enrollments e JOIN courses c ON c.id = e.course_id WHERE c.teacher_id = ?");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$totalStudents = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt))['total'] ?? 0;

$stmt = mysqli_prepare($koneksi, "SELECT c.id, c.judul, c.status, COUNT(e.id) jumlah_mahasiswa FROM courses c LEFT JOIN enrollments e ON e.course_id = c.id WHERE c.teacher_id = ? GROUP BY c.id ORDER BY c.created_at DESC");
mysqli_stmt_bind_param($stmt, "i", $userId);
mysqli_stmt_execute($stmt);
$courses = mysqli_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Dosen</h1>
    <div>
        <a href="layout.php?page=peserta" class="btn btn-success btn-sm">Kelola Peserta</a>
        <a href="layout.php?page=tambah_mk" class="btn btn-primary btn-sm">Buat Mata Kuliah</a>
        <a href="layout.php?page=matakuliah" class="btn btn-outline-primary btn-sm">Lihat Mata Kuliah</a>
    </div>
</div>

<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mata Kuliah Diampu</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalCourses); ?></div></div></div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Mahasiswa</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalStudents); ?></div></div></div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Kelas Saya</h2></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead><tr><th>Mata Kuliah</th><th>Status</th><th>Mahasiswa</th><th>Aksi</th></tr></thead>
                <tbody>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                    <tr>
                        <td><?php echo e($course['judul']); ?></td>
                        <td><?php echo e($course['status']); ?></td>
                        <td><?php echo e($course['jumlah_mahasiswa']); ?></td>
                        <td><a href="layout.php?page=peserta&course_id=<?php echo e($course['id']); ?>" class="btn btn-sm btn-success">Peserta</a></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
