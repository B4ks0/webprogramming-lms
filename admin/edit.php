<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$judul = trim($_POST['judul'] ?? '');
$teacherId = $_SESSION['role'] === 'dosen' ? (int) $_SESSION['user_id'] : (int) ($_POST['teacher_id'] ?? 0);
$categoryId = $_POST['category_id'] === '' ? null : (int) $_POST['category_id'];
$deskripsi = trim($_POST['deskripsi'] ?? '');
$status = $_POST['status'] === 'draft' ? 'draft' : 'published';

if ($_SESSION['role'] === 'dosen') {
    $stmt = db_prepare($koneksi, "UPDATE courses SET teacher_id = ?, category_id = ?, judul = ?, deskripsi = ?, status = ? WHERE id = ? AND teacher_id = ?");
    db_stmt_bind_param($stmt, "iisssii", $teacherId, $categoryId, $judul, $deskripsi, $status, $id, $teacherId);
} else {
    $stmt = db_prepare($koneksi, "UPDATE courses SET teacher_id = ?, category_id = ?, judul = ?, deskripsi = ?, status = ? WHERE id = ?");
    db_stmt_bind_param($stmt, "iisssi", $teacherId, $categoryId, $judul, $deskripsi, $status, $id);
}
db_stmt_execute($stmt);

header('Location: ../layout.php?page=matakuliah&pesan=edit');
exit;
