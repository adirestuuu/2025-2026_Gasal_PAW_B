<?php
require "koneksi.php";

if (isset($_GET['id_buku'])) {
    $id_buku = $_GET['id_buku'];

    $sql_get_series = "SELECT id_series FROM buku WHERE id_buku = $id_buku";
    $query_get_series = mysqli_query($conn, $sql_get_series);
    
    if (mysqli_num_rows($query_get_series) > 0) {
        $data_buku = mysqli_fetch_assoc($query_get_series);
        $id_series_buku = $data_buku['id_series'];

        mysqli_begin_transaction($conn);
        $semua_berhasil = true;

        $sql_delete_buku = "DELETE FROM buku WHERE id_buku = $id_buku";
        $query_delete_buku = mysqli_query($conn, $sql_delete_buku);

        if (!$query_delete_buku) {
            $semua_berhasil = false;
            echo "Buku gagal dihapus: " . mysqli_error($conn);
        } else {
            $sql_update_series = "UPDATE series SET jumlah_buku = jumlah_buku - 1 
                                  WHERE id_series = $id_series_buku";
            $query_update_series = mysqli_query($conn, $sql_update_series);

            if (!$query_update_series) {
                $semua_berhasil = false;
                echo "Gagal: " . mysqli_error($conn);
            }
        }

        if ($semua_berhasil) {
            mysqli_commit($conn);
            header("Location: tabel_buku.php");
            exit();
        } else {
            mysqli_rollback($conn);
        }
    } else {
        echo "Buku tidak ditemukan";
    }
} else {
    header("Location: tabel_buku.php");
    exit();
}
?>