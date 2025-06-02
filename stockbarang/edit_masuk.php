<?php
session_start();

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari DB untuk form edit
if (isset($_GET['id'])) {
    $idmasuk = $_GET['id'];
    $query = "SELECT m.idmasuk, b.idbarang, b.namabarang, m.keterangan, m.stock 
              FROM masuk m
              JOIN barang b ON m.idbarang = b.idbarang
              WHERE m.idmasuk = '$idmasuk'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "ID barang masuk tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Edit Barang Masuk</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
    <div class="sidebar">
        <h2>PT. Kelompok Web</h2>
        <a href="index.php">Stok Barang</a>
        <a href="masuk.php">Barang Masuk</a>
        <a class="active" href="#">Edit Barang Masuk</a>
        <a href="keluar.php">Barang Keluar</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="form-container">
            <h1>Edit Barang Masuk</h1>

            <form method="POST" action="">
                <input type="hidden" name="idmasuk" value="<?= htmlspecialchars($row['idmasuk']) ?>">

                <label for="barang_id">Nama Barang</label>
                <select name="barang_id" id="barang_id" required>
                    <option value="">-- Pilih Barang --</option>
                    <?php
                    $barang_query = "SELECT idbarang, namabarang FROM barang";
                    $barang_result = mysqli_query($conn, $barang_query);
                    while ($barang = mysqli_fetch_assoc($barang_result)) {
                        $selected = ($barang['idbarang'] == $row['idbarang']) ? 'selected' : '';
                        echo "<option value='" . htmlspecialchars($barang['idbarang']) . "' $selected>" . 
                             htmlspecialchars($barang['namabarang']) . "</option>";
                    }
                    ?>
                </select>

                <label for="keterangan">Pengirim</label>
                <input type="text" id="keterangan" name="keterangan" value="<?= htmlspecialchars($row['keterangan']) ?>" required>

                <label for="stock">Jumlah Stok Masuk</label>
                <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($row['stock']) ?>" required>

                <button type="submit" name="updatebarang">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
