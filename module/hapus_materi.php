<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
$stmt = db_prepare($koneksi, "SELECT course_id FROM lessons WHERE id = ?");
db_stmt_bind_param($stmt, "i", $id);
db_stmt_execute($stmt);
$material = db_fetch_assoc(db_stmt_get_result($stmt));

if ($material && can_manage_course($koneksi, (int) $material['course_id'])) {
    $stmt = db_prepare($koneksi, "DELETE FROM lessons WHERE id = ?");
    db_stmt_bind_param($stmt, "i", $id);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=materi&pesan=hapus');
exit;
