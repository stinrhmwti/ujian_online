<?php
session_start();
include '../config/koneksi.php';

if (!isset($koneksi)) {
    $koneksi = mysqli_connect("localhost", "root", "", "ujian_online");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'murid') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['id'];
$check_nilai = mysqli_query($koneksi, "SELECT * FROM hasil_ujian WHERE user_id = $user_id");
$sudah_ujian = mysqli_num_rows($check_nilai) > 0;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-pink { background-color: #ff69b4; }
        .btn-pink { background-color: #ff69b4; color: white; }
        .btn-pink:hover { background-color: #ff1493; color: white; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pink shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">Lembar Kerja Siswa</a>
            <div class="navbar-nav ms-auto">
                <span class="nav-link text-white me-3 fw-medium">Nama Siswa : <?= $_SESSION['nama']; ?></span>
                <a class="btn btn-sm btn-light text-danger fw-bold" href="../auth/logout.php">Keluar</a>
            </div>
        </div>
    </nav>
    <div class="container my-5 text-center">
        <h2 class="fw-bold text-secondary mb-2">Mengerjakan Soal</h2>
        <p class="text-muted mb-5">Selamat datang di sistem evaluasi ujian mandiri. Selesaikan tes Anda tepat waktu.</p>
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card border-0 shadow-sm p-4 rounded-3 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold text-dark mb-3">Ujian Evaluasi Utama</h4>
                        <p class="text-muted small">Materi uji pilihan ganda acak sesuai kompetensi dasar kejuruan.</p>
                        <hr class="text-muted">
                        <?php if($sudah_ujian): ?>
                            <div class="alert alert-success fw-medium">Status: Selesai Mengerjakan</div>
                            <a href="hasil.php" class="btn btn-outline-secondary w-100 fw-bold">Melihat Nilai</a>
                        <?php else: ?>
                            <a href="ujian.php" class="btn btn-pink w-100 fw-bold py-2 shadow-sm">Mulai Kerjakan Ujian</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>