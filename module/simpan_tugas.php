<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$courseId = (int) ($_POST['course_id'] ?? 0);
if (!can_manage_course($koneksi, $courseId)) {
    header('Location: ../layout.php?page=tugas');
    exit;
}

$judul = trim($_POST['judul_tugas'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$deadline = str_replace('T', ' ', $_POST['deadline'] ?? '');
$filePath = save_upload('file_tugas', 'tugas');

$stmt = db_prepare($koneksi, "INSERT INTO assignments (course_id, judul_tugas, deskripsi, file_path, deadline) VALUES (?, ?, ?, ?, ?)");
db_stmt_bind_param($stmt, "issss", $courseId, $judul, $deskripsi, $filePath, $deadline);
db_stmt_execute($stmt);

header('Location: ../layout.php?page=tugas&pesan=simpan');
exit;
