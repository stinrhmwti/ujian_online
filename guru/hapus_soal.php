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

$id = $_GET['id'];
mysqli_query($koneksi, "DELETE FROM soal WHERE id=$id");
header("Location: soal.php");
exit;
?>