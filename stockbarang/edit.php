<?php
require 'function.php';
require 'cek.php';

if (isset($_GET['id'])) {
    $idbarang = $_GET['id'];
    $query = "SELECT * FROM barang WHERE idbarang = $idbarang";
    $result = mysqli_query($conn, $query);
    $barang = mysqli_fetch_assoc($result);

    if (!$barang) {
        header('Location: index.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $namabarang = $_POST['namabarang'];
        $deskripsi = $_POST['deskripsi'];
        $stock = $_POST['stock'];

        $update_query = "UPDATE barang SET namabarang='$namabarang', deskripsi='$deskripsi', Stock='$stock' WHERE idbarang = $idbarang";
        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            header('Location: index.php?status=sukses');
            exit;
        } else {
            $error_message = "Gagal memperbarui data barang.";
        }
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="sidebar">
        <h2>PT. Kelompok 5</h2>
        <a href="index.php">Stok Barang</a>
        <a class="active" href="#">Edit Barang</a>
        <a href="masuk.php">Barang Masuk</a>
        <a href="keluar.php">Barang Keluar</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="form-container">
            <h1>Edit Data Barang</h1>

            <?php if (isset($error_message)): ?>
                <div class="alert"><?= $error_message; ?></div>
            <?php endif; ?>

            <form action="edit.php?id=<?= $barang['idbarang']; ?>" method="POST">
                <label for="namabarang">Nama Barang</label>
                <input type="text" id="namabarang" name="namabarang" value="<?= $barang['namabarang']; ?>" required>

                <label for="deskripsi">Deskripsi</label>
                <input type="text" id="deskripsi" name="deskripsi" value="<?= $barang['deskripsi']; ?>" required>

                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" value="<?= $barang['Stock']; ?>" required>

                <button type="submit">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
