<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id !== (int) $_SESSION['user_id']) {
    $stmt = db_prepare($koneksi, "DELETE FROM users WHERE id = ?");
    db_stmt_bind_param($stmt, "i", $id);
    db_stmt_execute($stmt);
}

header('Location: ../layout.php?page=users&pesan=hapus');
exit;
