<?php
session_start();
include '../config/koneksi.php';

if (!isset($koneksi)) {
    $koneksi = mysqli_connect("localhost", "root", "", "ujian_online");
}

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'guru') {
    header("Location: ../auth/login.php");
    exit;
}

$query = "SELECT hasil_ujian.*, users.nama FROM hasil_ujian JOIN users ON hasil_ujian.user_id = users.id ORDER BY hasil_ujian.id DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar-pink { background-color: #ff69b4; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark navbar-pink shadow">
        <div class="container">
            <a class="navbar-brand fw-bold" href="dashboard.php">← Kembali ke Dashboard</a>
        </div>
    </nav>
    <div class="container my-5">
        <h3 class="fw-bold text-secondary mb-4">Melihat Nilai Siswa</h3>
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center" width="8%">No</th>
                            <th>Nama Siswa</th>
                            <th class="text-center">Jumlah Benar</th>
                            <th class="text-center">Jumlah Salah</th>
                            <th class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(mysqli_num_rows($result) == 0): ?>
                            <tr><td colspan="5" class="text-center text-muted py-4">Belum ada murid yang submit lembar jawaban.</td></tr>
                        <?php endif; ?>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                            <td class="fw-bold text-secondary"><?= htmlspecialchars($row['nama']); ?></td>
                            <td class="text-center text-success fw-bold"><?= $row['jumlah_benar']; ?></td>
                            <td class="text-center text-danger fw-bold"><?= $row['jumlah_salah']; ?></td>
                            <td class="text-center text-primary fw-bold fs-5"><?= number_format($row['nilai'], 0); ?></td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>