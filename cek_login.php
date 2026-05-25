<?php
session_start();
include 'koneksi/koneksi.php';

$email = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

$stmt = db_prepare($koneksi, "SELECT id, nama_lengkap, email, password, role FROM users WHERE email = ? LIMIT 1");
db_stmt_bind_param($stmt, "s", $email);
db_stmt_execute($stmt);
$result = db_stmt_get_result($stmt);
$user = db_fetch_assoc($result);

if (!$user || !password_verify($password, $user['password'])) {
    header('Location: login.php?pesan=gagal');
    exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['nama_lengkap'];
$_SESSION['email'] = $user['email'];
$_SESSION['role'] = $user['role'];
$_SESSION['status'] = 'login';

header('Location: layout.php');
exit;
