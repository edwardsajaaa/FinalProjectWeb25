<?php
require 'function.php';
date_default_timezone_set('Asia/Jakarta');

if (isset($_POST['tambah_barang'])) {
    $barang_id = $_POST['barang_id'];
    $penerima = $_POST['penerima'];
    $tanggal = date('Y-m-d H:i:s');
    $stock = (int) $_POST['stock'];

    // Masukkan data ke tabel masuk
    $query_masuk = "INSERT INTO masuk (idbarang, keterangan, tanggal, stock) VALUES ('$barang_id', '$penerima', '$tanggal', '$stock')";
    $insert = mysqli_query($conn, $query_masuk);

    if ($insert) {
        // Tambah stok ke tabel barang
        $query_update_barang = "UPDATE barang SET stock = stock + $stock WHERE idbarang = '$barang_id'";
        $update = mysqli_query($conn, $query_update_barang);

        if ($update) {
            header("Location: masuk.php");
            exit();
        } else {
            echo "Gagal update stok barang: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal menambahkan data barang masuk: " . mysqli_error($conn);
    }
}
?>