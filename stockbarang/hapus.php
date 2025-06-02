<?php
require 'function.php';
require 'cek.php';  // Cek login atau otorisasi jika perlu

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Pastikan ID adalah angka untuk mencegah SQL injection
    if (is_numeric($id)) {
        // Query untuk menghapus barang berdasarkan id
        $query = "DELETE FROM barang WHERE idbarang = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('i', $id);
        
        if ($stmt->execute()) {
            // Jika berhasil, arahkan ke index.php dengan status sukses
            header('Location: index.php?status=sukses');
        } else {
            // Jika gagal, arahkan ke index.php dengan status gagal
            header('Location: index.php?status=gagal');
        }
    } else {
        // Jika ID tidak valid, redirect kembali ke index.php
        header('Location: index.php');
    }
} else {
    // Jika tidak ada ID di URL, redirect kembali ke index.php
    header('Location: index.php');
}
exit;  // Pastikan script berhenti setelah redirect
?>
