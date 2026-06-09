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
$result = mysqli_query($koneksi, "SELECT * FROM soal");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Soal</title>
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
            <a class="navbar-brand fw-bold" href="dashboard.php">← Kembali ke Dashboard</a>
        </div>
    </nav>
    <div class="container my-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-secondary m-0">Daftar Pertanyaan Ujian</h3>
            <a href="tambah_soal.php" class="btn btn-pink fw-semibold shadow-sm">+ Tambah Soal Baru</a>
        </div>
        <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-secondary text-dark">
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="45%">Pertanyaan</th>
                                <th width="35%">Opsi Jawaban</th>
                                <th width="5%" class="text-center">Kunci</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(mysqli_num_rows($result) == 0): ?>
                                <tr><td colspan="5" class="text-center text-muted py-4">Belum ada data soal di database.</td></tr>
                            <?php endif; ?>
                            <?php $no = 1; while($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td class="text-center fw-bold text-muted"><?= $no++; ?></td>
                                <td class="fw-medium text-dark"><?= htmlspecialchars($row['pertanyaan']); ?></td>
                                <td>
                                    <div class="small text-secondary"><strong>A.</strong> <?= htmlspecialchars($row['pilihan_a']); ?></div>
                                    <div class="small text-secondary"><strong>B.</strong> <?= htmlspecialchars($row['pilihan_b']); ?></div>
                                    <div class="small text-secondary"><strong>C.</strong> <?= htmlspecialchars($row['pilihan_c']); ?></div>
                                    <div class="small text-secondary"><strong>D.</strong> <?= htmlspecialchars($row['pilihan_d']); ?></div>
                                </td>
                                <td class="text-center text-success fw-bold"><?= $row['jawaban_benar']; ?></td>
                                <td class="text-center">
                                    <a href="edit_soal.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning w-100 text-white mb-1 rounded-2 shadow-sm">Ubah</a>
                                    <a href="hapus_soal.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger w-100 rounded-2 shadow-sm" onclick="return confirm('Yakin ingin menghapus data soal ini?')">Hapus</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>