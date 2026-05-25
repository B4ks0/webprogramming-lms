<?php
require_once __DIR__ . '/_akademik.php';
$courses = course_query_for_role($koneksi);
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Upload Materi</h1>
    <a href="layout.php?page=materi" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="module/simpan_materi.php" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Mata Kuliah</label>
                <select name="course_id" class="form-control" required>
                    <?php while ($course = mysqli_fetch_assoc($courses)): ?>
                        <option value="<?php echo e($course['id']); ?>"><?php echo e($course['judul']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Judul Materi</label>
                <input type="text" name="judul_materi" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Konten Ringkas</label>
                <textarea name="konten_teks" class="form-control" rows="4"></textarea>
            </div>
            <div class="form-group">
                <label>URL Video</label>
                <input type="url" name="video_url" class="form-control">
            </div>
            <div class="form-group">
                <label>File Materi</label>
                <input type="file" name="file_materi" class="form-control-file">
            </div>
            <div class="form-group">
                <label>Urutan</label>
                <input type="number" name="urutan" class="form-control" value="1" min="0">
            </div>
            <button class="btn btn-primary" type="submit">Simpan Materi</button>
        </form>
    </div>
</div>
