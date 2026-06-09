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

if (isset($_POST['selesai'])) {
    $jawaban_user = isset($_POST['jawaban']) ? $_POST['jawaban'] : array();
    $benar = 0;
    $salah = 0;
    $total_soal = 0;

    $query_soal = mysqli_query($koneksi, "SELECT id, jawaban_benar FROM soal");
    while ($row = mysqli_fetch_assoc($query_soal)) {
        $total_soal++;
        $id_soal = $row['id'];
        
        if (isset($jawaban_user[$id_soal])) {
            if ($jawaban_user[$id_soal] == $row['jawaban_benar']) {
                $benar++;
            } else {
                $salah++;
            }
        } else {
            $salah++;
        }
    }

    $skor = ($total_soal > 0) ? round(($benar / $total_soal) * 100) : 0;

    $check = mysqli_query($koneksi, "SELECT * FROM hasil_ujian WHERE user_id = $user_id");
    if(mysqli_num_rows($check) == 0) {
        mysqli_query($koneksi, "INSERT INTO hasil_ujian (user_id, jumlah_benar, jumlah_salah, nilai) VALUES ($user_id, $benar, $salah, $skor)");
    }
}

$nilai_query = mysqli_query($koneksi, "SELECT * FROM hasil_ujian WHERE user_id = $user_id");
$data_nilai = mysqli_fetch_assoc($nilai_query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Melihat Nilai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-pink { background-color: #ff69b4; }
        .btn-pink { background-color: #ff69b4; color: white; }
        .btn-pink:hover { background-color: #ff1493; color: white; }
        .score-display { font-size: 4.5rem; font-weight: 800; color: #ff69b4; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pink shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">← Kembali ke Dashboard</a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <div class="card border-0 shadow p-4 rounded-3 bg-white">
                    <div class="card-body">
                        <h4 class="fw-bold text-secondary mb-4">Hasil Evaluasi Anda</h4>
                        <div class="small fw-semibold text-uppercase text-muted tracking-wide">Nama Siswa : <?= $_SESSION['nama']; ?></div>
                        
                        <?php if($data_nilai): ?>
                            <div class="score-display my-3"><?= number_format($data_nilai['nilai'], 0); ?></div>
                            <div class="row border-top pt-3 text-center g-2">
                                <div class="col-6 border-end">
                                    <h5 class="text-success fw-bold mb-0">Jumlah Benar : <?= $data_nilai['jumlah_benar']; ?></h5>
                                </div>
                                <div class="col-6">
                                    <h5 class="text-danger fw-bold mb-0">Jumlah Salah : <?= $data_nilai['jumlah_salah']; ?></h5>
                                </div>
                            </div>
                            <div class="mt-4 text-center">
                                <h5 class="fw-bold text-dark">Nilai : <?= number_format($data_nilai['nilai'], 0); ?></h5>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning my-3">Belum ada riwayat nilai.</div>
                        <?php endif; ?>
                        
                        <div class="mt-4">
                            <a href="dashboard.php" class="btn btn-pink px-5 fw-bold shadow-sm">Selesai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>