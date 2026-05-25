<?php
require_once __DIR__ . '/_akademik.php';

$role = $_SESSION['role'] ?? 'mahasiswa';
$courseId = (int) ($_GET['course_id'] ?? 0);
$coursesForFilter = course_query_for_role($koneksi);

if ($role === 'admin') {
    $sql = "SELECT l.*, c.judul AS course_title, u.nama_lengkap AS dosen FROM lessons l JOIN courses c ON c.id = l.course_id JOIN users u ON u.id = c.teacher_id";
    $params = [];
    $types = "";
} elseif ($role === 'dosen') {
    $sql = "SELECT l.*, c.judul AS course_title, u.nama_lengkap AS dosen FROM lessons l JOIN courses c ON c.id = l.course_id JOIN users u ON u.id = c.teacher_id WHERE c.teacher_id = ?";
    $params = [(int) $_SESSION['user_id']];
    $types = "i";
} else {
    $sql = "SELECT l.*, c.judul AS course_title, u.nama_lengkap AS dosen FROM lessons l JOIN courses c ON c.id = l.course_id JOIN users u ON u.id = c.teacher_id JOIN enrollments e ON e.course_id = c.id WHERE e.user_id = ?";
    $params = [(int) $_SESSION['user_id']];
    $types = "i";
}

if ($courseId > 0) {
    $sql .= ($params ? " AND" : " WHERE") . " c.id = ?";
    $params[] = $courseId;
    $types .= "i";
}
$sql .= " ORDER BY c.judul, l.urutan, l.created_at DESC";

$stmt = mysqli_prepare($koneksi, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$materials = mysqli_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Materi Kuliah</h1>
    <?php if (in_array($role, ['admin', 'dosen'], true)): ?>
        <a href="layout.php?page=tambah_materi" class="btn btn-primary btn-sm"><i class="fas fa-upload"></i> Upload Materi</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Materi berhasil diproses.</div>
<?php endif; ?>

<form class="card shadow mb-4" method="get">
    <input type="hidden" name="page" value="materi">
    <div class="card-body">
        <div class="form-row align-items-end">
            <div class="col-md-8">
                <label>Filter Mata Kuliah</label>
                <select name="course_id" class="form-control">
                    <option value="0">Semua mata kuliah</option>
                    <?php while ($course = mysqli_fetch_assoc($coursesForFilter)): ?>
                        <option value="<?php echo e($course['id']); ?>" <?php echo $courseId === (int) $course['id'] ? 'selected' : ''; ?>><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="col-md-4 mt-3 mt-md-0">
                <button class="btn btn-primary" type="submit">Tampilkan</button>
            </div>
        </div>
    </div>
</form>

<div class="card shadow mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Mata Kuliah</th>
                        <th>Materi</th>
                        <th>Urutan</th>
                        <th>File/Video</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($material = mysqli_fetch_assoc($materials)): ?>
                    <tr>
                        <td><?php echo e($material['course_title']); ?><br><small><?php echo e($material['dosen']); ?></small></td>
                        <td>
                            <strong><?php echo e($material['judul_materi']); ?></strong>
                            <div class="small text-gray-700"><?php echo nl2br(e($material['konten_teks'])); ?></div>
                        </td>
                        <td><?php echo e($material['urutan']); ?></td>
                        <td>
                            <?php if ($material['file_path']): ?>
                                <a href="<?php echo e($material['file_path']); ?>" target="_blank" class="btn btn-sm btn-outline-primary mb-1">Download</a>
                            <?php endif; ?>
                            <?php if ($material['video_url']): ?>
                                <a href="<?php echo e($material['video_url']); ?>" target="_blank" class="btn btn-sm btn-outline-info mb-1">Video</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (in_array($role, ['admin', 'dosen'], true)): ?>
                                <a href="layout.php?page=ubah_materi&id=<?php echo e($material['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="module/hapus_materi.php?id=<?php echo e($material['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus materi ini?')">Hapus</a>
                            <?php else: ?>
                                <span class="badge badge-success">Bisa diakses</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
