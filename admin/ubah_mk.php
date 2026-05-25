<?php
$id = (int) ($_GET['id'] ?? 0);
$role = $_SESSION['role'] ?? '';
$userId = (int) ($_SESSION['user_id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM courses WHERE id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$course = db_fetch_assoc(db_stmt_get_result($stmt));

if (!$course || ($role === 'dosen' && (int) $course['teacher_id'] !== $userId)) {
    echo '<div class="alert alert-danger">Mata kuliah tidak ditemukan.</div>';
    return;
}

$dosens = db_query($koneksi, "SELECT id, nama_lengkap FROM users WHERE role='dosen' ORDER BY nama_lengkap");
$categories = db_query($koneksi, "SELECT id, nama_kategori FROM categories ORDER BY nama_kategori");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Ubah Mata Kuliah</h1>
    <a href="layout.php?page=matakuliah" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="admin/edit.php" method="post">
            <input type="hidden" name="id" value="<?php echo e($course['id']); ?>">
            <div class="form-group">
                <label>Nama Mata Kuliah</label>
                <input type="text" name="judul" class="form-control" value="<?php echo e($course['judul']); ?>" required>
            </div>
            <?php if ($role === 'dosen'): ?>
                <input type="hidden" name="teacher_id" value="<?php echo e($course['teacher_id']); ?>">
            <?php else: ?>
                <div class="form-group">
                    <label>Dosen Pengampu</label>
                    <select name="teacher_id" class="form-control" required>
                        <?php while ($dosen = db_fetch_assoc($dosens)): ?>
                            <option value="<?php echo e($dosen['id']); ?>" <?php echo (int) $course['teacher_id'] === (int) $dosen['id'] ? 'selected' : ''; ?>><?php echo e($dosen['nama_lengkap']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">Tanpa kategori</option>
                    <?php while ($category = db_fetch_assoc($categories)): ?>
                        <option value="<?php echo e($category['id']); ?>" <?php echo (int) $course['category_id'] === (int) $category['id'] ? 'selected' : ''; ?>><?php echo e($category['nama_kategori']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required><?php echo e($course['deskripsi']); ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="published" <?php echo $course['status'] === 'published' ? 'selected' : ''; ?>>Published</option>
                    <option value="draft" <?php echo $course['status'] === 'draft' ? 'selected' : ''; ?>>Draft</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Update</button>
        </form>
    </div>
</div>
