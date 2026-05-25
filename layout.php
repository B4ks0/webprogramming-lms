<?php
session_start();
include 'koneksi/koneksi.php';

if (!isset($_SESSION['status']) || $_SESSION['status'] !== 'login') {
    header('Location: login.php?pesan=belum_login');
    exit;
}

function e($value) {
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

$role = $_SESSION['role'] ?? 'mahasiswa';
$page = $_GET['page'] ?? 'dashboard';
$pages = [
    'dashboard' => [
        'admin' => 'admin/dashboard.php',
        'dosen' => 'guru/dashboard.php',
        'mahasiswa' => 'siswa/dashboard.php',
    ],
    'matakuliah' => [
        'admin' => 'module/matakuliah.php',
        'dosen' => 'module/matakuliah.php',
        'mahasiswa' => 'module/matakuliah.php',
    ],
    'materi' => [
        'admin' => 'module/materi.php',
        'dosen' => 'module/materi.php',
        'mahasiswa' => 'module/materi.php',
    ],
    'tambah_materi' => [
        'admin' => 'module/tambah_materi.php',
        'dosen' => 'module/tambah_materi.php',
    ],
    'ubah_materi' => [
        'admin' => 'module/ubah_materi.php',
        'dosen' => 'module/ubah_materi.php',
    ],
    'tugas' => [
        'admin' => 'module/tugas.php',
        'dosen' => 'module/tugas.php',
        'mahasiswa' => 'module/tugas.php',
    ],
    'peserta' => [
        'admin' => 'module/peserta.php',
        'dosen' => 'module/peserta.php',
    ],
    'tambah_tugas' => [
        'admin' => 'module/tambah_tugas.php',
        'dosen' => 'module/tambah_tugas.php',
    ],
    'ubah_tugas' => [
        'admin' => 'module/ubah_tugas.php',
        'dosen' => 'module/ubah_tugas.php',
    ],
    'submit_tugas' => ['mahasiswa' => 'module/submit_tugas.php'],
    'cek_tugas' => [
        'admin' => 'module/cek_tugas.php',
        'dosen' => 'module/cek_tugas.php',
    ],
    'tambah_mk' => [
        'admin' => 'admin/tambah_mk.php',
        'dosen' => 'admin/tambah_mk.php',
    ],
    'ubah_mk' => [
        'admin' => 'admin/ubah_mk.php',
        'dosen' => 'admin/ubah_mk.php',
    ],
    'users' => ['admin' => 'admin/users.php'],
    'tambah_user' => ['admin' => 'admin/tambah_user.php'],
    'ubah_user' => ['admin' => 'admin/ubah_user.php'],
];

$content = $pages[$page][$role] ?? $pages['dashboard'][$role] ?? 'siswa/dashboard.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Webprograming LMS</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="layout.php">
                <div class="sidebar-brand-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="sidebar-brand-text mx-3">LMS</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item <?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?php echo $page === 'matakuliah' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=matakuliah">
                    <i class="fas fa-fw fa-book"></i><span>Mata Kuliah</span>
                </a>
            </li>
            <li class="nav-item <?php echo in_array($page, ['materi', 'tambah_materi', 'ubah_materi'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=materi">
                    <i class="fas fa-fw fa-file-alt"></i><span>Materi</span>
                </a>
            </li>
            <li class="nav-item <?php echo in_array($page, ['tugas', 'tambah_tugas', 'ubah_tugas', 'submit_tugas', 'cek_tugas'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=tugas">
                    <i class="fas fa-fw fa-tasks"></i><span>Tugas</span>
                </a>
            </li>
            <?php if ($role === 'admin' || $role === 'dosen'): ?>
            <li class="nav-item <?php echo $page === 'peserta' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=peserta">
                    <i class="fas fa-fw fa-user-graduate"></i><span>Peserta MK</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if ($role === 'admin' || $role === 'dosen'): ?>
            <li class="nav-item <?php echo $page === 'tambah_mk' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=tambah_mk">
                    <i class="fas fa-fw fa-plus-circle"></i><span>Tambah MK</span>
                </a>
            </li>
            <?php endif; ?>
            <?php if ($role === 'admin'): ?>
            <li class="nav-item <?php echo in_array($page, ['users', 'tambah_user', 'ubah_user'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=users">
                    <i class="fas fa-fw fa-users-cog"></i><span>Pengguna</span>
                </a>
            </li>
            <?php endif; ?>
            <hr class="sidebar-divider">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </li>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <div class="mr-auto text-gray-700 font-weight-bold text-capitalize"><?php echo e($role); ?></div>
                    <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e($_SESSION['username']); ?></span>
                    <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg" style="width: 32px; height: 32px;">
                </nav>
                <div class="container-fluid">
                    <?php include $content; ?>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Webprograming LMS</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="assets/js/sb-admin-2.min.js"></script>
</body>
</html>
