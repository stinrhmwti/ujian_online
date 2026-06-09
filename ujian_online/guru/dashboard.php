<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-pink { background-color: #ff69b4; }
        .btn-pink { background-color: #ff69b4; color: white; }
        .btn-pink:hover { background-color: #ff1493; color: white; }
        .card-menu { border: none; transition: 0.3s; border-radius: 15px; }
        .card-menu:hover { transform: translateY(-5px); }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pink shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Guru Panel System</a>
            <div class="navbar-nav ms-auto align-items-center">
                <span class="navbar-text text-white me-3 fw-medium">Selamat Datang, <?= $_SESSION['nama']; ?></span>
                <a class="btn btn-sm btn-light text-danger fw-bold shadow-sm" href="../auth/logout.php">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row mb-5 text-center">
            <div class="col-lg-8 mx-auto">
                <h2 class="fw-bold text-dark">Sistem Manajemen Evaluasi Ujian</h2>
                <p class="text-muted">Aplikasi backend pengelola bank soal dan pemantauan nilai komprehensif siswa.</p>
            </div>
        </div>
        <div class="row justify-content-center g-4">
            <div class="col-md-5">
                <div class="card card-menu shadow-sm text-center p-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold text-secondary mb-3">Kelola Soal Ujian</h4>
                        <p class="text-muted small">Fasilitas administrasi pembuatan, perubahan data, dan penghapusan lembar pertanyaan pilihan ganda.</p>
                        <a href="soal.php" class="btn btn-pink px-4 mt-3 fw-semibold">Buka Bank Soal</a>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card card-menu shadow-sm text-center p-4 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold text-secondary mb-3">Melihat Nilai Siswa</h4>
                        <p class="text-muted small">Pantau log rekapitulasi data pengerjaan, skor nilai rata-rata, jumlah jawaban benar dan salah.</p>
                        <a href="nilai.php" class="btn btn-pink px-4 mt-3 fw-semibold">Lihat Nilai Siswa</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>