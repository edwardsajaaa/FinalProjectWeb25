<?php
session_start();

// Koneksi ke database
$conn = mysqli_connect("localhost", "root", "", "stockbarang");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data untuk form
if (isset($_GET['id'])) {
    $idkeluar = $_GET['id'];
    $query = "SELECT k.idkeluar, b.idbarang, b.namabarang, k.penerima, k.stock 
              FROM keluar k
              JOIN barang b ON k.idbarang = b.idbarang
              WHERE k.idkeluar = '$idkeluar'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
} else {
    echo "ID barang keluar tidak ditemukan!";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <title>Edit Barang Keluar</title>
    <link rel="stylesheet" href="edit.css"> <!-- gunakan edit.css biar konsisten -->
</head>
<body>
    <div class="sidebar">
        <h2>PT. Kelompok 5</h2>
        <a href="index.php">Stok Barang</a>
        <a href="masuk.php">Barang Masuk</a>
        <a href="keluar.php">Barang Keluar</a>
        <a class="active" href="#">Edit Barang Keluar</a>
        <a href="logout.php">Logout</a>
    </div>

    <div class="main">
        <div class="form-container">
            <h1>Edit Barang Keluar</h1>

            <form method="POST" action="">
                <input type="hidden" name="idkeluar" value="<?= htmlspecialchars($row['idkeluar']); ?>">
                <input type="hidden" name="stok_lama" value="<?= htmlspecialchars($row['stock']); ?>">

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

                <label for="penerima">Penerima</label>
                <input type="text" id="penerima" name="penerima" value="<?= htmlspecialchars($row['penerima']); ?>" required>

                <label for="stock">Jumlah Stok yang Keluar</label>
                <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($row['stock']); ?>" required>

                <button type="submit" name="updatebarang">Simpan Perubahan</button>
            </form>
        </div>
    </div>
</body>
</html>
