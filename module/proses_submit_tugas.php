<?php
session_start();
include '../koneksi/koneksi.php';
require_once __DIR__ . '/_akademik.php';

if (($_SESSION['role'] ?? '') !== 'mahasiswa') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$assignmentId = (int) ($_POST['assignment_id'] ?? 0);
$userId = (int) $_SESSION['user_id'];
$catatan = trim($_POST['catatan'] ?? '');
$stmt = mysqli_prepare($koneksi, "SELECT course_id FROM assignments WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $assignmentId);
mysqli_stmt_execute($stmt);
$assignment = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$assignment || !can_view_course($koneksi, (int) $assignment['course_id'])) {
    header('Location: ../layout.php?page=tugas');
    exit;
}

$filePath = save_upload('file_jawaban', 'submissions');
if (!$filePath) {
    header('Location: ../layout.php?page=submit_tugas&id=' . $assignmentId);
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO assignment_submissions (assignment_id, user_id, file_path, catatan, status) VALUES (?, ?, ?, ?, 'submitted') ON DUPLICATE KEY UPDATE file_path = VALUES(file_path), catatan = VALUES(catatan), submitted_at = CURRENT_TIMESTAMP, nilai = NULL, feedback = NULL, status = 'submitted'");
mysqli_stmt_bind_param($stmt, "iiss", $assignmentId, $userId, $filePath, $catatan);
mysqli_stmt_execute($stmt);

header('Location: ../layout.php?page=tugas&pesan=submit');
exit;
