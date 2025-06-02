<?php
require 'function.php';

if (isset($_POST['tambah_barang_keluar'])) {
    $barang_id = mysqli_real_escape_string($conn, $_POST['barang_id']);
    $penerima = mysqli_real_escape_string($conn, $_POST['penerima']);
    $stock = intval($_POST['stock']);

    if ($stock > 0) {
        mysqli_begin_transaction($conn);

        try {
            // Cek stok
            $check = mysqli_query($conn, "SELECT stock FROM barang WHERE idbarang = '$barang_id'");
            if (!$check || mysqli_num_rows($check) == 0) {
                throw new Exception("Barang tidak ditemukan.");
            }

            $row = mysqli_fetch_assoc($check);
            $available = intval($row['stock']);

            if ($stock > $available) {
                throw new Exception("Stok tidak mencukupi. Tersedia: $available");
            }

            // Insert ke tabel keluar
            $insert = "INSERT INTO keluar (idbarang, penerima, stock, tanggal)
                       VALUES ('$barang_id', '$penerima', '$stock', NOW())";
            if (!mysqli_query($conn, $insert)) {
                throw new Exception("Gagal insert ke tabel keluar: " . mysqli_error($conn));
            }

            // Kurangi stok barang
            $update = "UPDATE barang SET stock = stock - $stock WHERE idbarang = '$barang_id'";
            if (!mysqli_query($conn, $update)) {
                throw new Exception("Gagal update stok barang: " . mysqli_error($conn));
            }

            mysqli_commit($conn);
            header("Location: keluar.php?status=sukses");
            exit();
        } catch (Exception $e) {
            mysqli_rollback($conn);
            header("Location: keluar.php?status=gagal&message=" . urlencode($e->getMessage()));
            exit();
        }
    } else {
        header("Location: keluar.php?status=gagal&message=" . urlencode("Jumlah stok harus lebih dari 0!"));
        exit();
    }
}
?>
