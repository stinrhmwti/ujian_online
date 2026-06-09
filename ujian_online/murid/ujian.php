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
$check = mysqli_query($koneksi, "SELECT * FROM hasil_ujian WHERE user_id = $user_id");
if (mysqli_num_rows($check) > 0) {
    header("Location: hasil.php");
    exit;
}

$soal_query = mysqli_query($koneksi, "SELECT * FROM soal");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Proses Mengisi Ujian</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .btn-pink { background-color: #ff69b4; color: white; }
        .btn-pink:hover { background-color: #ff1493; color: white; }
    </style>
</head>
<body class="bg-light py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="fw-bold text-secondary mb-4">Lembar Soal Ujian</h3>
                <form action="hasil.php" method="POST">
                    <?php $no = 1; while($row = mysqli_fetch_assoc($soal_query)): ?>
                    <div class="card border-0 shadow-sm mb-4 rounded-3">
                        <div class="card-body p-4">
                            <h5 class="fw-semibold text-dark mb-3"><?= $no; ?>. <?= htmlspecialchars($row['pertanyaan']); ?></h5>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="A" id="q_<?= $row['id']; ?>_a" required>
                                <label class="form-check-label" for="q_<?= $row['id']; ?>_a">A. <?= htmlspecialchars($row['pilihan_a']); ?></label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="B" id="q_<?= $row['id']; ?>_b">
                                <label class="form-check-label" for="q_<?= $row['id']; ?>_b">B. <?= htmlspecialchars($row['pilihan_b']); ?></label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="C" id="q_<?= $row['id']; ?>_c">
                                <label class="form-check-label" for="q_<?= $row['id']; ?>_c">C. <?= htmlspecialchars($row['pilihan_c']); ?></label>
                            </div>
                            <div class="form-check mb-0">
                                <input class="form-check-input" type="radio" name="jawaban[<?= $row['id']; ?>]" value="D" id="q_<?= $row['id']; ?>_d">
                                <label class="form-check-label" for="q_<?= $row['id']; ?>_d">D. <?= htmlspecialchars($row['pilihan_d']); ?></label>
                            </div>
                        </div>
                    </div>
                    <?php $no++; endwhile; ?>
                    <button type="submit" name="selesai" class="btn btn-pink btn-lg px-5 fw-bold shadow-sm" onclick="return confirm('Mengirim jawaban? Evaluasi tidak dapat diulang kembali!')">Mengirim Jawaban</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>