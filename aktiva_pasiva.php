<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Neraca Saldo</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #191919; /* Warna latar belakang */
            color: #ffffff; /* Warna teks */
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #242424; /* Warna latar belakang konten */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1); /* Efek bayangan */
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #00ffae; /* Warna judul */
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden; /* Mengatasi bayangan yang terpotong di sudut tabel */
            color: #ffffff; /* Warna teks */
        }

        table th, table td {
            border: 1px solid #1a1a1a; /* Warna garis */
            padding: 12px;
            text-align: left;
        }

        table th {
            background-color: #0d0d0d; /* Warna latar belakang header */
        }

        table tr:nth-child(even) {
            background-color: #333333; /* Warna latar belakang baris genap */
        }

        .back-btn {
            display: block;
            text-align: center;
            margin-top: 20px;
        }

        .back-btn a {
            color: #ffffff;
            text-decoration: none;
            background-color: #00ffae;
            padding: 10px 20px;
            border-radius: 5px;
        }

        .back-btn a:hover {
            background-color: #00d3a6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Neraca Saldo</h2>
        <?php
        $conn = new mysqli('localhost', 'DraxO', 'DraxO130', 'tabel_transaksi');
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Query untuk mendapatkan data neraca saldo
        $sql = "SELECT 
                    t_akun.aktiva_pasiva AS aktiva_pasiva,
                    t_akun.nama_akun AS nama_akun,
                    IFNULL(SUM(IF(t_trx_detail.d_k = 'D', t_trx_detail.nominal, 0)), 0) AS debit,
                    IFNULL(SUM(IF(t_trx_detail.d_k = 'K', t_trx_detail.nominal, 0)), 0) AS kredit
                FROM 
                    t_akun
                LEFT JOIN 
                    t_trx_detail ON t_akun.id_akun = t_trx_detail.id_akun
                LEFT JOIN 
                    t_trx ON t_trx.id_trx = t_trx_detail.id_trx
                GROUP BY 
                    t_akun.aktiva_pasiva, t_akun.nama_akun
                HAVING 
                    debit != 0 OR kredit != 0"; // Menambahkan kondisi HAVING untuk memeriksa jika debit atau kredit tidak sama dengan nol
        $result = $conn->query($sql);

        // Inisialisasi total debit dan kredit
        $total_debit = 0;
        $total_kredit = 0;

        // Jika ada data yang ditemukan, tampilkan tabel
        if ($result->num_rows > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Aktiva/ Pasiva</th>
                    <th>Nama Akun</th>
                    <th>Debit</th>
                    <th>Kredit</th>
                </tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["aktiva_pasiva"] . "</td>";
                echo "<td>" . $row["nama_akun"] . "</td>";
                echo "<td>" . $row["debit"] . "</td>";
                echo "<td>" . $row["kredit"] . "</td>";
                echo "</tr>";

                // Tambahkan nilai debit dan kredit ke total
                $total_debit += $row["debit"];
                $total_kredit += $row["kredit"];
            }

            // Tampilkan total debit dan kredit di akhir tabel
            echo "<tr>
                    <td colspan='2'><strong>Total</strong></td>
                    <td>$total_debit</td>
                    <td>$total_kredit</td>
                </tr>";
            echo "</table>";
        } else {
            // Jika tidak ada data, tampilkan pesan
            echo "<p>Tidak ada data yang ditemukan.</p>";
        }
        $conn->close();
        ?>
        <div class="back-btn">
            <a href="index.php">Back to Home</a>
        </div>
    </div>
</body>
</html>
