<?php
require "koneksi.php";

$pesan_error_fetch = "";
$id_buku = $_GET['id_buku'];

if (empty($id_buku)) {
    header("Location: tabel_buku.php");
    exit();
}

$sql_get_buku = "SELECT * FROM buku WHERE id_buku = $id_buku";
$query_get_buku = mysqli_query($conn, $sql_get_buku);

if (mysqli_num_rows($query_get_buku) > 0) {
    $buku = mysqli_fetch_assoc($query_get_buku);
} else {
    $pesan_error_fetch = "Data buku tidak ditemukan.";
    $buku = null;
}

$series = mysqli_query($conn, 'select * from series');
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Buku</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="tabel_buku.php">Lihat Tabel Buku</a> 
        <a href="tabel_series.php">Lihat Tabel Series</a>
        <a href="form_tambah_buku.php">Tambah Buku</a>
        <a href="form_tambah_series.php">Tambah Series</a>
        <a href="form_transaksi.php">Tambah Transaksi</a>
    </nav>
    
    <div class="container">
        <h2>Edit Buku</h2>
        
        <?php if ($buku): ?>
        <form action="proses_edit_buku.php" method="post">
            <input type="hidden" name="id_buku" value="<?php echo $buku['id_buku']; ?>">
            <input type="hidden" name="id_series_lama" value="<?php echo $buku['id_series']; ?>">

            <label for="judul_buku">Judul Buku:</label>
            <input type="text" name="judul_buku" id="judul_buku" value="<?php echo $buku['judul_buku']; ?>" required>

            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" value="<?php echo $buku['tahun_terbit']; ?>" required>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" value="<?php echo $buku['harga']; ?>" required>

            <label for="id_series">Pilih Series:</label>
            <select name="id_series" id="id_series" required>
                <option value="">-- Pilih Series --</option>
                <?php
                    if(mysqli_num_rows($series) > 0){
                        while($row = mysqli_fetch_assoc($series)){
                            $selected = ($row['id_series'] == $buku['id_series']) ? 'selected' : '';
                            echo "<option value='".$row['id_series']."' $selected>".$row['nama_series']."</option>";
                        }
                    }
                ?>
            </select>

            <input type="submit" name="submit" value="Simpan Perubahan">
        </form>
        <?php else: ?>
            <p style="color:red;"><?php echo $pesan_error_fetch; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>