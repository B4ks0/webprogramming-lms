<?php
require_once __DIR__ . '/_akademik.php';
$id = (int) ($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM lessons WHERE id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$material = db_fetch_assoc(db_stmt_get_result($stmt));

if (!$material || !can_manage_course($koneksi, (int) $material['course_id'])) {
    echo '<div class="alert alert-danger">Materi tidak ditemukan atau tidak bisa diakses.</div>';
    return;
}

$courses = course_query_for_role($koneksi);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Materi</h1>
    <a href="layout.php?page=materi" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="module/edit_materi.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo e($material['id']); ?>">
            <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="course_id" class="form-control" required>
                    <?php while ($course = db_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($course['id']); ?>" <?php echo (int) $material['course_id'] === (int) $course['id'] ? 'selected' : ''; ?>><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" name="judul_materi" class="form-control" value="<?php echo e($material['judul_materi']); ?>" required>
            </div>
            <div class="form-group">
                <label>Konten Ringkas</label>
                <textarea name="konten_teks" class="form-control" rows="4"><?php echo e($material['konten_teks']); ?></textarea>
            </div>
            <div class="form-group">
                <label>URL Video</label>
                <input type="url" name="video_url" class="form-control" value="<?php echo e($material['video_url']); ?>">
            </div>
            <div class="form-group">
                <label>Ganti File Materi</label>
                <input type="file" name="file_materi" class="form-control-file">
                <?php if ($material['file_path']): ?>
                    <small class="form-text text-muted">File saat ini: <?php echo e($material['file_path']); ?></small>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" value="<?php echo e($material['urutan']); ?>" min="0">
            </div>
            <button class="btn btn-primary" type="submit">Update Materi</button>
        </form>
    </div>
</div>
