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
    $stmt = db_prepare($koneksi, "SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
    db_stmt_bind_param($stmt, "ii", $userId, $courseId);
    db_stmt_execute($stmt);
    $exists = db_fetch_assoc(db_stmt_get_result($stmt));

    if (!$exists) {
        $stmt = db_prepare($koneksi, "INSERT INTO enrollments (user_id, course_id, status_belajar) VALUES (?, ?, 'aktif')");
        db_stmt_bind_param($stmt, "ii", $userId, $courseId);
        db_stmt_execute($stmt);
    }
}

header('Location: ../layout.php?page=peserta&course_id=' . $courseId . '&pesan=simpan');
exit;
