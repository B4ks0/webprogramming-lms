<?php
$totalCourses = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM courses"))['total'] ?? 0;
$totalDosen = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM users WHERE role='dosen'"))['total'] ?? 0;
$totalMahasiswa = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM users WHERE role='mahasiswa'"))['total'] ?? 0;
$totalEnrollments = db_fetch_assoc(db_query($koneksi, "SELECT COUNT(*) total FROM enrollments"))['total'] ?? 0;
$latestCourses = db_query($koneksi, "SELECT c.id, c.judul, c.status, u.nama_lengkap AS dosen FROM courses c JOIN users u ON u.id = c.teacher_id ORDER BY c.created_at DESC LIMIT 5");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard Admin</h1>
    <div>
        <a href="layout.php?page=users" class="btn btn-outline-primary btn-sm"><i class="fas fa-users-cog"></i> Kelola User</a>
        <a href="layout.php?page=peserta" class="btn btn-outline-success btn-sm"><i class="fas fa-user-graduate"></i> Kelola Peserta</a>
        <a href="layout.php?page=tambah_mk" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Mata Kuliah</a>
    </div>
</div>

<div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Mata Kuliah</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalCourses); ?></div></div></div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-success text-uppercase mb-1">Dosen</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalDosen); ?></div></div></div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-info text-uppercase mb-1">Mahasiswa</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalMahasiswa); ?></div></div></div>
    </div>
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2"><div class="card-body"><div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Enrollment</div><div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo e($totalEnrollments); ?></div></div></div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h2 class="h6 m-0 font-weight-bold text-primary">Mata Kuliah Terbaru</h2>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead><tr><th>Mata Kuliah</th><th>Dosen</th><th>Status</th><th>Aksi</th></tr></thead>
                <tbody>
                <?php while ($course = db_fetch_assoc($latestCourses)): ?>
                    <tr>
                        <td><?php echo e($course['judul']); ?></td>
                        <td><?php echo e($course['dosen']); ?></td>
                        <td><span class="badge badge-<?php echo $course['status'] === 'published' ? 'success' : 'secondary'; ?>"><?php echo e($course['status']); ?></span></td>
                        <td><a href="layout.php?page=ubah_mk&id=<?php echo e($course['id']); ?>" class="btn btn-sm btn-warning">Edit</a></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
