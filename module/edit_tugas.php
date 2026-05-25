<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM assignments WHERE id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$assignment = db_fetch_assoc(db_stmt_get_result($stmt));

$courseId = (int) ($_POST['course_id'] ?? 0);
if (!$assignment || !can_manage_course($koneksi, (int) $assignment['course_id']) || !can_manage_course($koneksi, $courseId)) {
    header('Location: ../layout.php?page=tugas');
    exit;
}

$judul = trim($_POST['judul_tugas'] ?? '');
$deskripsi = trim($_POST['deskripsi'] ?? '');
$deadline = str_replace('T', ' ', $_POST['deadline'] ?? '');
$filePath = save_upload('file_tugas', 'tugas') ?? $assignment['file_path'];

$stmt = db_prepare($koneksi, "UPDATE assignments SET course_id = ?, judul_tugas = ?, deskripsi = ?, file_path = ?, deadline = ? WHERE id = ?");
db_stmt_bind_param($stmt, "issssi", $courseId, $judul, $deskripsi, $filePath, $deadline, $id);
db_stmt_execute($stmt);

header('Location: ../layout.php?page=tugas&pesan=edit');
exit;
