<?php
session_start();
include '../koneksi/koneksi.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'mahasiswa') {
    header('Location: ../login.php?pesan=belum_login');
    exit;
}

header('Location: ../layout.php?page=matakuliah');
exit;
