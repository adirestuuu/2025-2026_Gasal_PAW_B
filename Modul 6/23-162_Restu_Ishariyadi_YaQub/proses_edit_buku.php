<?php
require "koneksi.php";

if(isset($_POST['submit'])){
    $id_buku = $_POST['id_buku'];
    $judul_buku = $_POST['judul_buku'];
    $tahun_terbit = $_POST['tahun_terbit'];
    $harga = $_POST['harga'];
    $id_series_baru = $_POST['id_series'];
    $id_series_lama = $_POST['id_series_lama'];

    if(empty($id_buku) || empty($judul_buku) || empty($tahun_terbit) || empty($harga) || empty($id_series_baru) || empty($id_series_lama)){
        die("Error: Data tidak lengkap.");
    }

    mysqli_begin_transaction($conn);
    $semua_berhasil = true;

    $sql_update_buku = "UPDATE buku SET 
                            judul_buku = '$judul_buku',
                            tahun_terbit = '$tahun_terbit',
                            harga = '$harga',
                            id_series = '$id_series_baru'
                        WHERE id_buku = $id_buku";
    
    $query_update_buku = mysqli_query($conn, $sql_update_buku);

    if (!$query_update_buku) {
        $semua_berhasil = false;
        echo "Gagal update buku: " . mysqli_error($conn);
    } else {
        if ($id_series_lama != $id_series_baru) {
            $sql_update_old = "UPDATE series SET jumlah_buku = jumlah_buku - 1 WHERE id_series = $id_series_lama";
            $query_update_old = mysqli_query($conn, $sql_update_old);
            
            if (!$query_update_old) {
                $semua_berhasil = false;
                echo "Gagal update hitungan series lama: " . mysqli_error($conn);
            }

            $sql_update_new = "UPDATE series SET jumlah_buku = jumlah_buku + 1 WHERE id_series = $id_series_baru";
            $query_update_new = mysqli_query($conn, $sql_update_new);
            
            if (!$query_update_new) {
                $semua_berhasil = false;
                echo "Gagal update hitungan series baru: " . mysqli_error($conn);
            }
        }
    }

    if ($semua_berhasil) {
        mysqli_commit($conn);
        header("Location: tabel_buku.php");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "<br><a href='tabel_buku.php'>Kembali ke Tabel Buku</a>";
    }

} else {
    header("Location: tabel_buku.php");
    exit();
}
?>