<?php
// Ganti 'function.php' dengan file koneksi Anda (misal: config.php)
require 'function.php'; 
// Ganti 'cek.php' dengan file yang memeriksa sesi login Anda
require 'cek.php'; 

// Ambil semua data barang/konten dari database
$query = "SELECT * FROM barang";
$result = mysqli_query($conn, $query);

// Cek apakah ada barang yang stoknya 0 untuk notifikasi (opsional)
$queryStokHabis = "SELECT * FROM barang WHERE Stock = 0";
$resultStokHabis = mysqli_query($conn, $queryStokHabis);
$adaStokHabis = mysqli_num_rows($resultStokHabis) > 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Manajemen Konten - Stok Barang</title>
    <link href="style.css" rel="stylesheet" />
</head>
<body>

    <div class="sidebar">
        <h2>PT. Kelompok Web</h2>
        <a class="nav-link active" href="index.php">Stok Barang</a>
        <a class="nav-link" href="masuk.php">Barang Masuk</a>
        <a class="nav-link" href="keluar.php">Barang Keluar</a>
        <a class="nav-link" href="about.php">Tentang Kami</a> <a class="nav-link" href="logout.php">Logout</a>
    </div>

    <div class="main-content">
        <header>
            <h1>Daftar Stok Barang</h1>
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
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            // Cek jika tidak ada data
                            if (mysqli_num_rows($result) === 0) {
                                echo '<tr><td colspan="5">Belum ada data.</td></tr>';
                            } else {
                                // Looping untuk menampilkan data
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $id = $row['idbarang'];
                                    $namaBarang = htmlspecialchars($row['namabarang']);
                                    $deskripsi = htmlspecialchars($row['deskripsi']);
                                    $stok = (int)$row['Stock'];
                            ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $namaBarang; ?></td>
                                <td><?= $deskripsi; ?></td>
                                <td class="<?= ($stok == 0) ? 'stok-habis' : ''; ?>">
                                    <?= ($stok == 0) ? 'Habis' : $stok; ?>
                                </td>
                                <td>
                                    <a href="edit.php?id=<?= $id; ?>" class="btn btn-warning">Edit</a>
                                    <a href="hapus.php?id=<?= $id; ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus barang ini?');">Hapus</a>
                                </td>
                            </tr>
                            <?php 
                                } // akhir while loop
                            } // akhir else
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
                <h2>Tambah Barang</h2>
                <span class="close-btn">&times;</span>
            </div>
            <div class="modal-body">
                <form action="tambah_barang.php" method="POST">
                    <div class="form-group">
                        <label for="namabarang">Nama Barang</label>
                        <input type="text" id="namabarang" name="namabarang" required>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label for="stock">Stok</label>
                        <input type="number" id="stock" name="stock" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>

    <script src="konfirmasi.js"></script>

    <?php if ($adaStokHabis): ?>
    <script>
        // Tampilkan alert sederhana saat halaman dimuat jika ada barang habis
        alert('PERHATIAN: Ada barang yang stoknya habis!');
    </script>
    <?php endif; ?>
</body>
</html>