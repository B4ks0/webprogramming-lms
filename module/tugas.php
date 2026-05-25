<?php
require_once __DIR__ . '/_akademik.php';

$role = $_SESSION['role'] ?? 'mahasiswa';
$courseId = (int) ($_GET['course_id'] ?? 0);
$coursesForFilter = course_query_for_role($koneksi);

if ($role === 'admin') {
    $sql = "SELECT a.*, c.judul AS course_title, u.nama_lengkap AS dosen FROM assignments a JOIN courses c ON c.id = a.course_id JOIN users u ON u.id = c.teacher_id";
    $params = [];
    $types = "";
} elseif ($role === 'dosen') {
    $sql = "SELECT a.*, c.judul AS course_title, u.nama_lengkap AS dosen FROM assignments a JOIN courses c ON c.id = a.course_id JOIN users u ON u.id = c.teacher_id WHERE c.teacher_id = ?";
    $params = [(int) $_SESSION['user_id']];
    $types = "i";
} else {
    $sql = "SELECT a.*, c.judul AS course_title, u.nama_lengkap AS dosen, s.status AS submit_status, s.nilai FROM assignments a JOIN courses c ON c.id = a.course_id JOIN users u ON u.id = c.teacher_id JOIN enrollments e ON e.course_id = c.id LEFT JOIN assignment_submissions s ON s.assignment_id = a.id AND s.user_id = e.user_id WHERE e.user_id = ?";
    $params = [(int) $_SESSION['user_id']];
    $types = "i";
}

if ($courseId > 0) {
    $sql .= ($params ? " AND" : " WHERE") . " c.id = ?";
    $params[] = $courseId;
    $types .= "i";
}
$sql .= " ORDER BY a.deadline ASC, a.created_at DESC";

$stmt = db_prepare($koneksi, $sql);
if ($params) {
    db_stmt_bind_param($stmt, $types, ...$params);
}
db_stmt_execute($stmt);
$assignments = db_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tugas</h1>
    <?php if (in_array($role, ['admin', 'dosen'], true)): ?>
        <a href="layout.php?page=tambah_tugas" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Buat Tugas</a>
    <?php endif; ?>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Tugas berhasil diproses.</div>
<?php endif; ?>

<form class="card shadow mb-4" method="get">
    <input type="hidden" name="page" value="tugas">
    <div class="card-body">
        <div class="form-row align-items-end">
            <div class="col-md-8">
                <label>Filter Mata Kuliah</label>
                <select name="course_id" class="form-control">
                    <option value="0">Semua mata kuliah</option>
                    <?php while ($course = db_fetch_assoc($coursesForFilter)): ?>
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
                        <th>Tugas</th>
                        <th>Deadline</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($assignment = db_fetch_assoc($assignments)): ?>
                    <?php
                    $isLate = strtotime($assignment['deadline']) < time();
                    $submitStatus = $assignment['submit_status'] ?? null;
                    ?>
                    <tr>
                        <td><?php echo e($assignment['course_title']); ?><br><small><?php echo e($assignment['dosen']); ?></small></td>
                        <td>
                            <strong><?php echo e($assignment['judul_tugas']); ?></strong>
                            <div class="small text-gray-700"><?php echo nl2br(e($assignment['deskripsi'])); ?></div>
                            <?php if ($assignment['file_path']): ?>
                                <a href="<?php echo e($assignment['file_path']); ?>" target="_blank" class="btn btn-sm btn-outline-primary mt-2">Download File Tugas</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php echo e($assignment['deadline']); ?><br>
                            <span class="badge badge-<?php echo $isLate ? 'danger' : 'success'; ?>"><?php echo $isLate ? 'Lewat deadline' : 'Aktif'; ?></span>
                        </td>
                        <td>
                            <?php if ($role === 'mahasiswa'): ?>
                                <?php if ($submitStatus === 'reviewed'): ?>
                                    <span class="badge badge-success">Dinilai: <?php echo e($assignment['nilai']); ?></span>
                                <?php elseif ($submitStatus === 'submitted'): ?>
                                    <span class="badge badge-info">Sudah submit</span>
                                <?php else: ?>
                                    <span class="badge badge-secondary">Belum submit</span>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="layout.php?page=cek_tugas&id=<?php echo e($assignment['id']); ?>" class="btn btn-info btn-sm">Cek Submission</a>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (in_array($role, ['admin', 'dosen'], true)): ?>
                                <a href="layout.php?page=ubah_tugas&id=<?php echo e($assignment['id']); ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="module/hapus_tugas.php?id=<?php echo e($assignment['id']); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
                            <?php else: ?>
                                <a href="layout.php?page=submit_tugas&id=<?php echo e($assignment['id']); ?>" class="btn btn-primary btn-sm"><?php echo $submitStatus ? 'Update Submit' : 'Submit Tugas'; ?></a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
