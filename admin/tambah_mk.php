<?php
$isDosen = ($_SESSION['role'] ?? '') === 'dosen';
$dosens = mysqli_query($koneksi, "SELECT id, nama_lengkap FROM users WHERE role='dosen' ORDER BY nama_lengkap");
$categories = mysqli_query($koneksi, "SELECT id, nama_kategori FROM categories ORDER BY nama_kategori");
?>
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tambah Mata Kuliah</h1>
    <a href="layout.php?page=matakuliah" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow mb-4">
    <div class="card-body">
        <form action="admin/simpan.php" method="post">
            <div class="form-group">
                <label>Nama Mata Kuliah</label>
                <input type="text" name="judul" class="form-control" required>
            </div>
            <?php if ($isDosen): ?>
                <input type="hidden" name="teacher_id" value="<?php echo e($_SESSION['user_id']); ?>">
                <div class="alert alert-info">Mata kuliah ini akan dibuat atas nama <?php echo e($_SESSION['username']); ?>.</div>
            <?php else: ?>
                <div class="form-group">
                    <label>Dosen Pengampu</label>
                    <select name="teacher_id" class="form-control" required>
                        <?php while ($dosen = mysqli_fetch_assoc($dosens)): ?>
                            <option value="<?php echo e($dosen['id']); ?>"><?php echo e($dosen['nama_lengkap']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            <?php endif; ?>
            <div class="form-group">
                <label>Kategori</label>
                <select name="category_id" class="form-control">
                    <option value="">Tanpa kategori</option>
                    <?php while ($category = mysqli_fetch_assoc($categories)): ?>
                        <option value="<?php echo e($category['id']); ?>"><?php echo e($category['nama_kategori']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="4" required></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status" class="form-control">
                    <option value="published">Published</option>
                    <option value="draft">Draft</option>
                </select>
            </div>
            <button class="btn btn-primary" type="submit">Simpan</button>
        </form>
    </div>
</div>
