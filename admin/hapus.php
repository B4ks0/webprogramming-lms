<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($_SESSION['role'] === 'dosen') {
    $teacherId = (int) $_SESSION['user_id'];
    $stmt = db_prepare($koneksi, "DELETE FROM courses WHERE id = ? AND teacher_id = ?");
    db_stmt_bind_param($stmt, "ii", $id, $teacherId);
} else {
    $stmt = db_prepare($koneksi, "DELETE FROM courses WHERE id = ?");
    db_stmt_bind_param($stmt, "i", $id);
}
db_stmt_execute($stmt);

header('Location: ../layout.php?page=matakuliah&pesan=hapus');
exit;
