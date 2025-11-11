<?php
require "koneksi.php";

$series = mysqli_query($conn,"select * from series");

if(!$series){
    die ("query gagal".mysqli_error($conn));
}


?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Series</title>
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
        <h1>Tabel Data Series</h1>
        
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Nama</th>
                    <th>Jumlah Buku</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(mysqli_num_rows($series)>0){
                        while($row = mysqli_fetch_assoc($series)){
                            echo "<tr>";
                            echo "<td>".$row['id_series']."</td>";
                            echo "<td>".$row['nama_series']."</td>";
                            echo "<td>".$row['jumlah_buku']."</td>";
                            echo "<td>
                                <a href='form_edit_series.php?id_series=".$row['id_series']."' class='btn-edit'>Edit</a>
                                <a href='hapus_series.php?id_series=".$row['id_series']."' class='btn-hapus-link' 
                                    onclick=\"return confirm('Yakin mau hapus series \'".addslashes($row['nama_series'])."\'? SEMUA BUKU di series ini akan ikut terhapus!');\">
                                    Hapus
                                </a>
                                </td>";
                            echo "<tr>";

                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>