<?php
require_once __DIR__ . '/_akademik.php';
$assignmentId = (int) ($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT a.*, c.judul AS course_title FROM assignments a JOIN courses c ON c.id = a.course_id WHERE a.id = ?");
db_stmt_bind_param($stmt, "i", $assignmentId);
db_stmt_execute($stmt);
$assignment = db_fetch_assoc(db_stmt_get_result($stmt));

if (!$assignment || !can_manage_course($koneksi, (int) $assignment['course_id'])) {
    echo '<div class="alert alert-danger">Tugas tidak ditemukan atau tidak bisa dicek.</div>';
    return;
}

$stmt = db_prepare($koneksi, "SELECT s.*, u.nama_lengkap, u.email FROM assignment_submissions s JOIN users u ON u.id = s.user_id WHERE s.assignment_id = ? ORDER BY s.submitted_at DESC");
db_stmt_bind_param($stmt, "i", $assignmentId);
db_stmt_execute($stmt);
$submissions = db_stmt_get_result($stmt);

$stmt = db_prepare($koneksi, "SELECT u.nama_lengkap, u.email FROM enrollments e JOIN users u ON u.id = e.user_id LEFT JOIN assignment_submissions s ON s.assignment_id = ? AND s.user_id = u.id WHERE e.course_id = ? AND s.id IS NULL ORDER BY u.nama_lengkap");
db_stmt_bind_param($stmt, "ii", $assignmentId, $assignment['course_id']);
db_stmt_execute($stmt);
$missing = db_stmt_get_result($stmt);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Cek Submission Tugas</h1>
    <a href="layout.php?page=tugas" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<?php if (isset($_GET['pesan'])): ?>
    <div class="alert alert-success">Nilai dan feedback berhasil disimpan.</div>
<?php endif; ?>

<div class="card shadow mb-4">
    <div class="card-body">
        <h2 class="h5"><?php echo e($assignment['judul_tugas']); ?></h2>
        <p class="mb-1"><strong>Mata Kuliah:</strong> <?php echo e($assignment['course_title']); ?></p>
        <p class="mb-0"><strong>Deadline:</strong> <?php echo e($assignment['deadline']); ?></p>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-primary">Submission Mahasiswa</h2></div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered mb-0">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>File</th>
                        <th>Catatan</th>
                        <th>Waktu Submit</th>
                        <th>Nilai & Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($submission = db_fetch_assoc($submissions)): ?>
                    <tr>
                        <td><?php echo e($submission['nama_lengkap']); ?><br><small><?php echo e($submission['email']); ?></small></td>
                        <td><a href="<?php echo e($submission['file_path']); ?>" target="_blank" class="btn btn-sm btn-outline-primary">Download Jawaban</a></td>
                        <td><?php echo nl2br(e($submission['catatan'])); ?></td>
                        <td><?php echo e($submission['submitted_at']); ?><br><span class="badge badge-<?php echo $submission['status'] === 'reviewed' ? 'success' : 'info'; ?>"><?php echo e($submission['status']); ?></span></td>
                        <td>
                            <form action="module/nilai_tugas.php" method="post">
                                <input type="hidden" name="submission_id" value="<?php echo e($submission['id']); ?>">
                                <input type="hidden" name="assignment_id" value="<?php echo e($assignmentId); ?>">
                                <div class="form-group mb-2">
                                    <input type="number" name="nilai" class="form-control form-control-sm" min="0" max="100" step="0.01" value="<?php echo e($submission['nilai']); ?>" placeholder="Nilai">
                                </div>
                                <div class="form-group mb-2">
                                    <textarea name="feedback" class="form-control form-control-sm" rows="2" placeholder="Feedback"><?php echo e($submission['feedback']); ?></textarea>
                                </div>
                                <button class="btn btn-success btn-sm" type="submit">Simpan</button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3"><h2 class="h6 m-0 font-weight-bold text-danger">Belum Submit</h2></div>
    <div class="card-body">
        <?php if (db_num_rows($missing) === 0): ?>
            <p class="mb-0">Semua mahasiswa enroll sudah mengirim tugas.</p>
        <?php else: ?>
            <ul class="mb-0">
                <?php while ($student = db_fetch_assoc($missing)): ?>
                    <li><?php echo e($student['nama_lengkap']); ?> - <?php echo e($student['email']); ?></li>
                <?php endwhile; ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
