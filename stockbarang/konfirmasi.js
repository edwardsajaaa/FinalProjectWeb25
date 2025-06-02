// Tunggu hingga seluruh dokumen HTML selesai dimuat
document.addEventListener('DOMContentLoaded', function() {

    // Ambil elemen-elemen modal
    const modal = document.getElementById('myModal');
    const tambahBtn = document.getElementById('tambahBtn');
    const closeBtn = document.querySelector('.close-btn');

    // Ketika tombol "Tambah Barang" diklik, tampilkan modal
    tambahBtn.onclick = function() {
        modal.style.display = 'block';
    }

    // Ketika tombol 'x' (span) diklik, sembunyikan modal
    closeBtn.onclick = function() {
        modal.style.display = 'none';
    }

    // Ketika user mengklik di luar area modal, sembunyikan modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});