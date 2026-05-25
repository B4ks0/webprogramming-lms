<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

$nama = trim($_POST['nama_lengkap'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$role = in_array($_POST['role'] ?? '', ['admin', 'dosen', 'mahasiswa'], true) ? $_POST['role'] : 'mahasiswa';
$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = mysqli_prepare($koneksi, "INSERT INTO users (nama_lengkap, email, password, role) VALUES (?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssss", $nama, $email, $hash, $role);
mysqli_stmt_execute($stmt);

header('Location: ../layout.php?page=users&pesan=simpan');
exit;
