<?php
require "koneksi.php";

$pesan_sukses = "";
$pesan_error = "";

if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"]==="POST"){
    $nama_series = $_POST['nama_series'];

    if(empty($nama_series)){
        $pesan_error = "Nama series tidak boleh kosong";
    } else {
        $insert_series = mysqli_query($conn,"INSERT INTO series(nama_series,jumlah_buku) VALUES ('$nama_series', 0)");
        
        if($insert_series){
            $pesan_sukses = "Data series baru berhasil ditambahkan.";
        }else{
            $pesan_error = "Data tidak berhasil ditambahkan: " . mysqli_error($conn);
        };
    }
};

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Series</title>
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
        <h2>Tambah Series Baru</h2>

        <?php if(!empty($pesan_sukses)): ?>
            <div style="color: green; background: #eafaea; border: 1px solid green; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <?php echo $pesan_sukses; ?>
            </div>
        <?php endif; ?>
        <?php if(!empty($pesan_error)): ?>
            <div style="color: red; background: #fdeaea; border: 1px solid red; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
                <?php echo $pesan_error; ?>
            </div>
        <?php endif; ?>

        <form action="form_tambah_series.php" method="post">
            <label for="nama_series">Nama Series:</label>
            <input type="text" name="nama_series" id="nama_series" required>

            <input type="submit" name="submit" value="Tambah Series">
        </form>
    </div>
</body>
</html>