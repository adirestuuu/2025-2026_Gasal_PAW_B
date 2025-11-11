<?php
require "koneksi.php";

$pesan_sukses = "";
$pesan_error = "";

if(isset($_POST['submit']) && $_SERVER["REQUEST_METHOD"]==="POST"){
    $judul_buku = $_POST['judul_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $harga = $_POST['harga'];
    $pilih_series = $_POST['id_series'];

    if(empty($judul_buku) || empty($tahun_terbit) || empty($pilih_series) || empty($harga)){
        $pesan_error = "Tolong isi semua field";
    } else {
        
        mysqli_begin_transaction($conn);
        $semua_berhasil = true;

        $sql_insert_buku = "INSERT INTO buku(judul_buku,tahun_terbit,harga,id_series) 
                            VALUES ('$judul_buku','$tahun_terbit','$harga','$pilih_series')";
        $query_insert_buku = mysqli_query($conn, $sql_insert_buku);

        if (!$query_insert_buku) {
            $semua_berhasil = false;
            $pesan_error = "Gagal nambah buku: " . mysqli_error($conn);
        } else {
            $sql_update_series = "UPDATE series SET jumlah_buku = jumlah_buku + 1 
                                  WHERE id_series = $pilih_series";
            $query_update_series = mysqli_query($conn, $sql_update_series);

            if (!$query_update_series) {
                $semua_berhasil = false;
                $pesan_error = "Buku ditambah, tapi gagal update hitungan series: " . mysqli_error($conn);
            }
        }

        if ($semua_berhasil) {
            mysqli_commit($conn);
            $pesan_sukses = "Data buku berhasil ditambahkan (dan series di-update)!";
        } else {
            mysqli_rollback($conn);
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Buku</title>
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
        <h2>Tambah Buku Baru</h2>
        
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

        <form action="form_tambah_buku.php" method="post">
            <label for="judul_buku">Judul Buku:</label>
            <input type="text" name="judul_buku" id="judul_buku" required>

            <label for="tahun_terbit">Tahun Terbit:</label>
            <input type="number" name="tahun_terbit" id="tahun_terbit" required>

            <label for="harga">Harga:</label>
            <input type="number" name="harga" id="harga" required>

            <label for="id_series">Pilih Series:</label>
            <select name="id_series" id="id_series" required>
                <option value="">-- Pilih Series --</option>
                <?php
                    $series = mysqli_query($conn,'select * from series');
                    if(mysqli_num_rows($series)>0){
                        while($row = mysqli_fetch_assoc($series)){
                           echo" <option value='".$row['id_series']."'>".$row['nama_series']."</option>";
                        }
                    }
                ?>
            </select>

            <input type="submit" name="submit" value="Tambah Buku">

        </form>
    </div>
</body>
</html>