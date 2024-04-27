<?php
require_once 'dbconfig.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $conn->real_escape_string($_POST['date']);
    $keterangan = $conn->real_escape_string($_POST['keteranganTrx']);
    $id_akun = $_POST['id_akun'];
    $d_k = $_POST['d_k'];
    $nilai = $_POST['nilai'];

    // Insert into t_trx
    $trxQuery = "INSERT INTO t_trx (tgl, transaksi) VALUES ('$tanggal', '$keterangan')";
    if ($conn->query($trxQuery)) {
        $lastInsertedId = $conn->insert_id;

        // Insert into t_trx_detail
        for ($i = 0; $i < count($id_akun); $i++) {
            $id_akun_value = $id_akun[$i];
            $d_k_value = $d_k[$i];
            $nilai_value = $nilai[$i];

            $trxDetailQuery = "INSERT INTO t_trx_detail (id_trx, id_akun, d_k, nominal) 
                                VALUES ('$lastInsertedId', '$id_akun_value', '$d_k_value', '$nilai_value')";
            $conn->query($trxDetailQuery);
        }

        // Redirect to index.php with success message
        header("Location: index.php?success=1");
        exit();
    } else {
        // Redirect to index.php with error message
        header("Location: index.php?error=1");
        exit();
    }
}
?>