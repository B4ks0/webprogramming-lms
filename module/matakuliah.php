<?php
$userId = (int) ($_SESSION['user_id'] ?? 0);
$role = $_SESSION['role'] ?? 'mahasiswa';

if ($role === 'dosen') {
    $stmt = db_prepare($koneksi, "SELECT c.*, u.nama_lengkap AS dosen, cat.nama_kategori, COUNT(e.id) AS jumlah_mahasiswa FROM courses c JOIN users u ON u.id = c.teacher_id LEFT JOIN categories cat ON cat.id = c.category_id LEFT JOIN enrollments e ON e.course_id = c.id WHERE c.teacher_id = ? GROUP BY c.id ORDER BY c.created_at DESC");
    db_stmt_bind_param($stmt, "i", $userId);
    db_stmt_execute($stmt);
    $courses = db_stmt_get_result($stmt);
} elseif ($role === 'mahasiswa') {
    $stmt = db_prepare($koneksi, "SELECT c.*, u.nama_lengkap AS dosen, cat.nama_kategori, COUNT(e2.id) AS jumlah_mahasiswa FROM courses c JOIN users u ON u.id = c.teacher_id LEFT JOIN categories cat ON cat.id = c.category_id JOIN enrollments e ON e.course_id = c.id AND e.user_id = ? LEFT JOIN enrollments e2 ON e2.course_id = c.id GROUP BY c.id ORDER BY c.created_at DESC");
    db_stmt_bind_param($stmt, "i", $userId);
    db_stmt_execute($stmt);
    $courses = db_stmt_get_result($stmt);
} else {
    $courses = db_query($koneksi, "SELECT c.*, u.nama_lengkap AS dosen, cat.nama_kategori, COUNT(e.id) AS jumlah_mahasiswa FROM courses c JOIN users u ON u.id = c.teacher_id LEFT JOIN categories cat ON cat.id = c.category_id LEFT JOIN enrollments e ON e.course_id = c.id GROUP BY c.id ORDER BY c.created_at DESC");
}

$enrolled = [];
if ($role === 'mahasiswa') {
    $stmt = db_prepare($koneksi, "SELECT course_id, status_belajar FROM enrollments WHERE user_id = ?");
    db_stmt_bind_param($stmt, "i", $userId);
    db_stmt_execute($stmt);
    $result = db_stmt_get_result($stmt);
    while ($row = db_fetch_assoc($result)) {
        $enrolled[(int) $row['course_id']] = $row['status_belajar'];
    }
}
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Mata Kuliah</h1>
    <?php if ($role === 'admin' || $role === 'dosen'): ?>
        <a href="layout.php?page=tambah_mk" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Data berhasil diproses.</div>
<?php endif; ?>

<div class="row">
    <?php while ($course = db_fetch_assoc($courses)): ?>
        <?php
        $courseId = (int) $course['id'];
        $studentStatus = $enrolled[$courseId] ?? null;
        ?>
        <div class="col-xl-4 col-lg-6 mb-4">
            <div class="card shadow h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h2 class="h5 text-gray-900 mb-0"><?php echo e($course['judul']); ?></h2>
                        <span class="badge badge-<?php echo $course['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($course['status']); ?></span>
                    </div>
                    <p class="text-muted mb-2"><?php echo e($course['nama_kategori'] ?? 'Tanpa kategori'); ?></p>
                    <p class="mb-3"><?php echo e($course['deskripsi']); ?></p>
                    <div class="small text-gray-700 mt-auto">
                        <div><i class="fas fa-user-tie"></i> <?php echo e($course['dosen']); ?></div>
                        <div><i class="fas fa-users"></i> <?php echo e($course['jumlah_mahasiswa']); ?> mahasiswa</div>
                    </div>

                    <div class="mt-3">
                        <a href="layout.php?page=materi&course_id=<?php echo e($courseId); ?>" class="btn btn-info btn-sm">Materi</a>
                        <a href="layout.php?page=tugas&course_id=<?php echo e($courseId); ?>" class="btn btn-secondary btn-sm">Tugas</a>
                        <?php if ($role === 'admin'): ?>
                            <a href="layout.php?page=peserta&course_id=<?php echo e($courseId); ?>" class="btn btn-success btn-sm">Peserta</a>
                            <a href="layout.php?page=ubah_mk&id=<?php echo e($courseId); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/hapus.php?id=<?php echo e($courseId); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus mata kuliah ini?')">Hapus</a>
                        <?php elseif ($role === 'mahasiswa'): ?>
                            <?php if ($studentStatus === 'aktif'): ?>
                                <span class="badge badge-info mr-2">Sedang belajar</span>
                            <?php else: ?>
                                <span class="badge badge-success">Selesai</span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge badge-light mr-2">Kelas Anda</span>
                            <a href="layout.php?page=peserta&course_id=<?php echo e($courseId); ?>" class="btn btn-success btn-sm">Peserta</a>
                            <a href="layout.php?page=ubah_mk&id=<?php echo e($courseId); ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="admin/hapus.php?id=<?php echo e($courseId); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus mata kuliah ini?')">Hapus</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endwhile; ?>
</div>
