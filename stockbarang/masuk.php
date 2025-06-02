<?php
require 'function.php';
require 'cek.php';

// Ambil data barang masuk
$query = "SELECT m.idmasuk, b.namabarang, m.stock, m.keterangan, m.tanggal 
          FROM masuk m JOIN barang b ON m.idbarang = b.idbarang";
$result = mysqli_query($conn, $query);
if (!$result) {
    die('Error: ' . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Barang Masuk</title>
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <div class="sidebar">
        <h2>PT. Kelompok Web</h2>
        <a class="nav-link" href="index.php">Stok Barang</a>
        <a class="nav-link active" href="masuk.php">Barang Masuk</a>
        <a class="nav-link" href="keluar.php">Barang Keluar</a>
        <a class="nav-link" href="about.php">Tentang Kami</a> 
        <a class="nav-link" href="logout.php">Logout</a>       
    </div>

    <div class="main-content">
        <header>
            <h1>Barang Masuk</h1>
        </header>

        <div class="container">
            <div class="card">
                <div class="card-header">
                    <button id="tambahBtn" class="btn btn-primary">Tambah Barang</button>
                </div>
                <div class="card-body">
                    <table>
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Pengirim</th>
                                <th>Stok Masuk</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['namabarang']}</td>
                                        <td>{$row['keterangan']}</td>
                                        <td>{$row['stock']}</td>
                                        <td>{$row['tanggal']}</td>
                                        <td>
                                            <a href='edit_masuk.php?id={$row['idmasuk']}' class='btn btn-warning'>Edit</a>
                                            <a href='hapus_masuk.php?id={$row['idmasuk']}' class='btn btn-danger' onclick=\"return confirm('Yakin ingin menghapus?');\">Hapus</a>
                                        </td>
                                      </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
<div id="myModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Tambah Barang Masuk</h2>
            <span class="close-btn">&times;</span>
        </div>
        <div class="modal-body">
            <form method="POST" action="proses_masuk.php" class="form-input">
                <div class="form-group">
                    <label for="barang_id">Nama Barang:</label>
                    <select name="barang_id" required>
                        <option value="">-- Pilih Barang --</option>
                        <?php
                        $result_barang = mysqli_query($conn, "SELECT idbarang, namabarang FROM barang");
                        while ($row_barang = mysqli_fetch_assoc($result_barang)) {
                            echo "<option value='{$row_barang['idbarang']}'>{$row_barang['namabarang']}</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="penerima">Pengirim:</label>
                    <input type="text" name="penerima" placeholder="Nama Pengirim" required>
                </div>

                <div class="form-group">
                    <label for="stock">Jumlah Stok Masuk:</label>
                    <input type="number" name="stock" min="1" required placeholder="Masukkan jumlah">
                </div>

                <div class="form-group">
                    <button type="submit" name="tambah_barang" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>


    <script src="konfirmasi.js"></script>
</body>
</html>
