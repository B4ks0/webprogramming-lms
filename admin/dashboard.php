<?php
$totalUsers     = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM users"))['total'] ?? 0;
$totalMahasiswa = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM users WHERE role='mahasiswa'"))['total'] ?? 0;
$totalDosen     = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM users WHERE role='dosen'"))['total'] ?? 0;
$totalEnrollments = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM enrollments"))['total'] ?? 0;
$totalCourses   = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM courses"))['total'] ?? 0;
$coursePublished = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM courses WHERE status='published'"))['total'] ?? 0;
$courseDraft    = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM courses WHERE status='draft'"))['total'] ?? 0;
$totalLessons   = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM lessons"))['total'] ?? 0;

$latestCourses = db_query($koneksi, "SELECT c.id, c.judul, c.status, u.nama_lengkap AS dosen FROM courses c JOIN users u ON u.id = c.teacher_id ORDER BY c.created_at DESC LIMIT 5");
$latestEnrollments = db_query($koneksi, "SELECT u.nama_lengkap AS mahasiswa, c.judul AS course, e.status_belajar FROM enrollments e JOIN users u ON u.id = e.user_id JOIN courses c ON c.id = e.course_id ORDER BY e.tgl_daftar DESC LIMIT 5");
?>

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Row 1 Stats -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Users</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalUsers); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Mahasiswa</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalMahasiswa); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-user-graduate fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Dosen</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalDosen); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Enrollments</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalEnrollments); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Row 2 Stats -->
<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Courses</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalCourses); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-graduation-cap fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Course Published</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($coursePublished); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-check-circle fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Course Draft</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($courseDraft); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-edit fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Lessons</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalLessons); ?></div>
                    </div>
                    <div class="col-auto"><i class="fas fa-book-open fa-2x text-gray-300"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tables Row -->
<div class="row">
    <!-- Course Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Course Terbaru</h6>
                <a href="layout.php?page=matakuliah" class="btn btn-primary btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr><th>Judul</th><th>Dosen</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        <?php while ($c = db_fetch_assoc($latestCourses)): ?>
                            <tr>
                                <td><?php echo e($c['judul']); ?></td>
                                <td><?php echo e($c['dosen']); ?></td>
                                <td><span class="badge badge-<?php echo $c['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($c['status']); ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Enrollment Terbaru -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-success">Enrollment Terbaru</h6>
                <a href="layout.php?page=peserta" class="btn btn-success btn-sm">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered mb-0">
                        <thead class="thead-light">
                            <tr><th>Mahasiswa</th><th>Course</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                        <?php while ($e = db_fetch_assoc($latestEnrollments)): ?>
                            <tr>
                                <td><?php echo e($e['mahasiswa']); ?></td>
                                <td><?php echo e($e['course']); ?></td>
                                <td><span class="badge badge-<?php echo $e['status_belajar'] === 'selesai' ? 'success' : 'info'; ?>"><?php echo e($e['status_belajar']); ?></span></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
