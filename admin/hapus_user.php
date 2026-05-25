<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id !== (int) $_SESSION['user_id']) {
    $stmt = mysqli_prepare($koneksi, "DELETE FROM users WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
}

header('Location: ../layout.php?page=users&pesan=hapus');
exit;
