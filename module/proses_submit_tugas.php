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
$stmt = db_prepare($koneksi, "SELECT course_id FROM assignments WHERE id = ?");
db_stmt_bind_param($stmt, "i", $assignmentId);
db_stmt_execute($stmt);
$assignment = db_fetch_assoc(db_stmt_get_result($stmt));

if (!$assignment || !can_view_course($koneksi, (int) $assignment['course_id'])) {
    header('Location: ../layout.php?page=tugas');
    exit;
}

$filePath = save_upload('file_jawaban', 'submissions');
if (!$filePath) {
    header('Location: ../layout.php?page=submit_tugas&id=' . $assignmentId);
    exit;
}

$stmt = db_prepare($koneksi, "SELECT id FROM assignment_submissions WHERE assignment_id = ? AND user_id = ?");
db_stmt_bind_param($stmt, "ii", $assignmentId, $userId);
db_stmt_execute($stmt);
$exists = db_fetch_assoc(db_stmt_get_result($stmt));

if ($exists) {
    $stmt = db_prepare($koneksi, "UPDATE assignment_submissions SET file_path = ?, catatan = ?, submitted_at = CURRENT_TIMESTAMP, nilai = NULL, feedback = NULL, status = 'submitted' WHERE assignment_id = ? AND user_id = ?");
    db_stmt_bind_param($stmt, "ssii", $filePath, $catatan, $assignmentId, $userId);
    db_stmt_execute($stmt);
} else {
    $stmt = db_prepare($koneksi, "INSERT INTO assignment_submissions (assignment_id, user_id, file_path, catatan, status) VALUES (?, ?, ?, ?, 'submitted')");
    db_stmt_bind_param($stmt, "iiss", $assignmentId, $userId, $filePath, $catatan);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=tugas&pesan=submit');
exit;
