<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (!in_array($_SESSION['role'] ?? '', ['admin', 'dosen'], true)) {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$submissionId = (int) ($_POST['submission_id'] ?? 0);
$assignmentId = (int) ($_POST['assignment_id'] ?? 0);
$nilai = $_POST['nilai'] === '' ? null : (float) $_POST['nilai'];
$feedback = trim($_POST['feedback'] ?? '');

$stmt = db_prepare($koneksi, "SELECT a.course_id FROM assignment_submissions s JOIN assignments a ON a.id = s.assignment_id WHERE s.id = ?");
db_stmt_bind_param($stmt, "i", $submissionId);
db_stmt_execute($stmt);
$row = db_fetch_assoc(db_stmt_get_result($stmt));

if ($row && can_manage_course($koneksi, (int) $row['course_id'])) {
    $stmt = db_prepare($koneksi, "UPDATE assignment_submissions SET nilai = ?, feedback = ?, status = 'reviewed' WHERE id = ?");
    db_stmt_bind_param($stmt, "dsi", $nilai, $feedback, $submissionId);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=cek_tugas&id=' . $assignmentId . '&pesan=nilai');
exit;
