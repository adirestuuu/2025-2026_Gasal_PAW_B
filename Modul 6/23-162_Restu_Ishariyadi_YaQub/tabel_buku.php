<?php

require "koneksi.php";

$buku = mysqli_query($conn,"select b.*,s.nama_series from  buku b join series s on b.id_series = s.id_series");

if(!$buku){
    die ("query gagal".mysqli_error($conn));
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Data Buku</title>
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
        <h1>Tabel Data Buku</h1>
        
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>Judul Buku</th>
                    <th>Tahun Terbit</th>
                    <th>Nama Series</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(mysqli_num_rows($buku)>0){
                        while($row = mysqli_fetch_assoc($buku)){
                            echo "<tr>";
                            echo "<td>".$row['id_buku']."</td>";
                            echo "<td>".$row['judul_buku']."</td>";
                            echo "<td>".$row['tahun_terbit']."</td>";
                            echo "<td>".$row['nama_series']."</td>";
                            echo "<td>
                                    <a href='form_edit_buku.php?id_buku=".$row['id_buku']."' class='btn-edit'>Edit</a>
                                    <a href='hapus_buku.php?id_buku=".$row['id_buku']."' class='btn-hapus-link' 
                                    onclick=\"return confirm('Yakin mau hapus buku \'".addslashes($row['judul_buku'])."\'?');\">
                                    Hapus
                                    </a>
                                </td>";
                            echo "</tr>";
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>