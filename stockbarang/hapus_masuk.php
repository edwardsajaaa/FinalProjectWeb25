<?php
require 'function.php'; // Koneksi ke database
require 'cek.php';      // Validasi akses

if (isset($_GET['id'])) {
    $idmasuk = intval($_GET['id']); // Casting ke integer untuk keamanan

    // Ambil data idbarang dan stock dari tabel masuk
    $query_select = "SELECT idbarang, stock FROM masuk WHERE idmasuk = ?";
    $stmt_select = mysqli_prepare($conn, $query_select);
    if ($stmt_select) {
        mysqli_stmt_bind_param($stmt_select, 'i', $idmasuk);
        mysqli_stmt_execute($stmt_select);
        mysqli_stmt_bind_result($stmt_select, $idbarang, $stock);
        mysqli_stmt_fetch($stmt_select);
        mysqli_stmt_close($stmt_select);

        // Jika data ditemukan
        if ($idbarang && $stock) {
            $query_update = "UPDATE barang SET stock = stock - ? WHERE idbarang = ?";
            $stmt_update = mysqli_prepare($conn, $query_update);
            if ($stmt_update) {
                mysqli_stmt_bind_param($stmt_update, 'ii', $stock, $idbarang);
                mysqli_stmt_execute($stmt_update);
                mysqli_stmt_close($stmt_update);
            }

            // Hapus data dari tabel masuk
            $query_delete = "DELETE FROM masuk WHERE idmasuk = ?";
            $stmt_delete = mysqli_prepare($conn, $query_delete);
            if ($stmt_delete) {
                mysqli_stmt_bind_param($stmt_delete, 'i', $idmasuk);
                mysqli_stmt_execute($stmt_delete);
                mysqli_stmt_close($stmt_delete);

                header('Location: masuk.php?message=success');
                exit();
            }
        } else {
            header('Location: masuk.php?message=not_found');
            exit();
        }
    }
} else {
    header('Location: masuk.php?message=invalid_id');
    exit();
}
