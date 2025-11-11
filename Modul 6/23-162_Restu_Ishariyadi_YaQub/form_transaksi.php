<?php
require "koneksi.php";

$semua_buku = mysqli_query($conn, "SELECT id_buku, judul_buku, harga FROM buku ORDER BY judul_buku ASC");

if (!$semua_buku) {
    die("Query gagal: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Transaksi Baru</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    
    <nav>
        <a href="tabel_buku.php">Lihat Tabel Buku</a> 
        <a href="tabel_series.php">Lihat Tabel Series</a>
        <a href="form_tambah_buku.php">Tambah Buku</a>
        <a href="form_tambah_series.php">Tambah Series</a>
        <a href="form_transaksi.php" class="active">Tambah Transaksi</a>
    </nav>
    
    <div class="container">
        <h2>Tambah Transaksi Baru</h2>
        
        <form action="proses_transaksi.php" method="post">
            
            <label for="nama_pelanggan">Nama Pelanggan:</label>
            <input type="text" name="nama_pelanggan" id="nama_pelanggan" required>

            <hr>
            <h3>Detail Barang (Buku)</h3>
            
            <div id="detail_items_container">
                
                <div class="item-buku">
                    <label>Pilih Buku:</label>
                    <select name="id_buku[]" required>
                        <option value="">-- Pilih Buku --</option>
                        <?php
                            if (mysqli_num_rows($semua_buku) > 0) {
                                while ($buku = mysqli_fetch_assoc($semua_buku)) {
                                    echo "<option value='" . $buku['id_buku'] . "'>"
                                        . $buku['judul_buku'] . " (Rp " . number_format($buku['harga']) . ")"
                                        . "</option>";
                                }
                            }
                        ?>
                    </select>

                    <label>Jumlah:</label>
                    <input type="number" name="jumlah[]" placeholder="Jumlah" min="1" value="1" required>
                    
                    <button type="button" class="btn-hapus" onclick="hapusItem(this)">Hapus Item Ini</button>
                </div>

            </div>
            
            <button type="button" id="tambah_barang" class="btn-tambah">Tambah Barang Lain</button>
            <hr>
            
            <input type="submit" name="submit" value="Simpan Transaksi">
        </form>
    </div>

    <script>
        document.getElementById('tambah_barang').onclick = function() {
            var container = document.getElementById('detail_items_container');
            var template = document.querySelector('.item-buku');
            var barisBaru = template.cloneNode(true);
            
            barisBaru.querySelector('select').selectedIndex = 0;
            barisBaru.querySelector('input[type="number"]').value = 1;
            
            container.appendChild(barisBaru);
        };

        function hapusItem(tombol) {
            var container = document.getElementById('detail_items_container');
            
            if (container.children.length > 1) {
                tombol.parentElement.remove();
            } else {
                alert('Minimal harus ada 1 barang dalam transaksi.');
            }
        }
    </script>
</body>
</html>