<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$judul = trim($_POST['judul'] ?? '');
$teacherId = $_SESSION['role'] === 'dosen' ? (int) $_SESSION['user_id'] : (int) ($_POST['teacher_id'] ?? 0);
$categoryId = $_POST['category_id'] === '' ? null : (int) $_POST['category_id'];
$deskripsi = trim($_POST['deskripsi'] ?? '');
$status = $_POST['status'] === 'draft' ? 'draft' : 'published';

$stmt = db_prepare($koneksi, "INSERT INTO courses (teacher_id, category_id, judul, deskripsi, harga, status) VALUES (?, ?, ?, ?, 0, ?)");
db_stmt_bind_param($stmt, "iisss", $teacherId, $categoryId, $judul, $deskripsi, $status);
db_stmt_execute($stmt);

header('Location: ../layout.php?page=matakuliah&pesan=simpan');
exit;
