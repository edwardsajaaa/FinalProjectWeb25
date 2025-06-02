<?php
require 'function.php';
require 'cek.php';

// Query untuk mengambil data barang
$query = "SELECT * FROM barang"; // Pastikan query ini sesuai dengan kebutuhan Anda
$result = mysqli_query($conn, $query);

// Cek jika query berhasil
if (!$result) {
    die('Query Error: ' . mysqli_error($conn));
}
?>

<html>
<head>
  <title>Stock Barang</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
</head>

<body>
<div class="container">
    <h2>Stock Bahan</h2>
    <h4>(Inventory)</h4>
    <div class="data-tables datatable-dark">
        
        <!-- Masukkan table nya disini, dimulai dari tag TABLE -->
        <table id="mauexport" class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Barang</th>
                    <th>Deskripsi</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_assoc($result)) {
                    $stockStatusClass = ($row['Stock'] == 0) ? 'text-danger' : '';
                    $stockStatusText = ($row['Stock'] == 0) ? 'Habis' : $row['Stock'];
                ?>
                <tr>
                    <td><?= $i++; ?></td>
                    <td><?= $row['namabarang']; ?></td>
                    <td><?= $row['deskripsi']; ?></td>
                    <td class="<?= $stockStatusClass; ?>"><?= $stockStatusText; ?></td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
        
    </div>
</div>
    
<script>
$(document).ready(function() {
    $('#mauexport').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
    });
});
</script>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>

</body>
</html>
