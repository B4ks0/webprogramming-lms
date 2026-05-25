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
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Webprograming LMS</title>
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-xl-5 col-lg-6 col-md-8">
        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-5">
            <div class="text-center">
              <h1 class="h4 text-gray-900 mb-2">Webprograming LMS</h1>
              <p class="text-muted">Masuk sebagai admin, dosen, atau mahasiswa.</p>
            </div>

            <?php if (isset($_GET['pesan'])): ?>
              <?php if ($_GET['pesan'] === 'gagal'): ?>
                <div class="alert alert-danger">Login gagal. Email atau password salah.</div>
              <?php elseif ($_GET['pesan'] === 'logout'): ?>
                <div class="alert alert-success">Logout berhasil.</div>
              <?php elseif ($_GET['pesan'] === 'belum_login'): ?>
                <div class="alert alert-warning">Silakan login dulu untuk mengakses LMS.</div>
              <?php endif; ?>
            <?php endif; ?>

            <form class="user" action="cek_login.php" method="post">
              <div class="form-group">
                <input type="email" name="username" class="form-control form-control-user" placeholder="Email" required>
              </div>
              <div class="form-group">
                <input type="password" name="password" class="form-control form-control-user" placeholder="Password" required>
              </div>
              <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
            </form>

            <hr>
            <div class="small text-gray-700">
              <div>Admin: admin@example.com / admin123</div>
              <div>Dosen: dosen@example.com / dosen123</div>
              <div>Mahasiswa: mahasiswa@example.com / mahasiswa123</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
