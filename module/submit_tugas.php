<?php
require_once __DIR__ . '/_akademik.php';
$id = (int) ($_GET['id'] ?? 0);
$userId = (int) $_SESSION['user_id'];
$stmt = db_prepare($koneksi, "SELECT a.*, c.judul AS course_title FROM assignments a JOIN courses c ON c.id = a.course_id WHERE a.id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$assignment = db_fetch_assoc(db_stmt_get_result($stmt));

if (!$assignment || !can_view_course($koneksi, (int) $assignment['course_id'])) {
    echo '<div class="alert alert-danger">Tugas tidak ditemukan atau belum dienroll.</div>';
    return;
}

$stmt = db_prepare($koneksi, "SELECT * FROM assignment_submissions WHERE assignment_id = ? AND user_id = ?");
db_stmt_bind_param($stmt, "ii", $id, $userId);
db_stmt_execute($stmt);
$submission = db_fetch_assoc(db_stmt_get_result($stmt));
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Submit Tugas</h1>
    <a href="layout.php?page=tugas" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <h2 class="h5"><?php echo e($assignment['judul_tugas']); ?></h2>
        <p class="mb-1"><strong>Mata Kuliah:</strong> <?php echo e($assignment['course_title']); ?></p>
        <p class="mb-3"><strong>Deadline:</strong> <?php echo e($assignment['deadline']); ?></p>
        <p><?php echo nl2br(e($assignment['deskripsi'])); ?></p>
        <?php if ($submission): ?>
            <div class="alert alert-info">
                Submission terakhir: <?php echo e($submission['submitted_at']); ?>.
                Status: <?php echo e($submission['status']); ?>
                <?php if ($submission['nilai'] !== null): ?>, Nilai: <?php echo e($submission['nilai']); ?><?php endif; ?>
            </div>
        <?php endif; ?>
        <form action="module/proses_submit_tugas.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="assignment_id" value="<?php echo e($assignment['id']); ?>">
            <div class="form-group">
                <label>File Jawaban</label>
                <input type="file" name="file_jawaban" class="form-control-file" required>
            </div>
            <div class="form-group">
                <label>Catatan</label>
                <textarea name="catatan" class="form-control" rows="3"><?php echo e($submission['catatan'] ?? ''); ?></textarea>
            </div>
            <button class="btn btn-primary" type="submit">Kirim Tugas</button>
        </form>
    </div>
</div>
