<?php
require 'function.php';
require 'cek.php';

// Cek jika ada id yang dikirimkan lewat URL
if (isset($_GET['id'])) {
    $idkeluar = $_GET['id'];

    // Ambil data yang terkait dengan ID keluar
    $query_keluar = "SELECT * FROM keluar WHERE idkeluar = $idkeluar";
    $result_keluar = mysqli_query($conn, $query_keluar);
    $keluar = mysqli_fetch_assoc($result_keluar);

    if ($keluar) {
        // Ambil idbarang dan jumlah stock keluar
        $idbarang = $keluar['idbarang'];
        $jumlah_keluar = $keluar['stock'];

        // Mengembalikan stock barang ke tabel barang
        $query_barang = "UPDATE barang SET stock = stock + $jumlah_keluar WHERE idbarang = $idbarang";
        mysqli_query($conn, $query_barang);

        // Hapus data barang keluar dari tabel keluar
        $query_hapus = "DELETE FROM keluar WHERE idkeluar = $idkeluar";
        if (mysqli_query($conn, $query_hapus)) {
            header("Location: keluar.php?status=sukses");
        } else {
            header("Location: keluar.php?status=gagal");
        }
    } else {
        header("Location: keluar.php");
        exit;
    }
} else {
    header("Location: keluar.php");
    exit;
}
?>
