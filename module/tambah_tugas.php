<?php
require_once __DIR__ . '/_akademik.php';
$courses = course_query_for_role($koneksi);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Buat Tugas</h1>
    <a href="layout.php?page=tugas" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="module/simpan_tugas.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="course_id" class="form-control" required>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($course['id']); ?>"><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Judul Tugas</label>
                <input type="text" name="judul_tugas" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Tugas</label>
                <textarea name="deskripsi" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>File Tugas</label>
                <input type="file" name="file_tugas" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Deadline</label>
                <input type="datetime-local" name="deadline" class="form-control" required>
            </div>
            <button class="btn btn-primary" type="submit">Simpan Tugas</button>
        </form>
    </div>
</div>
