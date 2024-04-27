<?php
require_once 'dbconfig.php';

$accountsInfo = [];


$activitiesQuery = "SELECT id_reaksi, nama_reaksi FROM reaksi ORDER BY id_reaksi";
$activitiesResult = $conn->query($activitiesQuery);

if(isset($_GET['jenis'])) {
    $jenis = $conn->real_escape_string($_GET['jenis']);
    $accountsQuery = "SELECT t_akun.nama_akun, detail_reaksi.id_akun, detail_reaksi.debet_kredit FROM detail_reaksi
    JOIN t_akun ON detail_reaksi.id_akun = t_akun.id_akun
    WHERE detail_reaksi.id_reaksi = '$jenis'";;

    $accountsResult = $conn->query($accountsQuery);

    // Populate the accounts information array
    while ($account = $accountsResult->fetch_assoc()) {
        $accountsInfo[] = $account;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Akuntansi</title>
    <style>
    body {
    margin: 0;
    font-family: Arial, sans-serif;
    background-color: #111; /* Warna latar belakang gelap */
    color: #fff; /* Warna teks putih */
}

.container {
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    flex-direction: column;
}

.navbar {
    background-color: #333;
    color: white;
    width: 100%;
    padding: 10px 0;
    text-align: center;
    position: fixed;
    top: 0;
    left: 0;
}

.navbar a {
    color: white;
    text-decoration: none;
    margin: 0 10px;
}

.form-container {
    background-color: #222; /* Warna latar belakang form yang lebih gelap */
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 255, 255, 0.5); /* Shadow dengan efek neon biru */
    width: 400px;
    margin: 20px;
}

.form-header {
    text-align: center;
    margin-bottom: 20px;
    color: #ff0; /* Warna kuning neon */
}

.form-row {
    margin-bottom: 15px;
}

.form-row label {
    display: block;
    margin-bottom: 5px;
    color: #ff0; /* Warna kuning neon */
}

.form-row input[type="text"],
.form-row input[type="date"],
.form-row select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #333; /* Warna latar belakang input yang lebih gelap */
    color: #0ff; /* Warna biru neon */
}

.button-btn,
.submit-btn {
    background-color: #FF0AD0;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
}

.submit-btn:hover {
    background-color: #FF0AD0;
}

    </style>
</head>

<body>
    <div class="navbar">
        <a href="index.php">Input Data</a>
        <a href="bukubesar.php">Tabel Jurnal Umum</a>
        <a href="aktiva_pasiva.php">Neraca Saldo</a>
    </div>
    <div class="container">
        <div class="form-container">
            <div class="form-header">
                <h2>Input Data Akuntansi</h2>
            </div>
            <form action="proses_input.php" method="post">
                <div class="form-row">
                    <label for="jenisAktivitas">Jenis Transaksi:</label>
                    <select id="jenisAktivitas" name="jenisAktivitas">
                        <option value="">Pilih Jenis Transaksi</option>
                        <?php while ($row = $activitiesResult->fetch_assoc()): ?>
                            <option value="<?php echo $row['id_reaksi']; ?>" <?php echo isset($_GET['jenis']) && $_GET['jenis'] === $row['id_reaksi'] ? 'selected' : ''; ?>>
                                <?php echo $row['nama_reaksi']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                    <input type="button" class="button-btn" value="Tampil Akun" onclick="showAccounts()">
                </div>
                <div class="form-row">
                    <label for="date">Tanggal:</label>
                    <input type="date" id="date" name="date" required>
                </div>
                <div class="form-row">
                    <label for="keteranganTrx">Keterangan Transaksi:</label>
                    <input type="text" id="keteranganTrx" name="keteranganTrx" placeholder="Keterangan Transaksi" required>
                </div>

                <!-- Add the dynamic account fields based on selected Jenis Aktivitas -->
                <?php foreach ($accountsInfo as $account): ?>
                    <div class="form-row">
                        <?php
                            $debetKredit = $account['debet_kredit'] === 'D' ? 'Debit' : 'Kredit';
                            echo "<label>{$account['nama_akun']} - {$debetKredit}</label>";
                        ?>
                        <input type="hidden" name="id_akun[]" value="<?php echo $account['id_akun']; ?>">
                        <input type="hidden" name="d_k[]" value="<?php echo $account['debet_kredit']; ?>">
                        <input type="text" name="nilai[]" placeholder="Nominal" required>
                    </div>
                <?php endforeach; ?>

                <!-- Submit button -->
                <div class="form-row">
                    <button type="submit" class="submit-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>


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


    <!-- Add AJAX function to reload the page with the selected "Jenis Aktivitas" -->
    <script>
        function showAccounts() {
            var jenisAktivitas = document.getElementById('jenisAktivitas').value;
            if (jenisAktivitas) {
                window.location.href = 'index.php?jenis=' + jenisAktivitas;
            }
        }
    </script>
    <script>
        window.onload = function () {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('success')) {
                alert("Data berhasil diupload!");
            } else if (urlParams.has('error')) {
                alert("Data gagal diupload. Silakan coba lagi.");
            }
        };
    </script>
</body>

</html>