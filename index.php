<?php
session_start();

if (isset($_SESSION['status']) && $_SESSION['status'] === 'login') {
    header('Location: layout.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webprograming LMS</title>
    <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand navbar-light bg-white shadow-sm">
        <a class="navbar-brand font-weight-bold text-primary" href="index.php">Webprograming LMS</a>
        <div class="ml-auto">
            <a href="login.php" class="btn btn-primary btn-sm">Login</a>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <h1 class="display-4 font-weight-bold text-gray-900">Learning Management System</h1>
                <p class="lead text-gray-700">Kelola mata kuliah, dosen, mahasiswa, materi, dan progres belajar dalam satu aplikasi sederhana.</p>
                <a href="login.php" class="btn btn-primary btn-lg mt-3">Masuk ke LMS</a>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0">
                <div class="card shadow border-0">
                    <div class="card-body p-4">
                        <h2 class="h5 text-gray-900">Akun demo</h2>
                        <p class="mb-2"><strong>Admin:</strong> admin@example.com / admin123</p>
                        <p class="mb-2"><strong>Dosen:</strong> dosen@example.com / dosen123</p>
                        <p class="mb-0"><strong>Mahasiswa:</strong> mahasiswa@example.com / mahasiswa123</p>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
