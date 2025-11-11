<?php
require "koneksi.php";

$pesan_error_fetch = "";
$id_series = $_GET['id_series'];

if (empty($id_series)) {
    header("Location: tabel_series.php");
    exit();
}

$sql_get_series = "SELECT * FROM series WHERE id_series = $id_series";
$query_get_series = mysqli_query($conn, $sql_get_series);

if (mysqli_num_rows($query_get_series) > 0) {
    $series = mysqli_fetch_assoc($query_get_series);
} else {
    $pesan_error_fetch = "Data series tidak ditemukan.";
    $series = null;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Series</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <a href="tabel_buku.php">Lihat Tabel Buku</a> 
        <a href="tabel_series.php" class="active">Lihat Tabel Series</a>
        <a href="form_tambah_buku.php">Tambah Buku</a>
        <a href="form_tambah_series.php">Tambah Series</a>
        <a href="form_transaksi.php">Tambah Transaksi</a>
    </nav>
    
    <div class="container">
        <h2>Edit Series</h2>
        
        <?php if ($series): ?>
        <form action="proses_edit_series.php" method="post">
            <input type="hidden" name="id_series" value="<?php echo $series['id_series']; ?>">

            <label for="nama_series">Nama series:</label>
            <input type="text" name="nama_series" id="nama_series" value="<?php echo $series['nama_series']; ?>" required>

            <label>Jumlah buku:</label>
            <input type="number" value="<?php echo $series['jumlah_buku']; ?>" disabled>
            
            <input type="submit" name="submit" value="Simpan Perubahan">
        </form>
        <?php else: ?>
            <p style="color:red;"><?php echo $pesan_error_fetch; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>