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

if (isset($_POST['simpan'])) {
    $pertanyaan = mysqli_real_escape_string($koneksi, $_POST['pertanyaan']);
    $pilihan_a = mysqli_real_escape_string($koneksi, $_POST['pilihan_a']);
    $pilihan_b = mysqli_real_escape_string($koneksi, $_POST['pilihan_b']);
    $pilihan_c = mysqli_real_escape_string($koneksi, $_POST['pilihan_c']);
    $pilihan_d = mysqli_real_escape_string($koneksi, $_POST['pilihan_d']);
    $jawaban_benar = $_POST['jawaban_benar'];

    $query = "INSERT INTO soal (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar) VALUES ('$pertanyaan', '$pilihan_a', '$pilihan_b', '$pilihan_c', '$pilihan_d', '$jawaban_benar')";
    if(mysqli_query($koneksi, $query)) {
        header("Location: soal.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Soal</title>
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
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-4">
                        <h4 class="fw-bold text-secondary mb-4">Form Tambah Soal Ujian</h4>
                        <form action="" method="POST">
                            <div class="mb-3">
                                <label class="form-label fw-semibold text-muted">Pertanyaan</label>
                                <textarea name="pertanyaan" class="form-control" rows="4" placeholder="Ketik kalimat pertanyaan di sini..." required></textarea>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Pilihan A</label>
                                    <input type="text" name="pilihan_a" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Pilihan B</label>
                                    <input type="text" name="pilihan_b" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Pilihan C</label>
                                    <input type="text" name="pilihan_c" class="form-control" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-muted">Pilihan D</label>
                                    <input type="text" name="pilihan_d" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-4 col-md-4">
                                <label class="form-label fw-semibold text-muted">Kunci Jawaban Benar</label>
                                <select name="jawaban_benar" class="form-select" required>
                                    <option value="A">A</option>
                                    <option value="B">B</option>
                                    <option value="C">C</option>
                                    <option value="D">D</option>
                                </select>
                            </div>
                            <button type="submit" name="simpan" class="btn btn-pink px-4 fw-bold">Simpan Soal</button>
                            <a href="soal.php" class="btn btn-secondary px-4 ms-2">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>