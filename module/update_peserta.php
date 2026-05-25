<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$courseId = (int) ($_POST['course_id'] ?? 0);
$status = $_POST['status_belajar'] === 'selesai' ? 'selesai' : 'aktif';
$nilai = $_POST['nilai_akhir'] === '' ? null : (float) $_POST['nilai_akhir'];
$catatan = trim($_POST['catatan_dosen'] ?? '');

if (can_manage_course($koneksi, $courseId)) {
    $stmt = db_prepare($koneksi, "UPDATE enrollments SET status_belajar = ?, nilai_akhir = ?, catatan_dosen = ? WHERE id = ? AND course_id = ?");
    db_stmt_bind_param($stmt, "sdsii", $status, $nilai, $catatan, $id, $courseId);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=peserta&course_id=' . $courseId . '&pesan=update');
exit;
