<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$id = (int) ($_POST['id'] ?? 0);
$nama = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = in_array($_POST['role'] ?? '', ['admin', 'dosen', 'mahasiswa'], true) ? $_POST['role'] : 'mahasiswa';

if ($password !== '') {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET nama_lengkap = ?, email = ?, password = ?, role = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "ssssi", $nama, $email, $hash, $role, $id);
} else {
    $stmt = mysqli_prepare($koneksi, "UPDATE users SET nama_lengkap = ?, email = ?, role = ? WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $role, $id);
}
mysqli_stmt_execute($stmt);

if ($id === (int) $_SESSION['user_id']) {
    $_SESSION['username'] = $nama;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;
}

header('Location: ../layout.php?page=users&pesan=edit');
exit;
