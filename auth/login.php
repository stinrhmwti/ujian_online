<?php
session_start();
include '../config/koneksi.php';

if (!isset($koneksi)) {
    $koneksi = mysqli_connect("localhost", "root", "", "ujian_online");
}

if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'guru') {
        header("Location: ../guru/dashboard.php");
    } else {
        header("Location: ../murid/dashboard.php");
    }
    exit;
}

$error = '';
if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $data = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $data['id'];
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['role'] = $data['role'];

        if ($data['role'] == 'guru') {
            header("Location: ../guru/dashboard.php");
        } else {
            header("Location: ../murid/dashboard.php");
        }
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Ujian Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fff0f5; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .card-login { border-radius: 20px; border: none; overflow: hidden; }
        .bg-pink-gradient { background: linear-gradient(135deg, #ff69b4, #ff1493); color: white; }
        .btn-pink { background-color: #ff69b4; color: white; border: none; transition: 0.3s; }
        .btn-pink:hover { background-color: #ff1493; color: white; transform: translateY(-2px); }
    </style>
</head>
<body class="d-flex align-items-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card card-login shadow-lg">
                    <div class="card-header bg-pink-gradient text-center py-4">
                        <h4 class="mb-1 fw-bold">Ujian Online</h4>
                        <small class="opacity-75">Silakan Masuk ke Akun Anda</small>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <?php if($error): ?>
                            <div class="alert alert-danger text-center small py-2"><?= $error; ?></div>
                        <?php endif; ?>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-secondary">Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-secondary">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Masukkan password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-pink w-100 py-2.5 fw-bold shadow-sm">Log In</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>