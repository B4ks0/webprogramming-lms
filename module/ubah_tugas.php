<?php
require_once __DIR__ . '/_akademik.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = mysqli_prepare($koneksi, "SELECT * FROM assignments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$assignment = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$assignment || !can_manage_course($koneksi, (int) $assignment['course_id'])) {
    echo '<div class="alert alert-danger">Tugas tidak ditemukan atau tidak bisa diakses.</div>';
    return;
}

$courses = course_query_for_role($koneksi);
$deadlineValue = date('Y-m-d\TH:i', strtotime($assignment['deadline']));
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Tugas</h1>
    <a href="layout.php?page=tugas" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="module/edit_tugas.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo e($assignment['id']); ?>">
            <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="course_id" class="form-control" required>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($course['id']); ?>" <?php echo (int) $assignment['course_id'] === (int) $course['id'] ? 'selected' : ''; ?>><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" name="judul_tugas" class="form-control" value="<?php echo e($assignment['judul_tugas']); ?>" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Tugas</label>
                <textarea name="deskripsi" class="form-control" rows="4"><?php echo e($assignment['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Ganti File Tugas</label>
                <input type="file" name="file_tugas" class="form-control-file">
                <?php if ($assignment['file_path']): ?>
                    <small class="form-text text-muted">File saat ini: <?php echo e($assignment['file_path']); ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" name="deadline" class="form-control" value="<?php echo e($deadlineValue); ?>" required>
            </div>
            <button class="btn btn-primary" type="submit">Update Tugas</button>
        </form>
    </div>
</div>
