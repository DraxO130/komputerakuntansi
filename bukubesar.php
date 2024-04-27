<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Transaksi</title>
<style>
  body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #111; /* Warna latar belakang gelap */
    color: #fff; /* Warna teks putih */
}

.container {
    max-width: 1000px;
    margin: 20px auto;
    padding: 20px;
    border-radius: 8px;
    background-color: #222; /* Warna latar belakang kontainer yang lebih gelap */
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.5); /* Shadow dengan efek neon biru */
    position: relative; /* Tambahkan properti position relative */
}

h2 {
    margin-top: 20px;
    color: #ff0; /* Warna neon */
}

.data-table {
    border-collapse: collapse;
    width: 100%;
}

.data-table th, .data-table td {
    border: 1px solid #444; /* Warna border */
    padding: 12px;
    text-align: left;
}

.data-table th {
    background-color: #333; /* Warna latar belakang header yang lebih gelap */
    font-weight: bold;
}

.data-table tr:nth-child(even) {
    background-color: #444; /* Warna latar belakang baris genap yang lebih gelap */
}

.data-table tr:hover {
    background-color: #555; /* Warna latar belakang baris saat dihover */
}

.data-table tbody tr:last-child {
    border-bottom: 2px solid #777; /* Warna garis bawah untuk baris terakhir */
}

.total {
    font-weight: bold;
}

.debit-kredit {
    text-align: right;
    color: #0f0; /* Warna hijau neon untuk angka positif */
}

.back-to-home-btn {
    position: absolute;
    top: 50px;
    right: 200px;
    padding: 10px 20px;
    background-color: #ff0; /* Warna latar belakang tombol neon kuning */
    color: #111; /* Warna teks */
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.back-to-home-btn:hover {
    background-color: #0ff; /* Warna latar belakang tombol neon biru */
    color: #111; /* Warna teks */
}

</style>
</head>
<body>

<div class="container">

<?php
// Sisipkan file konfigurasi database
require_once 'dbconfig.php';

// Ambil daftar nama akun dari database
$query_akun = "SELECT DISTINCT nama_akun FROM t_akun";
$result_akun = $conn->query($query_akun);

// Loop untuk setiap akun
while ($row_akun = $result_akun->fetch_assoc()) {
    $nama_akun = $row_akun['nama_akun'];

    // Query untuk mengambil data transaksi untuk akun tertentu
    $query = "
        SELECT 
            DATE_FORMAT(t_trx.tgl, '%Y %b') AS bln,
            DATE_FORMAT(t_trx.tgl, '%d') AS tgl,
            t_akun.nama_akun,
            t_trx.transaksi,
            IF(t_trx_detail.d_k='D', t_trx_detail.nominal, 0) AS Debit,
            IF(t_trx_detail.d_k='K', t_trx_detail.nominal, 0) AS Kredit
        FROM
            t_trx_detail
            JOIN t_trx ON t_trx_detail.id_trx = t_trx.id_trx
            JOIN t_akun ON t_trx_detail.id_akun = t_akun.id_akun
        WHERE
            t_akun.nama_akun = '$nama_akun'
        ORDER BY
            t_trx.tgl;
    ";

    $result = $conn->query($query);

    // Hitung total debit dan total kredit untuk akun tertentu
    $total_debit = 0;
    $total_kredit = 0;

    // Fetch and display data transaksi untuk akun tertentu
    if ($result->num_rows > 0) {
        // Tampilkan nama akun
        echo "<h2>Data Transaksi untuk Akun: $nama_akun</h2>";

        // Tampilkan header tabel
        echo "<table class='data-table'>
                <thead>
                    <tr>
                        <th>Bulan</th>
                        <th>Tanggal</th>
                        <th>Nama Akun</th>
                        <th>Nama Transaksi</th>
                        <th class='debit-kredit'>Debit</th>
                        <th class='debit-kredit'>Kredit</th>
                        <th class='debit-kredit'>Total Debit</th>
                        <th class='debit-kredit'>Total Kredit</th>
                    </tr>
                </thead>
                <tbody>";

        while ($row = $result->fetch_assoc()) {
            $total_debit += $row['Debit'];
            $total_kredit += $row['Kredit'];

            echo "<tr>
                    <td>".$row['bln']."</td>
                    <td>".$row['tgl']."</td>
                    <td>".$row['nama_akun']."</td>
                    <td>".$row['transaksi']."</td>
                    <td class='debit-kredit'>".$row['Debit']."</td>
                    <td class='debit-kredit'>".$row['Kredit']."</td>
                    <td class='debit-kredit'>".$total_debit."</td>
                    <td class='debit-kredit'>".$total_kredit."</td>
                </tr>";
        }

        echo "</tbody></table>";
    }
}

// Tutup koneksi
$conn->close();
?>

</div>
<button class="back-to-home-btn"><a href="index.php">Back to Home</a></button>
</body>
</html>
