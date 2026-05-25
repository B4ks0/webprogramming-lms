<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$courseId = (int) ($_POST['course_id'] ?? 0);
$userId = (int) ($_POST['user_id'] ?? 0);

if (can_manage_course($koneksi, $courseId)) {
    $stmt = mysqli_prepare($koneksi, "INSERT INTO enrollments (user_id, course_id, status_belajar) VALUES (?, ?, 'aktif') ON DUPLICATE KEY UPDATE status_belajar = status_belajar");
    mysqli_stmt_bind_param($stmt, "ii", $userId, $courseId);
    mysqli_stmt_execute($stmt);
}

header('Location: ../layout.php?page=peserta&course_id=' . $courseId . '&pesan=simpan');
exit;
