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
    header('Location: ../layout.php?page=materi');
    exit;
}

$judul = trim($_POST['judul_materi'] ?? '');
$konten = trim($_POST['konten_teks'] ?? '');
$video = trim($_POST['video_url'] ?? '');
$urutan = (int) ($_POST['urutan'] ?? 0);
$filePath = save_upload('file_materi', 'materi');

$stmt = db_prepare($koneksi, "INSERT INTO lessons (course_id, judul_materi, konten_teks, video_url, file_path, urutan) VALUES (?, ?, ?, ?, ?, ?)");
db_stmt_bind_param($stmt, "issssi", $courseId, $judul, $konten, $video, $filePath, $urutan);
db_stmt_execute($stmt);

header('Location: ../layout.php?page=materi&pesan=simpan');
exit;
