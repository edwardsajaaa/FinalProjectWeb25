<?php
require 'function.php'; // Koneksi ke database
require 'cek.php'; // Mengecek session atau autentikasi jika diperlukan

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $namabarang = mysqli_real_escape_string($conn, $_POST['namabarang']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $stock = (int)$_POST['stock'];

    // Validasi: Pastikan stock tidak kurang dari 0
    if ($stock < 0) {
        // Jika stock negatif, redirect dengan pesan error
        header("Location: index.php?status=stock_negatif");
        exit;
    }

    // Query untuk memasukkan data ke tabel barang
    $query = "INSERT INTO barang (namabarang, deskripsi, Stock) VALUES ('$namabarang', '$deskripsi', $stock)";

    // Eksekusi query
    if (mysqli_query($conn, $query)) {
        // Jika berhasil, redirect ke halaman stock dengan pesan sukses
        header("Location: index.php?status=sukses");
        exit;
    } else {
        // Jika gagal, redirect dengan pesan error
        header("Location: index.php?status=gagal");
        exit;
    }
} else {
    // Jika tidak ada data yang dikirimkan, redirect ke halaman utama
    header("Location: index.php");
    exit;
}
?>
