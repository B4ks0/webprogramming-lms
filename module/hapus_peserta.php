<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
$courseId = (int) ($_GET['course_id'] ?? 0);

if (can_manage_course($koneksi, $courseId)) {
    $stmt = db_prepare($koneksi, "DELETE FROM enrollments WHERE id = ? AND course_id = ?");
    db_stmt_bind_param($stmt, "ii", $id, $courseId);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=peserta&course_id=' . $courseId . '&pesan=hapus');
exit;
