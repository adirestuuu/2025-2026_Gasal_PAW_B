<?php
require "koneksi.php";

if (isset($_GET['id_series'])) {
    $id_series = $_GET['id_series'];

    mysqli_begin_transaction($conn);
    $semua_berhasil = true;

    $sql_delete_buku = "DELETE FROM buku WHERE id_series = $id_series";
    $query_delete_buku = mysqli_query($conn, $sql_delete_buku);

    if (!$query_delete_buku) {
        $semua_berhasil = false;
        echo "Gagal hapus buku di series: " . mysqli_error($conn);
    } else {
        $sql_delete_series = "DELETE FROM series WHERE id_series = $id_series";
        $query_delete_series = mysqli_query($conn, $sql_delete_series);

        if (!$query_delete_series) {
            $semua_berhasil = false;
            echo "Gagal hapus series: " . mysqli_error($conn);
            if (mysqli_errno($conn) == 1451) { 
                echo "Series ini tidak bisa dihapus karena datanya masih dipakai di tabel 'detail_transaksi'. Hapus transaksi terkait terlebih dahulu.";
            }
        }
    }

    if ($semua_berhasil) {
        mysqli_commit($conn);
        header("Location: tabel_series.php");
        exit();
    } else {
        mysqli_rollback($conn);
        echo "<br><a href='tabel_series.php'>Kembali ke Tabel Series</a>";
    }

} else {
    header("Location: tabel_series.php");
    exit();
}
?>