<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT * FROM lessons WHERE id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$material = db_fetch_assoc(db_stmt_get_result($stmt));

$courseId = (int) ($_POST['course_id'] ?? 0);
if (!$material || !can_manage_course($koneksi, (int) $material['course_id']) || !can_manage_course($koneksi, $courseId)) {
    header('Location: ../layout.php?page=materi');
    exit;
}

$judul = trim($_POST['judul_materi'] ?? '');
$konten = trim($_POST['konten_teks'] ?? '');
$video = trim($_POST['video_url'] ?? '');
$urutan = (int) ($_POST['urutan'] ?? 0);
$filePath = save_upload('file_materi', 'materi') ?? $material['file_path'];

$stmt = db_prepare($koneksi, "UPDATE lessons SET course_id = ?, judul_materi = ?, konten_teks = ?, video_url = ?, file_path = ?, urutan = ? WHERE id = ?");
db_stmt_bind_param($stmt, "issssii", $courseId, $judul, $konten, $video, $filePath, $urutan, $id);
db_stmt_execute($stmt);

header('Location: ../layout.php?page=materi&pesan=edit');
exit;
