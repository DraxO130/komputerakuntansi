<?php
// Kredensial Database
$servername = "localhost"; // Ganti dengan host database Anda
$username = "DraxO"; // Ganti dengan username database Anda
$password = "DraxO130"; // Ganti dengan password database Anda
$dbname = "tabel_transaksi"; // Ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
}
?>
