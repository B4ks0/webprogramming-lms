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
    'kelas' => ['admin' => 'admin/kelas.php'],
    'tambah_kelas' => ['admin' => 'admin/tambah_kelas.php'],
    'ubah_kelas' => ['admin' => 'admin/ubah_kelas.php'],
    'hapus_kelas' => ['admin' => 'admin/hapus_kelas.php'],
    'categories' => ['admin' => 'admin/categories.php'],
    'tambah_category' => ['admin' => 'admin/tambah_category.php'],
    'ubah_category' => ['admin' => 'admin/ubah_category.php'],
    'hapus_category' => ['admin' => 'admin/hapus_category.php'],
    'jadwal' => ['admin' => 'admin/jadwal.php', 'dosen' => 'admin/jadwal.php'],
    'tambah_jadwal' => ['admin' => 'admin/tambah_jadwal.php', 'dosen' => 'admin/tambah_jadwal.php'],
    'ubah_jadwal' => ['admin' => 'admin/ubah_jadwal.php', 'dosen' => 'admin/ubah_jadwal.php'],
    'hapus_jadwal' => ['admin' => 'admin/hapus_jadwal.php', 'dosen' => 'admin/hapus_jadwal.php'],
    'absensi'       => ['admin' => 'admin/absensi.php', 'dosen' => 'admin/absensi.php'],
    'tambah_absensi'=> ['admin' => 'admin/tambah_absensi.php', 'dosen' => 'admin/tambah_absensi.php'],
    'ubah_absensi'  => ['admin' => 'admin/ubah_absensi.php', 'dosen' => 'admin/ubah_absensi.php'],
    'hapus_absensi' => ['admin' => 'admin/hapus_absensi.php', 'dosen' => 'admin/hapus_absensi.php'],
];

$content = $pages[$page][$role] ?? $pages['dashboard'][$role] ?? 'siswa/dashboard.php';

$roleLabel = [
    'admin' => 'ADMIN',
    'dosen' => 'DOSEN',
    'mahasiswa' => 'MAHASISWA',
];
$brandLabel = 'SELAMAT DATANG ' . ($roleLabel[$role] ?? strtoupper($role));
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
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="layout.php">
                <div class="sidebar-brand-icon"><i class="fas fa-smile"></i></div>
                <div class="sidebar-brand-text mx-3" style="font-size:0.85rem;line-height:1.3">
                    SELAMAT DATANG<br><strong><?php echo e($roleLabel[$role] ?? strtoupper($role)); ?></strong>
                </div>
            </a>
            <hr class="sidebar-divider my-0">

            <!-- Dashboard -->
            <li class="nav-item <?php echo $page === 'dashboard' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">
            <div class="sidebar-heading">Data Master</div>

            <!-- Ruang Kelas (admin only) -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item <?php echo in_array($page, ['kelas','tambah_kelas','ubah_kelas'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=kelas">
                    <i class="fas fa-fw fa-door-open"></i><span>Ruang Kelas</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Categories (admin only) -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item <?php echo in_array($page, ['categories','tambah_category','ubah_category'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=categories">
                    <i class="fas fa-fw fa-tags"></i><span>Categories</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Users (admin only) -->
            <?php if ($role === 'admin'): ?>
            <li class="nav-item <?php echo in_array($page, ['users','tambah_user','ubah_user'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=users">
                    <i class="fas fa-fw fa-users"></i><span>Users</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Courses -->
            <li class="nav-item <?php echo in_array($page, ['matakuliah','tambah_mk','ubah_mk'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=matakuliah">
                    <i class="fas fa-fw fa-graduation-cap"></i><span>Courses</span>
                </a>
            </li>

            <!-- Lessons -->
            <li class="nav-item <?php echo in_array($page, ['materi','tambah_materi','ubah_materi'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=materi">
                    <i class="fas fa-fw fa-book-open"></i><span>Lessons</span>
                </a>
            </li>

            <!-- Enrollments -->
            <?php if ($role === 'admin' || $role === 'dosen'): ?>
            <li class="nav-item <?php echo $page === 'peserta' ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=peserta">
                    <i class="fas fa-fw fa-list-alt"></i><span>Enrollments</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Jadwal -->
            <?php if ($role === 'admin' || $role === 'dosen'): ?>
            <li class="nav-item <?php echo in_array($page, ['jadwal','tambah_jadwal','ubah_jadwal'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=jadwal">
                    <i class="fas fa-fw fa-calendar-alt"></i><span>Jadwal</span>
                </a>
            </li>
            <?php endif; ?>

            <!-- Absensi -->
            <?php if ($role === 'admin' || $role === 'dosen'): ?>
            <li class="nav-item <?php echo in_array($page, ['absensi','tambah_absensi','ubah_absensi'], true) ? 'active' : ''; ?>">
                <a class="nav-link" href="layout.php?page=absensi">
                    <i class="fas fa-fw fa-clipboard-check"></i><span>Absensi</span>
                </a>
            </li>
            <?php endif; ?>

            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="logout.php">
                    <i class="fas fa-fw fa-sign-out-alt"></i><span>Logout</span>
                </a>
            </li>
        </ul>
        <!-- End Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo e($_SESSION['username']); ?></span>
                                <img class="img-profile rounded-circle" src="assets/img/undraw_profile.svg" style="width:32px;height:32px;">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>Profile</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>Logout</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <!-- End Topbar -->

                <div class="container-fluid">
                    <?php include $content; ?>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Webprograming LMS &copy; <?php echo date('Y'); ?></span>
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
